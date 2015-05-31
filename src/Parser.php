<?php

namespace Dogs;

class Parser
{

    /** @var string */
    private $baseUrl;

    /** @var Doge[] */
    private $doges;

    /** @var Doge[] */
    private $newDoges;

    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl)
    {
        $this->baseUrl  = $baseUrl;
        $this->doges    = [];
        $this->newDoges = [];
    }

    /**
     * @param string[] $urls
     */
    public function parseUrls(array $urls)
    {
        foreach ($urls as $url) {
            $this->parseUrl($url);
        }
    }

    /**
     * @param string $url
     */
    public function parseUrl($url)
    {
        $html = str_get_html(file_get_contents($url));
        $results = $html->find('#BodyContent_DogList1_dvMainGrid a');

        /** @var \simple_html_dom_node $element */
        foreach ($results as $element) {

            $name = $element->find('h3')[0]->innertext();
            $isNew = count($element->find('.label--new')) > 0;
            $link = $this->baseUrl . $element->href;
            $image = $element->find('img')[0]->src;
            $image = $this->baseUrl . $image;

            $doge = new Doge($name, $isNew, $link, $image);

            $this->doges[] = $doge;

            if ($isNew) {
                $this->newDoges[] = $doge;
            }
        }
    }

    /**
     * @return Doge[]
     */
    public function getDoges()
    {
        return $this->doges;
    }

    /**
     * @return Doge[]
     */
    public function getNewDoges()
    {
        return $this->newDoges;
    }

}
