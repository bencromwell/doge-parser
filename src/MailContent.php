<?php

namespace Parser;

class MailContent
{

    /** @var Item[] */
    protected $items = [];

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
        $content = '';
        $content .= 'Found ' . count($this->items) . ' new items.<br>' . PHP_EOL;
        $content .= '<ul>';

        foreach ($this->items as $item) {
            $content .= '<li>';
            $content .= $item->name . '<br>' . PHP_EOL;
            $content .= '<img src="' . $item->imageHref . '"><br>' . PHP_EOL;

            if ($item->hasDescription()) {
                $content .= '<p>' . nl2br($item->description) . '</p>' . PHP_EOL;
            }

            if ($item->hasPrice()) {
                $content .= '<strong>' . $item->price . '</strong>' . PHP_EOL;
            }

            $content .= $item->href . PHP_EOL . PHP_EOL;
            $content .= '</li>';
        }

        $content .= '</ul>';

        return $content;
    }

}
