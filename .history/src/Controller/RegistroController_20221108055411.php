<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

use App\Service\SendEmail;

class RegistroController extends AbstractController
{
    #[Route('/registro', name: 'app_registro')]
    public function index(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher, SendEmail $SendEmail, MailerInterface $mailer, TemplatedEmail $mail)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $user->setPassword($passwordHasher->hashPassword($user, $form['password']->getData()));
            $em->persist($user);
            $em->flush();

        
            $enviando = $SendEmail->sendEmail($mailer, $user, $mail);
            dump($enviando);die;
            /*
            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('emilymosq4@gmail.com', 'Jorge Benítez'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email
            */


            return $this->redirectToRoute('app_registro');
        }

        return $this->render('registro/index.html.twig', [
            'controller_name' => 'RegistroController',
            'formulario' => $form->createView()
        ]);
    }
}
