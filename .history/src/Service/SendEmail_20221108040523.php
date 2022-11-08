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
        $email = (new TemplatedEmail())
            ->from('info@coderf5.es')
            // ->to('cristy.si@gmail.com')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject("Datos de acceso a la app de fichaje")
            //->text("Tu contraseña es: {{$user->getPassword()}}")
            //->html('<p>Prueba{{$user->getPassword()}}</p>');
            // path of the Twig template to render
            ->htmlTemplate('mail/index.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'foo',
            ]);
        $mailer->send($email);

        dump('Enviado');die;

    }
}