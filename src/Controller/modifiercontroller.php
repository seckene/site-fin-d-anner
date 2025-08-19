<?php
 
namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
 
class modifiercontroller extends AbstractController
{
    #[Route(path: '/modifier', name: 'modifier')]
    public function login(AuthenticationUtils $authenticationUtils,ProduitRepository $repo): Response
    {
        $produit= $repo->findAll();
        $error = $authenticationUtils->getLastAuthenticationError();
 
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('modifier/modifier.html.twig', [
           
        ]);
    }
 
   
}