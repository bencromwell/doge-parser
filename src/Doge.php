<?php

namespace Dogs;

class Doge
{

    /** @var string */
    public $name;

    /** @var bool */
    public $isNew;

    /** @var string */
    public $href;

    /** @var string */
    public $imageHref;

    /**
     * @param string $name
     * @param bool   $isNew
     * @param string $href
     * @param string $imageHref
     */
    public function __construct($name, $isNew, $href, $imageHref)
    {
        $this->name      = $name;
        $this->isNew     = $isNew;
        $this->href      = $href;
        $this->imageHref = $imageHref;
    }

}
