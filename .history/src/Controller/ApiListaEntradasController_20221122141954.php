<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


use App\Entity\Entrada;
use App\Entity\User;
use App\Repository\EntradaRepository;

class ApiListaEntradasController extends AbstractController
{
    #[Route('/api/lista/entradas', name: 'app_api_lista_entradas', methods: ['POST'])]

    public function misEntradas(Request $request, ManagerRegistry $doctrine, int $user) : Response 
    {

        $dataEntrada = json_decode($request->getContent(), true);
        
        $userId = $dataEntrada['user'];
        dump($userId);die;
        $em = $doctrine->getManager();
        $user = $em->getRepository(User::class)->find($userId);
        $entradas = $em->getRepository(Entrada::class)->findBy(['user' => $user]);
        
        $data = [];
        foreach ($entradas as $entrada) {
            $data[] = [
                'fecha_publicacion' => $entrada->getFechaPublicacion(),
                'comentario' => $entrada->getComentario(),
                'locacion' => $entrada->getLocacion(),
            ];
        }
        return $this->json($data);
    }
}
