<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
 
 
use App\Repository\UserRepository;
 
use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
 

// #[Route(path: '/apitoken')]
class TokenController extends AbstractController
{
    #[Route(path: '/apitoken', name: 'api_token')]
 public function index(Request $request, UserRepository $userRepository): Response
   {
 
       $em = $this->getDoctrine()->getManager();
 
       if($request->query->get('bearer')) {
           $token = $request->query->get('bearer');
       }else {
           return $this->redirectToRoute('app_login');
       }
 
       $tokenParts = explode(".", $token); 
       $tokenHeader = base64_decode($tokenParts[0]);
       $tokenPayload = base64_decode($tokenParts[1]);
       $jwtHeader = json_decode($tokenHeader);
       $jwtPayload = json_decode($tokenPayload);
 
       $user = $userRepository->findOneByEmail($jwtPayload->username);
       dump($user);die;
       $response = new Response();
       $response->setContent(json_encode([
           'auth' => 'ok',
           'email' => $user->getEmail()
       ]));
       $response->headers->set('Content-Type', 'application/json');
       $response->headers->set('Access-Control-Allow-Origin', '*');
       $response->headers->set('pass', 'ok');
       $response->headers->set('email', $user->getEmail());
       $response->headers->setCookie(new Cookie('Authorization', $token));
       $response->headers->setCookie(new Cookie('BEARER', $token));
       return $response;
   }
}

