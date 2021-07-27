<?php

namespace App\Controller;

use App\Service\Panier\PanierService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartePanierController extends AbstractController
{
    #[Route('/Cartepanier', name: 'carte_panier')]
    public function index(PanierService $PanierService): Response
    {
        $panierWithData =$PanierService->getPanier();
        $total = $PanierService->getTotal(); 
        return $this->render('carte_panier/index.html.twig', [
            'panier'=> $panierWithData,
            'total' => $total
        ]);
    }

    #[Route('/Cartepanier/add/{id}', name: 'ajoutarticle')]
    public function add($id, PanierService $PanierService)
    {
        $PanierService->add($id);
        return $this->redirectToRoute('carte_panier');
    }

    #[Route('/Cartepanier/minus/{id}', name: 'moinsarticle')]
    public function moins($id, PanierService $PanierService)
    {
        $PanierService->minus($id);
        return $this->redirectToRoute('carte_panier');
    }

    #[Route('/Cartepanier/remove/{id}', name: 'retirearticle')]
    public function remove($id, PanierService $PanierService){
        $PanierService->delete($id);
        return $this->redirectToRoute('carte_panier');
    }
    


}
