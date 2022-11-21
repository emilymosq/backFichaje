<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


use App\Entity\Entrada;
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
        
    
        $entrada = new Entrada();
        //$fecha_formato = \DateTime::createFromInterface($fecha_publicacion);
        //$fecha_formato = \DateTime::createFromFormat('d/m/Y, H:i:s', $fecha_publicacion);
        //dump($fecha_formato);die;
        $datetime = new DateTime();
        $fecha_formato = $datetime->createFromFormat('d/m/Y H:i:s', $fecha_publicacion);
        $dump($fecha_formato);die;

        //$fecha_formato = DateTime::createFromFormat('d/m/Y H:i:s',$fecha_publicacion);
        
        $entrada->setFechaPublicacion($fecha_formato);
        $entrada->setComentario($comentario);
        $entrada->setLocacion($locacion);
        
        $entrada->setUser($this->getUser());

        $em = $doctrine->getManager();
        $em->persist($entrada);
        $em->flush();

        return $this->json('Ha fichado exitosamente', $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*', 'Access-Control-Allow-Methods'=> 'POST,OPTIONS']);
        //return $this->json('Ha fichado exitosamente ' . $entrada->getId());
    }

    // /**
    //  * @Route("/entrada/{id}", name="VerEntrada")
    //  */
    // #[Route('/entrada/{id}', name: 'verEntrada')]
    // public function VerEntrada($id, Request $request, ManagerRegistry $doctrine)
    // {
    //     $em = $doctrine->getManager();
    //     $entrada = $em->getRepository(Entrada::class)->find($id);
    //     return ['entrada' => $entrada];
    // } 
}