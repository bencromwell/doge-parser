<?php

namespace Parser;

class MailContent
{

    /** @var Item[] */
    protected $items = [];

    /** @var \Twig_Template */
    protected $twig;

    /**
     * @param \Twig_Template $twig
     */
    public function __construct(\Twig_Template $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->twig->render(['items' => $this->items]);
    }

}
