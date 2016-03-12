<?php

namespace Parser;

class Item
{

    /** @var string */
    public $name;

    /** @var string */
    public $href;

    /** @var string|null */
    public $imageHref;

    /**
     * @param string $name
     * @param string $href
     * @param string|null $imageHref
     */
    public function __construct($name, $href, $imageHref = null)
    {
        $this->name = $name;
        $this->href = $href;
        $this->imageHref = $imageHref;
    }

}
