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

                $this->items[] = new Item($name, $url, $imageUrl);
            }
        }
    }

}
