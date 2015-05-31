<?php

namespace Dogs;

use Zend\Mail\Message as MailMessage;
use Zend\Mail\Transport\Sendmail;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Mime;
use Zend\Mime\Part;

class Mailer
{

    /** @var string */
    protected $from;

    /** @var string|array */
    protected $to;

    /** @var string */
    protected $subject;

    /**
     * @param string $from
     * @param string|array $to
     * @param string $subject
     */
    public function __construct($from, $to, $subject)
    {
        $this->from    = $from;
        $this->to      = $to;
        $this->subject = $subject;
    }

    /**
     * @param string $htmlBody
     */
    public function sendMail($htmlBody)
    {
        $zendMail = new MailMessage();
        $zendMail->setFrom($this->from);
        $zendMail->setTo($this->to);
        $zendMail->setSubject($this->subject);

        $htmlPart = new Part($htmlBody);
        $htmlPart->setType(Mime::TYPE_HTML);

        $text = new Part('');
        $text->setType(Mime::TYPE_TEXT);

        $body = new MimeMessage();
        $body->setParts([$text, $htmlPart]);

        $zendMail->setBody($body);

        $transport = new Sendmail();
        $transport->send($zendMail);
    }

}
