<?php

namespace Parser;

class Parser
{

    /** @var string */
    protected $baseUrl;

    /** @var Item[] */
    protected $items;

    /** @var string */
    private $resultsSelector;

    /** @var string */
    private $nameSelector;

    /** @var string */
    private $linkSelector;

    /**
     * @param string $baseUrl
     * @param string $resultsSelector
     * @param string $nameSelector
     * @param string $linkSelector
     */
    public function __construct($baseUrl, $resultsSelector, $nameSelector, $linkSelector)
    {
        $this->baseUrl = $baseUrl;
        $this->resultsSelector = $resultsSelector;
        $this->nameSelector = $nameSelector;
        $this->linkSelector = $linkSelector;
        $this->items = [];
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
        $results = $html->find($this->resultsSelector);

        // @todo get baseUrl from url
        $baseUrl = '';

        /** @var \simple_html_dom_node $element */
        foreach ($results as $element) {

            $name = $element->find($this->nameSelector)[0]->innertext();
            $link = $baseUrl . $element->href;


            $image = $element->find('img')[0]->src;
            $image = $baseUrl . $image;

            $item = new Item($name, $link, $image);

            $this->items[] = $item;
        }
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

}
