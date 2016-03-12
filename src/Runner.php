<?php

namespace Parser;

class Runner
{

    /** @var Parser */
    private $parser;

    /** @var ItemMapper */
    private $mapper;

    /** @var MailContent */
    private $mailContent;

    /** @var Mailer */
    private $mailer;

    /**
     * @param Parser      $parser
     * @param ItemMapper  $mapper
     * @param MailContent $mailContent
     * @param Mailer      $mailer
     */
    public function __construct(Parser $parser, ItemMapper $mapper, MailContent $mailContent, Mailer $mailer)
    {
        $this->parser = $parser;
        $this->mapper = $mapper;
        $this->mailContent = $mailContent;
        $this->mailer = $mailer;
    }

    /**
     * @param string[] $urls
     */
    public function run($urls)
    {
        $this->parser->parseUrls($urls);

        $foundNewItems = 0;

        $foundItems = $this->parser->getItems();

        foreach ($foundItems as $newItem) {
            $exists = $this->mapper->getItemForHref($newItem->href);

            if (!$exists) {
                $foundNewItems++;
                $this->mapper->saveItem($newItem);
                $this->mailContent->addItem($newItem);
            }
        }

        if ($foundNewItems > 0) {
            $this->mailer->sendMail($this->mailContent->getOutput());
        }
    }

}
