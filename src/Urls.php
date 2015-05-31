<?php

namespace Dogs;

class Urls
{

    /** @var string */
    private $baseUrl;

    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return array
     */
    public function getUrls()
    {
        $urls      = [];
        $centreUrl = $this->baseUrl . 'rehoming/dogs/filters/man~~~~~n~';
        $pagedUrl  = $centreUrl . '/page/';

        $urls[] = $centreUrl;

        for ($i = 2; $i <= 5; $i++) {
            $urls[] = $pagedUrl . $i;
        }

        return $urls;
    }

}
