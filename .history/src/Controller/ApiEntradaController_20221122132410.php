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
use DateTime;

class ApiEntradaController extends AbstractController
{
    public function __controller(EntradaRepository $entradaRepository) 
    {
        $this->entradaRepository = $entradaRepository;
    }

    #[Route('/api/entrada', name: 'app_api_entrada',  methods: ['POST'])]
    public function crear(Request $request, ManagerRegistry $doctrine): JsonResponse
    {   
        $data = json_decode($request->getContent(), true);
        
        $fecha_publicacion = $data['fecha_publicacion'];
        $comentario = $data['comentario'];
        $locacion = $data['locacion'];
        $userId = $data['user'];
    
        $entrada = new Entrada();

        $datetime = \DateTime::createFromFormat('d-m-Y H:i:s', $fecha_publicacion);
        

        $entrada->setFechaPublicacion($datetime);
        $entrada->setComentario($comentario);
        $entrada->setLocacion($locacion);
        


        $em = $doctrine->getManager();
        $user = $this->getUsuario($userId, $doctrine);
        $entrada->setUser($user);
        $em->persist($entrada);
        $em->flush();

        return $this->json('Ha fichado exitosamente', $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*', 'Access-Control-Allow-Methods'=> 'POST,OPTIONS']);
    }

    public function getUsuario(int $id, ManagerRegistry $doctrine){

        $em = $doctrine->getManager();
        $usuario = $em->getRepository(User::class)->find($id);
        return $usuario;

    }
    
    // #[Route('/entrada/{id}', name: 'verEntrada')]
    // public function VerEntrada($id, Request $request, ManagerRegistry $doctrine)
    // {
    //     $em = $doctrine->getManager();
    //     $entrada = $em->getRepository(Entrada::class)->find($id);
    //     return ['entrada' => $entrada];
    // } 
}