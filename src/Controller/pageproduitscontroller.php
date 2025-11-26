<?php

namespace App\Controller;

use App\Form\ProductFilterType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class pageproduitscontroller extends AbstractController
{

#[Route('/pageproduits', name: 'pageproduits')]
public function index(Request $request, ProduitRepository $produitRepository): Response
{
    $form = $this->createForm(ProductFilterType::class, null, [
        'method' => 'GET'
    ]);

    $form->handleRequest($request);

    $filters = $form->isSubmitted() ? $form->getData() : [];

    $produits = $produitRepository->filterProducts($filters);

    return $this->render('pageproduits/pageproduits.html.twig', [
        'form' => $form->createView(),
        'produits' => $produits,
    ]);
}
}