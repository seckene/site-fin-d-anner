<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Form\ProductFilterType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('admin/produit')]
final class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(Request $request, ProduitRepository $produitRepository): Response
    {
        $form = $this->createForm(ProductFilterType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);
        $filters = $form->getData() ?? [];
        $produits = $produitRepository->filterProducts($filters);

        return $this->render('produit/index.html.twig', [
            'form' => $form->createView(),
            'produits' => $produits,
        ]);
    }

    #[Route('/new', name: 'app_produit_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move($this->getParameter('images_directory'), $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload de l\'image.');
                }

                $produit->setPhoto($newFilename);
            }

            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('app_produit_index');
        }

        return $this->render('produit/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', ['produit' => $produit]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move($this->getParameter('images_directory'), $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload de l\'image.');
                }

                $produit->setPhoto($newFilename);
            }

            $em->flush();

            return $this->redirectToRoute('app_produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('app_produit_index');
    }
}
