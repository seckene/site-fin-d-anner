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
        $taille = $request->request->get('taille');
        $photo = $request->request->get('photo');

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
                'taille' => $taille ?? 'Non spécifiée',
                'photo' => $photo,
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

    #[Route('/panier/remove/{id}', name: 'app_panier_remove', methods: ['POST'])]
    public function remove(int $id, Request $request, SessionInterface $session): Response
    {
        if ($this->isCsrfTokenValid('remove' . $id, $request->request->get('_token'))) {
            $panier = $session->get('panier', []);

            foreach ($panier as $key => $item) {
                if ($item['id'] == $id) {
                    unset($panier[$key]); // supprime l'article
                    break;
                }
            }

            // Réindexer le tableau
            $session->set('panier', array_values($panier));
        }

        return $this->redirectToRoute('afficher_panier');
    }
}
