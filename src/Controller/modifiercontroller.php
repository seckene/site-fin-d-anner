<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class modifiercontroller extends AbstractController
{
    #[Route(path: '/modifier', name: 'modifier')]
    public function index(): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        if (!$user) {
            // Si personne n'est connecté, redirection vers login
            return $this->redirectToRoute('app_login');
        }

        return $this->render('modifier/modifier.html.twig', [
            'user' => $user
        ]);
    }
}
