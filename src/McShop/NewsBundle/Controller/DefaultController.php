<?php

namespace McShop\NewsBundle\Controller;

use McShop\Core\Controller\BaseController;
use McShop\Core\Twig\Title;
use McShop\NewsBundle\Entity\Commentary;
use McShop\NewsBundle\Entity\Post;
use McShop\NewsBundle\Form\CommentaryType;
use McShop\NewsBundle\Repository\PostRepository;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package McShop\NewsBundle\Controller
 */
class DefaultController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $posts = $this->getDoctrine()
            ->getManagerForClass(Post::class)
            ->getRepository(Post::class)
            ->findAll(PostRepository::RETURN_QUERY)
            ->orderBy('p.id', 'DESC')
        ;

        $adapter = new DoctrineORMAdapter($posts);
        /** @var Post[] $posts */
        $posts = new Pagerfanta($adapter);
        $posts
            ->setMaxPerPage($request->get('per_page', 10))
            ->setCurrentPage($request->get('page', 1))
        ;

        $template = ':Default/News:index.html.twig';
        if ($request->query->get('simple', 0)) {
            $template = ':Default/News:index_simple.html.twig';
        }

        return $this->render($template, [
            'posts' => $posts
        ]);
    }

    /**
     * @param Post $post
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Post $post, Request $request)
    {
        $this->get(Title::class)
            ->setValue('news.show')
            ->setAttributes([
                '@subject@' => $post->getSubject(),
            ])
        ;
        $additional = [];
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $form = $this->createForm(CommentaryType::class);

            if ($request->isMethod($request::METHOD_POST)) {
                $form->handleRequest($request);

                if (!$form->isValid()) {
                    $errors = $this->get('validator')->validate($form);

                    foreach ($errors as $error) {
                        $this->addFlash('error', $error->getMessage());
                    }

                    return $this->redirectToRoute('', ['id' => $post->getId(), '_locale' => $request->getLocale()]);
                }

                /** @var Commentary $commentary */
                $commentary = $form->getData();
                $commentary
                    ->setNews($post)
                    ->setUser($this->getUser())
                ;

                $this->addFlash('info', $this->get('translator')->trans('news.comments.published'));


                $this->getDoctrine()->getManagerForClass(get_class($commentary))->persist($commentary);
                $this->getDoctrine()->getManagerForClass(get_class($commentary))->flush();

                return $this->redirectToRoute('mc_shop_news_view', ['id' => $post->getId(), '_locale' => $request->getLocale()]);
            }

            $additional['form'] = $form->createView();
        }

        $adapter = new DoctrineCollectionAdapter($post->getCommentaries());
        /** @var Commentary[] $commentaries */
        $commentaries = new Pagerfanta($adapter);
        $commentaries
            ->setMaxPerPage($request->get('per_page', 30))
            ->setCurrentPage($request->get('page', 1))
        ;

        $template = ':Default/News:view.html.twig';
        if ($request->query->get('simple', 0)) {
            $template = ':Default/News:view_simple.html.twig';
        }

        return $this->render($template, array_merge([
            'commentaries'  => $commentaries,
            'post'  => $post,
        ], $additional));
    }
}
