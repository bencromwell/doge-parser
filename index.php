<?php

require ('vendor/autoload.php');
require ('simplehtmldom_1_5/simple_html_dom.php');

$config = require('config/config.php');

$dbh = new \Aura\Sql\ExtendedPdo(
    'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'],
    $config['db']['user'],
    $config['db']['pass']
);

$loader = new Twig_Loader_Filesystem(__DIR__ . '/mail_templates');
$twig = new Twig_Environment($loader, array(
    'cache' => __DIR__ . '/cache',
));

$baseFont = 'font-family: \'Open Sans\', Arial, sans-serif; font-size: 100%; line-height: 1.6em;';

$twig->addGlobal('baseFont', $baseFont);
$twig->addGlobal('baseStyle', ' style="' . $baseFont . ' margin: 0; padding: 0;"');
$twig->addGlobal('hr', '<hr style="border: 1px #f6f6f6 solid">');

foreach ($config['instances'] as $id => $instance) {
    $twig->addGlobal('title', $id);

    $parser = new \Parser\MicroDataParser(
        $instance['base_url'],
        $instance['results_selector'],
        $instance['name_selector'],
        $instance['link_selector']
    );

    $mapper = new \Parser\ItemMapper($dbh, $id);

    $mailContent = new \Parser\MailContent($twig->loadTemplate('items.html.twig'));

    $mailer = new \Parser\Mailer(
        $config['email']['from'],
        $config['email']['to'],
        $config['email']['subject']
    );

    $runner = new \Parser\Runner($parser, $mapper, $mailContent, $mailer);

    $runner->run($instance['urls']);
}
