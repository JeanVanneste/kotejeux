<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Editeur;

class EditeurController extends AbstractController
{
    /**
     * @Route("/editeur", name="editeur")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $editeur = new Editeur();
        $editeur->setName('asmodee');
        $editeur->setNationalite('France');
        $editeur->setCreationYear('1986');

        $entityManager->persist($editeur);

        $entityManager->flush();

        return new Response('Saved new editeur with id : '.$editeur->getId());
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

        return new Response ("L'éditeur correspondant à l'id ".$id." est ".$editeur->getName());
    }
}
