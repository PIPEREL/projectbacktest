<?php

namespace App\Controller;

use App\Form\LivraisonType;
use App\Service\Panier\PanierService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartePanierController extends AbstractController
{
    #[Route('/Cartepanier', name: 'carte_panier')]
    public function index(PanierService $PanierService, Request $request): Response
    {
        $livraison = [];
        $panierWithData =$PanierService->getPanier();
        
        $form = $this->createFormBuilder($livraison)
        ->add(
            'typeLivraison', ChoiceType::class, [
                'choices' => ['lettre non suivie' => 'untracked', 'lettre suivie' => 'tracked' ],
                'expanded' => false,
                'multiple' => false,
            ])
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $PanierService->livraison($form->getData());    
            
        }
        $total = $PanierService->getTotal(); 
        return $this->render('carte_panier/index.html.twig', [
            'panier'=> $panierWithData,
            'total' => $total,
            'form' => $form->createView(),
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
