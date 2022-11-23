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
            $this->addFlash('exito', Salida::FICHAJE_EXITOSO);
            return $this->redirectToRoute('app_salida');
        }
        return $this->render('salida/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/salida/{id}', name: 'verSalida')]
    public function VerSalida($id, Request $request, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $salida = $em->getRepository(Salida::class)->find($id);
        return $this->render('salida/verSalida.html.twig', ['salida' => $salida]);
    }

    #[Route('/mis-salidas', name: 'misSalidas')]
    public function MisSalidas(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $user = $this->getUser();
        $salidas = $em->getRepository(Salida::class)->findBy(['user' => $user]);
        return $this->render('salida/misSalidas.html.twig', ['salidas' => $salidas]);
    }
}
