<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier/ajouter/{id}', name: 'ajouter_panier', methods: ['POST'])]
    public function ajouterAuPanier(int $id, SessionInterface $session, Request $request): Response
    {
        $panier = $session->get('panier', []);

        $nom = $request->request->get('nom');
        $prix = $request->request->get('prix');

        // Vérifie si déjà dans le panier
        $existe = false;
        foreach ($panier as &$item) {
            if ($item['id'] == $id) {
                $item['quantite']++;
                $existe = true;
                break;
            }
        }

        if (!$existe) {
            $panier[] = [
                'id' => $id,
                'nom' => $nom,
                'prix' => $prix,
                'quantite' => 1,
            ];
        }

        $session->set('panier', $panier);

        // Redirige vers la page du panier
        return $this->redirectToRoute('afficher_panier');
    }
    #[Route('/panier', name: 'afficher_panier')]
public function afficherPanier(SessionInterface $session): Response
{
    $panier = $session->get('panier', []);

    return $this->render('panier/index.html.twig', [
        'panier' => $panier
    ]);
}


}
