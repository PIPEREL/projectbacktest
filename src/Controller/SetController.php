<?php

namespace App\Controller;

use App\Entity\Set;
use App\Form\SetType;
use App\Repository\SetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SetController extends AbstractController
{
    #[Route('admin/set/', name: 'set_index', methods: ['GET'])] 
    public function index(SetRepository $setRepository): Response
    {
        $sets = $setRepository->findby([],["date_parution" => 'DESC']);
       return $this->render('admin/set/index.html.twig', [
            'sets' => $sets
        ]);
    }

    #[Route('admin/set/new', name: 'set_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $set = new Set();
        $form = $this->createForm(SetType::class, $set);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infoImg= $form['img']->getData();
            $extensionImg = $infoImg->guessExtension();
            $nomImg= time().'set.'.$extensionImg;
            if (!file_exists($this->getParameter('set_folder'))) {
                mkdir($this->getParameter('set_folder')); // crée le dossier
            }
            $infoImg->move($this->getParameter('set_folder'), $nomImg);
            $set-> setImg($nomImg);  

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($set);
            $entityManager->flush();

            return $this->redirectToRoute('set_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/set/new.html.twig', [
            'set' => $set,
            'form' => $form,
        ]);
    }

    #[Route('admin/set/{id}', name: 'set_show', methods: ['GET'])]
    public function show(Set $set): Response
    {
        //$source = getreferer()
        //if source = admin 
        // sinon
        $cartes= $set->getCartes();
        return $this->render('admin/set/show.html.twig', [
            'set' => $set,
            'cartes' => $cartes
        ]);
    }

    #[Route('admin/set/{id}/edit', name: 'set_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Set $set): Response
    {
        $form = $this->createForm(SetType::class, $set);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $infoImg = $form['img']->getData();
            if ($infoImg !== null){
                $nomOldImg = $set->getImg();
                $cheminOldImg = $this->getParameter('set_folder').'/'. $nomOldImg;
                unlink($cheminOldImg);
                $extensionImg = $infoImg->guessExtension();
                $nomImg= time().'set.'.$extensionImg;
                $infoImg->move($this->getParameter('set_folder'), $nomImg);
                $set-> setImg($nomImg);  
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('set_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/set/edit.html.twig', [
            'set' => $set,
            'form' => $form,
        ]);
    }

    #[Route('admin/set/{id}', name: 'set_delete', methods: ['POST'])]
    public function delete(Request $request, Set $set): Response
    {
        if ($this->isCsrfTokenValid('delete'.$set->getId(), $request->request->get('_token'))) {
            $settodelete = $set->getImg();
            if ($settodelete !== null){
                $cheminsettodelete = $this->getParameter('set_folder') . '/' . $settodelete;
                unlink($cheminsettodelete);
            } 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($set);
            $entityManager->flush();
        }

        return $this->redirectToRoute('set_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('setcards/{id}', name: 'set', methods: ['GET'])]
    public function print(Set $set): Response
    {
        $cartes= $set->getCartes();
        return $this->render('home/setcards.html.twig', [
            'set' => $set,
            'cartes' => $cartes
        ]);
    }

    #[Route('set', name: 'set_print', methods: ['GET'])]
    public function setchoice(SetRepository $setRepository): Response
    {
        $sets = $setRepository->findby([],["date_parution" => 'DESC']);
        return $this->render('home/set.html.twig', [
                'sets' => $sets
            ]);
        }
    }
