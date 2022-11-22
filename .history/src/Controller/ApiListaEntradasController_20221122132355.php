<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiListaEntradasController extends AbstractController
{
    #[Route('/api/lista/entradas', name: 'app_api_lista_entradas')]
    public function index(): Response
    {
        return $this->render('api_lista_entradas/index.html.twig', [
            'controller_name' => 'ApiListaEntradasController',
        ]);
    }
}
