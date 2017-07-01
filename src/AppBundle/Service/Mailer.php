<?php

namespace AppBundle\Service;

class Mailer
{
    /** @var \Swift_Mailer $swiftMailer */
    private $swiftMailer;

    /** @var string $from */
    private $from;

    public function __construct(\Swift_Mailer $swiftMailer, $from)
    {
        $this->swiftMailer = $swiftMailer;
        $this->from = $from;
    }

    public function sendEmail($from = null, $to, $subject, $body)
    {
        $from = (null === $from)?$this->from:$from;

        /** @var \Swift_Mime_Message $message */
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body);
        $this->swiftMailer->send( $message );
    }
}