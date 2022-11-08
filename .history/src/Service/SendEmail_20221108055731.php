<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;
use Symfony\Bridge\Twig\Mime\BodyRenderer;

use App\Entity\User;

class SendEmail extends TemplatedEmail

{
    public function sendEmail(MailerInterface $mailer, User $user): Response
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
            ->text("Tu contraseña es: {{$user->getPassword()}}")
            ->html('<p>Prueba{{$user->getPassword()}}</p>');
            // path of the Twig template to render
            // ->htmlTemplate('mail/index.html.twig')

            // pass variables (name => value) to the template
            // ->context([
            //     'firstname' => $user->getFirstname(),
            //     'password' => $user->getPassword(),
            // ])
            ;
        // $path = __DIR__ . '/templates/mail/index.html.twig';
        // $loader = new \Twig\Loader\FilesystemLoader($path);


        // $twigEnv = new Environment($loader);

        // $twigBodyRenderer = new BodyRenderer($twigEnv);

        // $twigBodyRenderer->render($email);

        $mailer->send($email);
        
        dump('Enviado');die;

    }
}