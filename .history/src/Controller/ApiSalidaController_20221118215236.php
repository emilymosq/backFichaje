<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiSalidaController extends AbstractController
{
    #[Route('/api/salida', name: 'app_api_salida')]
    public function index(): Response
    {
        return $this->render('api_salida/index.html.twig', [
            'controller_name' => 'ApiSalidaController',
        ]);
    }
}
