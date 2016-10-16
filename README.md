This small project began life as a script to parse the Manchester Dogs Home's website for new dogs. They attached a "new" label to each dog that was added to the site, but it wasn't consistent and it was difficult to see when a new dog had actually been added.

Later on I was looking for a particular rowing machine on Gumtree, and to say their email notifications are slow would be a massive understatement. 

This particular brand was popular and listings would be sold before you'd seen them. I extended this parser to work with the microdata format that Gumtree uses and to be far more generic than just the dogs.

An example config for Gumtree is below:

```
<?php

return [
    'email' => [
        'from'    => 'noreply@example.com',
        'to'      => ['you@example.com'],
        'subject' => 'New Stuff',
    ],
    'db' => [
        'name' => 'parser',
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
    ],
    'instances' => [
        'gumtree_foobars' => [
            'urls' => [
                'https://www.gumtree.com/search?page=1&guess_search_category=all&sort=date&q=foobar&distance=50&search_category=all&search_location=YOUR_POSTCODE',
            ],
            'base_url' => 'https://www.gumtree.com',
            'results_selector' => 'article.listing-maxi',
            'link_selector' => 'a.listing-link[itemprop=url]',
            'name_selector' => 'h2.listing-title[itemprop=name]',
        ],
    ],
];
```

You would install this project as a cron to run as often as you want. It cycles over the `instances` in the config and indexes the items into its database using the instance key as a namespace. 

The `results_selector` is the root element for each item on the page. It will loop over each one it finds and find `http://schema.org/Product` items to extract information from.
