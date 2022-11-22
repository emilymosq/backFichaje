<?php

namespace App\Controller;

use App\Entity\Entrada;
use App\Form\EntradaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/api')]
class ApiEntradaController extends AbstractController
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
    #[Route('/entrada/{id}', name: 'verEntrada')]
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
        $entradas = $em->getRepository(Entrada::class)->findBy(['user' => $user]);
        return $this->render('entrada/misEntradas.html.twig', ['entradas' => $entradas]);
    }


    /**
     * @Route("/project", name="project_new", methods={"POST"})
     */
    public function new(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
   
        $project = new Project();
        $project->setName($request->request->get('name'));
        $project->setDescription($request->request->get('description'));
   
        $entityManager->persist($project);
        $entityManager->flush();
   
        return $this->json('Created new project successfully with id ' . $project->getId());
    }

}

