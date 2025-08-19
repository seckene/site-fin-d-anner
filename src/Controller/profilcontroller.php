<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class profilcontroller extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function index(): Response
    {
        

        return $this->render('profil/index.html.twig', [
            
        ]);
    }
}
