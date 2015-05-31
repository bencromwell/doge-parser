<?php

require ('vendor/autoload.php');
require ('simplehtmldom_1_5/simple_html_dom.php');

$config = require('config/config.php');

$dbh = new \Aura\Sql\ExtendedPdo(
    'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'],
    $config['db']['user'],
    $config['db']['pass']
);

$baseUrl = $config['baseUrl'];
$parser  = new \Dogs\Parser($baseUrl);

$parser->parseUrls((new \Dogs\Urls($baseUrl))->getUrls());

$dogeMapper    = new \Dogs\DogeMapper($dbh);
$content       = new \Dogs\MailContent();
$foundNewDoges = 0;

$newDoges = $parser->getNewDoges();

foreach ($newDoges as $newDoge) {
    // doges can be marked as new but we might already have them in our local DB
    $exists = $dogeMapper->getDogeForHref($newDoge->href);

    if (!$exists) {
        $foundNewDoges ++;
        $dogeMapper->saveDoge($newDoge);
        $content->addDoge($newDoge);
    }
}

if ($foundNewDoges > 0) {
    $mailer = new \Dogs\Mailer(
        $config['email']['from'],
        $config['email']['to'],
        $config['email']['subject']
    );

    $mailer->sendMail($content->getOutput());
}
