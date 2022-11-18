<?php

namespace App\Controller;

use App\Entity\Entrada;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/api')]
class ApiEntradaController extends AbstractController
{
    #[Route('/entrada', name: 'api_entrada',  methods: ["POST"])]
    public function crear(Request $request, ManagerRegistry $doctrine): Response
    {
        $entrada = new Entrada();
        $user = $this->getUser();
        $entrada->setUser($user->$request->get('user'));
        $entrada->setFechaPublicacion($entrada->$request->get('fecha_publicacion'));
        $entrada->setComentario($entrada->$request->get('comentario'));
        $entrada->setLocacion($entrada->$request->get('locacion'));

        $em = $doctrine->getManager();
        $em->persist($entrada);
        $em->flush();

        return $this->json('Ha fichado exitosamente ' . $entrada->getId());
    }

    // /**
    //  * @Route("/entrada/{id}", name="VerEntrada")
    //  */
    // #[Route('/entrada/{id}', name: 'verEntrada')]
    // public function VerEntrada($id, Request $request, ManagerRegistry $doctrine)
    // {
    //     $em = $doctrine->getManager();
    //     $entrada = $em->getRepository(Entrada::class)->find($id);
    //     return $this->render('entrada/verEntrada.html.twig', ['entrada' => $entrada]);
    // }

    // #[Route('/mis-entradas', name: 'misEntradas')]
    // public function MisEntradas(ManagerRegistry $doctrine)
    // {
    //     $em = $doctrine->getManager();
    //     $user = $this->getUser();
    //     $entradas = $em->getRepository(Entrada::class)->findBy(['user' => $user]);
    //     return $this->render('entrada/misEntradas.html.twig', ['entradas' => $entradas]);
    // }

}

