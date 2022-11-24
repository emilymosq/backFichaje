<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


use App\Entity\Salida;
use App\Entity\User;
use App\Repository\SalidaRepository;

class ApiSalidaController extends AbstractController
{

    public function __controller(SalidaRepository $salidaRepository) 
    {
        $this->salidaRepository = $salidaRepository;
    }

    #[Route('/api/salida', name: 'app_api_salida',  methods: ['POST'])]
    public function crear(Request $request, ManagerRegistry $doctrine): JsonResponse
    {   
        $data = json_decode($request->getContent(), true);
        
        $fecha_publicacion = $data['fecha_publicacion'];
        $comentario = $data['comentario'];
        $locacion = $data['locacion'];
        $userId = $data['user'];
    
        $salida = new Salida();

        $datetime = \DateTime::createFromFormat('d-m-Y H:i:s', $fecha_publicacion);
        

        $salida->setFechaPublicacion($datetime);
        $salida->setComentario($comentario);
        $salida->setLocacion($locacion);
        


        $em = $doctrine->getManager();
        $user = $this->getUsuario($userId, $doctrine);
        $salida->setUser($user);
        $em->persist($salida);
        $em->flush();

        $response = $salida->getId();


        return $this->json($response, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*', 'Access-Control-Allow-Methods'=> 'POST,OPTIONS']);
    }

    public function getUsuario(int $id, ManagerRegistry $doctrine){

        $em = $doctrine->getManager();
        $usuario = $em->getRepository(User::class)->find($id);
        return $usuario;
    }
}
