<?php

namespace App\Controller;
use App\Entity\Set;
use App\Entity\Panier;
use App\Repository\SetRepository;
use App\Service\Panier\PanierService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Length;

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('', name: 'home')]
    public function index(PanierService $PanierService, SetRepository $setRepository, SessionInterface $sessionInterface): Response
    {
        if ($this->getUser() && empty($sessionInterface->get('panier'))){ // si le panier de session est vide et que l'utilisateur est connecté
            $user = $this->getUser();
            $manager = $this->getDoctrine()->getManager();
            /** @var Panier $panier */
            $panier = $manager->getRepository('App:Panier')->findOneBy(['user'=>$this->getUser()->getId(), "etat"=>"pending"]);
            if($panier == null){
                $panier = new Panier();
                $panier->setUser($user);
                $panier->setEtat("pending");
                $panier->setTypeLivraison("untracked");
                $manager->persist($panier);
                $manager->flush();
            }
            foreach ($panier->getCartePaniers() as $cartePanier){
                $PanierService->add($cartePanier->getCartes()->getId(),$cartePanier->getQuantity());
            }
        }
        $sets = $setRepository->findNouveau();
        return $this->render('home/index.html.twig', ["sets"=>$sets,

        ]);
    }


}
