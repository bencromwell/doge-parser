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
                $name = $item->properties['name'][0];

                $imageUrl = null;
                foreach ($item->properties['image'] as $image) {
                    if (!empty($image)) {
                        $imageUrl = $image;
                        continue;
                    }
                }

                $description = $item->properties['description'][0];
                $price = $item->properties['price'][0];

                $item = new Item($name, $url, $imageUrl);

                $item->setDescription($description)->setPrice($price);

                $this->items[] = $item;
            }
        }
    }

}
