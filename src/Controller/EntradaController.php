<?php

namespace App\Controller;

use App\Entity\Entrada;
use App\Form\EntradaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class EntradaController extends AbstractController
{
    #[Route('/entrada', name: 'app_entrada')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $entrada = new Entrada();
        $form = $this->createForm(EntradaType::class, $entrada);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $entrada->setUser($user);
            $em = $doctrine->getManager();
            $em->persist($entrada);
            $em->flush();
            return $this->redirectToRoute('app_dashboard');
        }
        return $this->render('entrada/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/entrada/{id}", name="VerEntrada")
     */
    #[Route('/entrada/{id}', name: 'VerEntrada')]
    public function VerEntrada($id, Request $request, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $entrada = $em->getRepository(Entrada::class)->find($id);
        return $this->render('entrada/verEntrada.html.twig', ['entrada' => $entrada]);
    }

    #[Route('/mis-entradas', name: 'misEntradas')]
    public function MisEntradas(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $user = $this->getUser();
        $entradas = $em->getRepository(Posts::class)->findBy(['user' => $user]);
        return $this->render('posts/misEntradas.html.twig', ['entradas' => $entradas]);
    }
}
