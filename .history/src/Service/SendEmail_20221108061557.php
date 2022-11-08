<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Component\Mailer\Mailer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Entity\User;

class SendEmail

{
    public function sendEmail(MailerInterface $mailer, User $user ): Response
    {
        // $email = (new Email())
        //     ->from('info@coderf5.es')
        //     // ->to('cristy.si@gmail.com')
        //     ->to($user->getEmail())
        //     //->cc('cc@example.com')
        //     //->bcc('bcc@example.com')
        //     //->replyTo('fabien@example.com')
        //     //->priority(Email::PRIORITY_HIGH)
        //     ->subject("Datos de acceso a la app de fichaje")
        //     ->text("Tu contraseña es: {$user->getPassword()}")
        //     ->html('<p>See Twig integration for better HTML integration!</p>');

        // $mailer->send($email);

        // dump('Enviado');die;
        $email = (new TemplatedEmail())
            ->from(new Address('example-from@example.com', 'Example'))
            ->to('example-to@example.com')
            ->subject('Subject')
            ->htmlTemplate('emails/my-template.html.twig')
            ->context([]);

        // IMPORTANT: as you are using a customized mailer instance, you have to make the following
        // configuration as indicated in https://github.com/symfony/symfony/issues/35990.
        $loader = new FilesystemLoader('../templates/');
        $twigEnv = new Environment($loader);
        $twigBodyRenderer = new BodyRenderer($twigEnv);
        $twigBodyRenderer->render($email);

        // Sends the email
        $mailer->send($email);
    }
}