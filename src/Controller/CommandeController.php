<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'commande')]
    public function index(): Response
    {
        if ($this->getUser() !== null) {
            return $this->render('commande/index.html.twig', [
            ]);
        } else { 
            return $this->redirectToRoute('app_login');
        }
        
    }
}
