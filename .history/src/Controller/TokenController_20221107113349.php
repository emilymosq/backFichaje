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
 
class TokenController extends AbstractController
{
    #[Route(path: '/api/token', name: 'app_token')]
 public function api(Request $request, UserRepository $userRepository): Response
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
       var_dump($response);
       return $response;
   }
}
// /**
// * @Route("/apiportfolio")
// */

// class ApiPortfolioController extends AbstractController
// {

//     /**
//     * @Route("/list", name="api_portfolio_index", methods={"GET"})
//     */

//     public function api(Request $request, PortfolioRepository $portfolioRepository): Response
//     {    
//         $portfolio = $this->getDoctrine()->getRepository(Portfolio::class)->findAll();

//         // Symfony 6.0 $portfolio = $portfolioRepository->findAll();
//         $data = [];
//         foreach ($portfolio as $p) {
//             $data[] = [
//                 'id' => $p->getId(),
//                 'name' => $p->getName(),
//                 'description' => $p->getDescription(),
//             ];
//         }
//         //return $this->json($data);
//         return $this->json($data, $status = 200, $headers = ['Access-Control-Allow-Origin'=>'*']);
//     }
// }
