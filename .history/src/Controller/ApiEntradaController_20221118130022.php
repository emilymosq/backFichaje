<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiEntradaController extends AbstractController
{
    #[Route('/api/entrada', name: 'app_api_entrada')]
    public function index(): Response
    {
        return $this->render('api_entrada/index.html.twig', [
            'controller_name' => 'ApiEntradaController',
        ]);
    }
}
