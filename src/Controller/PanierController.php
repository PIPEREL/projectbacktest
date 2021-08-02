<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(): Response
    {
        if ($this->getUser() !== null){
        $user = $this->getUser()->getId(); 
        return $this->render('panier/index.html.twig', [
            'user_id' => $user
        ]);
    }
    else{
        return $this->redirectToRoute('app_login');      
    }
    }
}
