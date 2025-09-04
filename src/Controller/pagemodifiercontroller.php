<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class pagemodifiercontroller extends AbstractController
{
    #[Route(path: '/pagemodifier', name: 'pagemodifier')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

if (!$user) {
    return $this->redirectToRoute('login');
}

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès !');
            return $this->redirectToRoute('pagemodifier');
        }

        return $this->render('modifier/pagemodifier.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}

