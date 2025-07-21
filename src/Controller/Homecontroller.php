<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
 
class Homecontroller extends AbstractController
{
    #[Route(path: '/', name: 'home')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // $error contiendra le message d'erreur si une erreur d'authentification est survenue
        $error = $authenticationUtils->getLastAuthenticationError();
 
        // $lastUsername contiendra le dernier nom d'utilisateur saisi par l'utilisateur via la méthode getLastUsername()
        $lastUsername = $authenticationUtils->getLastUsername();
          // lastUsername et error seront transmis à la vue
        return $this->render('home/home.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
 
   
}