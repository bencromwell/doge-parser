<?php

namespace Parser;

use linclark\MicrodataPHP\MicrodataPhp;

class MicroDataParser extends Parser
{

    public function parseUrl($url)
    {
        $md = new MicrodataPhp($url);
        $data = $md->obj();

        foreach ($data->items as $item) {
            if ($item->type[0] === 'http://schema.org/Product' && $item->properties['url'][0] !== '') {

                $url = $this->baseUrl . $item->properties['url'][0];
                $name = $this->valueFromProperty($item, 'name', '');

                $imageUrl = null;
                foreach ($item->properties['image'] as $image) {
                    if (!empty($image)) {
                        $imageUrl = $image;
                        continue;
                    }
                }

                $description = $this->valueFromProperty($item, 'description');
                $price = $this->valueFromProperty($item, 'price');

                $item = new Item($name, $url, $imageUrl);

                if (!is_null($description)) {
                    $item->setDescription($description);
                }

                if (!is_null($price)) {
                    $item->setPrice($price);
                }

                $this->items[] = $item;
            }
        }
    }

    /**
     * @param object $item
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    private function valueFromProperty($item, $key, $default = null)
    {
        return isset($item->properties[$key]) ? $item->properties[$key][0] : $default;
    }

}
