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
      #[Route('/', name: 'home')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $produits = $produitRepository->findAll(); // ⚡ variable en minuscule

        return $this->render('home/home.html.twig', [
            'produits' => $produits, // ⚡ clé en minuscule pour Twig
        ]);
    }

 
   
}