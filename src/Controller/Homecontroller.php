<?php
 
namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
 
class Homecontroller extends AbstractController
{
    #[Route(path: '/home', name: 'home')]
    public function login(AuthenticationUtils $authenticationUtils,ProduitRepository $repo): Response
    {
        $produit= $repo->findAll();
        $error = $authenticationUtils->getLastAuthenticationError();
 
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('home/home.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'Produits' => $produit
        ]);
    }
 
   
}