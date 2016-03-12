<?php

require ('vendor/autoload.php');
require ('simplehtmldom_1_5/simple_html_dom.php');

$config = require('config/config.php');

$dbh = new \Aura\Sql\ExtendedPdo(
    'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'],
    $config['db']['user'],
    $config['db']['pass']
);

foreach ($config['instances'] as $id => $instance) {

    $parser = new \Parser\MicroDataParser(
        $instance['base_url'],
        $instance['results_selector'],
        $instance['name_selector'],
        $instance['link_selector']
    );

    $mapper = new \Parser\ItemMapper($dbh, $id);

    $mailContent = new \Parser\MailContent();

    $mailer = new \Parser\Mailer(
        $config['email']['from'],
        $config['email']['to'],
        $config['email']['subject']
    );

    $runner = new \Parser\Runner($parser, $mapper, $mailContent, $mailer);

    $runner->run($instance['urls']);
}
