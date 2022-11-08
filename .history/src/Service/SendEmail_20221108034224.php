<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use App\Entity\User;

class SendEmail

{
    public function sendEmail(MailerInterface $mailer, User $user ): Response
    {
        $email = (new Email())
            ->from('info@coderf5.es')
            // ->to('cristy.si@gmail.com')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject("Datos de acceso a la app de fichaje")
            ->text("Tu contraseña es: "+$user->getPassword())
            ->html('<p>Tu contraseña es: '$user->getPassword()</p>');

        $mailer->send($email);

        dump('Enviado');die;

    }
}