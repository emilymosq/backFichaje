<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use App\Repository\UserRepository;

#[Route('/api')]

class UserRegisterController extends AbstractController
{
    #[Route('/registeruser', name: 'app_user_register', methods: ["POST"])]
    public function userRegister(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setFirstname($request->request->get('firstname'));
        $user->setLastname($request->request->get('lastname'));
        $user->setEmail($request->request->get('email'));
        $user->setPassword($request->request->get('password'));
        $user->setActive($request->request->get('active')); //ver si es si o get.

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json('Created new user successfully with id ' . $user->getId());
    }
}
