<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class SendMail
{
    private $smtp_server;
    private $smtp_port;
    private $smtp_username;
    private $smtp_password;
    private $from;

    public function __construct()
    {
        $this->smtp_server = "smtp.gmail.com";
        $this->smtp_port = 587;
        $this->smtp_username = "imtinen.abrougui@esprit.tn";
        $this->smtp_password = "zsxtabehodciqbij";
        $this->from = "imtinen.abrougui@esprit.tn";
    }

    public function sendEmail($to, $subject, $html)
    {
        // Create a new Email instance
        $email = (new Email())
            ->from($this->from)
            ->to($to)
            ->subject($subject)
            ->html($html);

        // Create the Transport
        $transport = new EsmtpTransport($this->smtp_server, $this->smtp_port);
        $transport->setUsername($this->smtp_username);
        $transport->setPassword($this->smtp_password);

        // Create the Mailer using your created Transport
        $mailer = new \Symfony\Component\Mailer\Mailer($transport);

        // Send the Email
        $mailer->send($email);
    }
}