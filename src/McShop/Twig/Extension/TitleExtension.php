<?php
namespace McShop\Twig\Extension;

use McShop\Twig\Title;

class TitleExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /** @var Title */
    private $title;

    /**
     * TitleExtension constructor.
     * @param Title $title
     */
    public function __construct(Title $title)
    {
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function getGlobals()
    {
        return [
            'title' => $this->title
        ];
    }


}