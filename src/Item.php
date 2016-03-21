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

    /** @var string */
    public $description;

    /** @var string */
    public $price;

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

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $price
     *
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasDescription()
    {
        return !is_null($this->description);
    }

    /**
     * @return bool
     */
    public function hasPrice()
    {
        return !is_null($this->price);
    }

}
