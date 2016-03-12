<?php

namespace Parser;

class MailContent
{

    protected $items = [];

    /**
     * @param Item $doge
     */
    public function addItem(Item $doge)
    {
        $this->items[] = $doge;
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        $content = '';
        $content .= 'Found ' . count($this->items) . ' new items.<br>' . PHP_EOL;
        $content .= '<ul>';

        foreach ($this->items as $item) {
            $content .= '<li>';
            $content .= $item->name . '<br>' . PHP_EOL;
            $content .= '<img src="' . $item->imageHref . '"><br>' . PHP_EOL;
            $content .= $item->href . PHP_EOL . PHP_EOL;
            $content .= '</li>';
        }

        $content .= '</ul>';

        return $content;
    }

}
