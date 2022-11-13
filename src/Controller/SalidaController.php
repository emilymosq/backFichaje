<?php

namespace App\Controller;

use App\Entity\Salida;
use App\Form\SalidaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class SalidaController extends AbstractController
{
    #[Route('/salida', name: 'app_salida')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $salida = new Salida();
        $form = $this->createForm(SalidaType::class, $salida);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $salida->setUser($user);
            $em = $doctrine->getManager();
            $em->persist($salida);
            $em->flush();
            return $this->redirectToRoute('app_dashboard');
        }
        return $this->render('salida/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
