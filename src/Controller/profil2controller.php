<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class profil2controller extends AbstractController
{
    #[Route('/profil2', name: 'profil2')]
    public function index(): Response
    {
            $user = $this->getUser();

  

    if (!$user) {
        throw new AccessDeniedException('Vous devez être connecté pour accéder à cette page.');
    }

        return $this->render('profil2/profil2.html.twig', [
               'user' => $user,
        ]);
    }
}
