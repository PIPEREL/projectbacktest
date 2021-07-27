<?php

namespace App\Controller;

use App\Entity\Carte;
use App\Form\CarteType;
use App\Repository\CarteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/carte')]
class CarteController extends AbstractController
{
    #[Route('/', name: 'carte_index', methods: ['GET'])]
    public function index(CarteRepository $carteRepository): Response
    {
        $cartes = $carteRepository->findAll();
        return $this->render('admin/carte/index.html.twig', [
            'cartes' => $cartes,
        ]);
    }

    #[Route('/new', name: 'carte_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $carte = new Carte();
        $form = $this->createForm(CarteType::class, $carte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infoImg = $form['img']->getData();
            $extensionImg = $infoImg->guessExtension();
            $nomImg = time() . 'carte.' . $extensionImg;
            if (!file_exists($this->getParameter('carte_folder'))) {
                mkdir($this->getParameter('carte_folder')); // crée le dossier
            }
            $infoImg->move($this->getParameter('carte_folder'), $nomImg);
            $carte->setImg($nomImg);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($carte);
            $entityManager->flush();

            return $this->redirectToRoute('carte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/carte/new.html.twig', [
            'carte' => $carte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'carte_show', methods: ['GET'])]
    public function show(Carte $carte): Response
    {
        return $this->render('admin/carte/show.html.twig', [
            'carte' => $carte,
        ]);
    }

    #[Route('/{id}/edit', name: 'carte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Carte $carte): Response
    {
        $form = $this->createForm(CarteType::class, $carte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $infoImg = $form['img']->getData();
            if ($infoImg !== null) {
                $nomOldImg = $carte->getImg();
                $cheminOldImg = $this->getParameter('carte_folder') . '/' . $nomOldImg;
                unlink($cheminOldImg);
                $extensionImg = $infoImg->guessExtension();
                $nomImg = time() . 'carte.' . $extensionImg;
                $infoImg->move($this->getParameter('carte_folder'), $nomImg);
                $carte->setImg($nomImg);
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('carte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/carte/edit.html.twig', [
            'carte' => $carte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'carte_delete', methods: ['POST'])]
    public function delete(Request $request, Carte $carte): Response
    {
        if ($this->isCsrfTokenValid('delete' . $carte->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($carte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('carte_index', [], Response::HTTP_SEE_OTHER);
    }
}
