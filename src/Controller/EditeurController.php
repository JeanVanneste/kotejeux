<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Editeur;
use App\Form\EditeurType;

class EditeurController extends AbstractController
{
    /**
    * @Route("/editeur", name="editeur")
    */
    public function index()
    {
        $editeurs = $this->getDoctrine()->getRepository(Editeur::class)->findAll();
        return $this->render('editeur/index.html.twig', [
            'editeurs' => $editeurs,
        ]);
    }

    /**
    * @Route("/editeur/add", name="editeurAdd")
    */
    public function add(Request $request)
    {
        $editeur = new Editeur();

        $form = $this->createForm(EditeurType::class, $editeur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $editeur = $form->getData();

            $entityManager->persist($editeur);
            $entityManager->flush();

            return new Response(
                'Saved new editeur with id : '.$editeur->getId());
            }
            return $this->render('editeur/add.html.twig', array(
                'form' => $form->createView(),
            ));
        }

    /**
    * @Route("/editeur/{id}", name="editeurShow")
    */
    public function show($id)
    {
        $editeur = $this->getDoctrine()->getRepository(Editeur::class)->find($id);

        if (!$editeur) {
            throw $this->createNotFoundException(
                'No editeur found for id '.$id
            );
        }

        return $this->render('editeur/view.html.twig', [
            'editeur_id' => $editeur->getId(),
            'editeur_name' => $editeur->getName(),
            'editeur_nationalite' => $editeur->getNationalite(),
            'editeur_creation' => $editeur->getCreationYear(),
        ]);
    }

    /**
    * @Route("/editeur/{id}/update", name="editeurUpdate")
    */
    public function update($id, Request $request)
    {
        $editeur = $this->getDoctrine()->getRepository(Editeur::class)->find($id);

        $form = $this->createForm(EditeurType::class, $editeur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $editeur = $form->getData();

            $entityManager->persist($editeur);
            $entityManager->flush();

            return new Response(
                'Updated editeur with id : '.$editeur->getId());
        }
        return $this->render('editeur/update.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
