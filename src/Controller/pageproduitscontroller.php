<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class pageproduitscontroller extends AbstractController
{
    #[Route(path: '/pageproduits', name: 'pageproduits')]
    public function index(ProduitRepository $repo): Response
    {
        $produits = $repo->findAll(); // récupération des produits

        return $this->render('pageproduits/pageproduits.html.twig', [
            'produits' => $produits, // 🔹 envoi de la variable au template
        ]);
    }
}
  


