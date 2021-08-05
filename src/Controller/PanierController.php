<?php

namespace App\Controller;

use App\Entity\Carte;
use App\Entity\CartePanier;
use App\Entity\Panier;
use App\Repository\CarteRepository;
use App\Service\Panier\PanierService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(SessionInterface $session, CarteRepository $carteRepository, PanierService $panierService): Response
    {

        if ($this->getUser() !== null) {
            $manager = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            /** @var Panier $panier */
            $panier = $manager->getRepository('App:Panier')->findOneBy(['user' => $this->getUser()->getId(), "etat" => "pending"]);
            /** @var CartePanier $articles */
            $articles = $panier->getCartePaniers();
            $total = $panierService->getTotal();
            $qte = $panierService->getQteTotal(); 
            $adresses = $user->getAdresses();
            return $this->render('panier/index.html.twig', [
                'user' => $user,
                'panier' => $panier,
                "articles" => $articles,
                "total" => $total,
                "qte" => $qte,
                "adresses" => $adresses

            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
