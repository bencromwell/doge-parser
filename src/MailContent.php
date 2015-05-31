<?php

namespace Dogs;

class MailContent
{

    protected $doges = [];

    /**
     * @param Doge $doge
     */
    public function addDoge(Doge $doge)
    {
        $this->doges[] = $doge;
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        $content = '';
        $content .= 'Found ' . count($this->doges) . ' new doges.<br>' . PHP_EOL;
        $content .= '<ul>';

        foreach ($this->doges as $doge) {
            $content .= '<li>';
            $content .= $doge->name . '<br>' . PHP_EOL;
            $content .= '<img src="' . $doge->imageHref . '"><br>' . PHP_EOL;
            $content .= $doge->href . PHP_EOL . PHP_EOL;
            $content .= '</li>';
        }

        $content .= '</ul>';

        return $content;
    }

}
