<?php

namespace App\Controller;
use App\Entity\Set;
use App\Repository\SetRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('', name: 'home')]
    public function index(SetRepository $setRepository): Response
    {
        $sets = $setRepository->findNouveau();
        return $this->render('home/index.html.twig', ["sets"=>$sets,

        ]);
    }


}
