<?php

namespace App\Controller;

use App\Entity\Entrada;
use App\Entity\Salida;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;


class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(PaginatorInterface $paginator, Request $request, ManagerRegistry $doctrine)
    {
        $user = $this->getUser(); //OBTENGO AL USUARIO ACTUALMENTE LOGUEADO
        if ($user) {

            return $this->render('dashboard/index.html.twig', []);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}

/*$fecha_formato = \DateTime::createFromFormat('d/m/Y, H:i:s', $fecha_publicacion);*/