<?php

namespace App\Controller;

use App\Entity\CartePanier;
use App\Form\LivraisonType;
use App\Service\Panier\PanierService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
                'choices' => ['Livraison non suivie - 5.00 $' => 'untracked', 'Livraison Suivie - 10.00 $' => 'tracked' ],
                'expanded' => false,
                'multiple' => false,
            ])
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $PanierService->livraison($form->getData());      
        }
        $total = $PanierService->getTotal();
        $qte = $PanierService->getQteTotal(); 
        return $this->render('carte_panier/index.html.twig', [
            'panier'=> $panierWithData,
            'total' => $total["total"],
            'totalLivraison' => $total["totalLivraison"],
            'qte' => $qte,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/Cartepanier/add/{id}', name: 'ajoutarticle')]
    public function add($id,SessionInterface $session, PanierService $PanierService)
    {
        $PanierService->add($id);
        if ($this->getUser()){
        $this->updatePanier($id,$session);
        }
        return $this->redirectToRoute('carte_panier');
    }

    #[Route('/Cartepanier/add/{id}/{quantity}', name: 'ajoutqtearticle')]
    public function addquantity($id,$quantity,SessionInterface $session, PanierService $PanierService)
    {
        $PanierService->add($id,$quantity);
        if ($this->getUser()){
        $this->updatePanier($id,$session);
        }
        return $this->redirectToRoute('carte_panier');
    }




    #[Route('/Cartepanier/minus/{id}', name: 'moinsarticle')]
    public function moins($id,SessionInterface $session, PanierService $PanierService)
    {   
        $PanierService->minus($id);
        if ($this->getUser()){
            $this->updatePanier($id,$session);
            }
        return $this->redirectToRoute('carte_panier');
    }

    #[Route('/Cartepanier/remove/{id}', name: 'retirearticle')]
    public function remove($id, SessionInterface $session, PanierService $PanierService){
        $PanierService->delete($id);
        if ($this->getUser()){
            $this->unsetPanier($id,$session);
            }
        return $this->redirectToRoute('carte_panier');
    }
    

    private function updatePanier($id, SessionInterface $session){
        $manager = $this->getDoctrine()->getManager();
        /** @var Panier $panier */
        $panier = $manager->getRepository('App:Panier')->findOneBy(['user'=>$this->getUser()->getId(), "etat"=>"pending"]);
        /** @var CartePanier $cartePanier */
        $cartePanier = $manager->getRepository('App:CartePanier')->findOneBy(['panier'=>$panier->getId(), "cartes"=>$id]);
        if($cartePanier == null){
            $carte = $manager->getRepository("App:Carte")->find($id);
            $cartePanier = new CartePanier();
            $cartePanier->setCartes($carte);  
            $panier->addCartePanier($cartePanier);
        }
        $cartePanier->setQuantity($session->get("panier")[$id]);
        $manager->persist($panier);
        $manager->flush();
    }

    private function unsetPanier($id, SessionInterface $session){
        $manager = $this->getDoctrine()->getManager();
        /** @var Panier $panier */
        $panier = $manager->getRepository('App:Panier')->findOneBy(['user'=>$this->getUser()->getId(), "etat"=>"pending"]);
        /** @var CartePanier $cartePanier */
        $cartePanier = $manager->getRepository('App:CartePanier')->findOneBy(['panier'=>$panier->getId(), "cartes"=>$id]);
        $manager->remove($cartePanier);
        $manager->flush();
    }

}
