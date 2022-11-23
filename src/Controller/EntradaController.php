<?php

namespace App\Controller;

use App\Entity\Entrada;
use App\Form\EntradaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class EntradaController extends AbstractController
{
    #[Route('/entrada', name: 'app_entrada')]
    public function index(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $entrada = new Entrada();
        $form = $this->createForm(EntradaType::class, $entrada);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('foto')->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('ha ocurrido un error');
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $entrada->setFoto($newFilename);
            }
            $user = $this->getUser();
            $entrada->setUser($user);
            $em = $doctrine->getManager();
            $em->persist($entrada);
            $em->flush();
            $this->addFlash('exito', Entrada::FICHAJE_EXITOSO);
            return $this->redirectToRoute('app_entrada');
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

    #[Route('/todosentrada', name: 'todosEntrada')]
    public function TodosEntrada(PaginatorInterface $paginator, Request $request, ManagerRegistry $doctrine)
    {
        $user = $this->getUser(); //OBTENGO AL USUARIO ACTUALMENTE LOGUEADO
        if ($user) {
            $em = $doctrine->getManager();
            $query = $em->getRepository(Entrada::class)->BuscarTodasLasEntradas();
            $pagination = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                6 /*limit per page*/
            );
            return $this->render('entrada/todosentrada.html.twig', [
                'pagination' => $pagination
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
