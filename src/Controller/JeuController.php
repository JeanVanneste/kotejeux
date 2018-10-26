<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Jeu;
use App\Entity\Editeur;
use App\Form\JeuType;

class JeuController extends AbstractController
{
    /**
     * @Route("/jeu", name="jeu")
     */
    public function index()
    {
        return $this->render('jeu/index.html.twig', [
            'controller_name' => 'JeuController',
        ]);
    }

    /**
    * @Route("/jeu/add", name="jeuAdd")
    */
    public function new(Request $request)
    {
        $jeu = new Jeu();
        $form = $this->createForm(JeuType::class, $jeu);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $jeu = $form->getData();

            $entityManager->persist($jeu);
            $entityManager->flush();

            return new Response(
                "Jeu sauvegardé avec l'id ".$jeu->getId());
        }

        return $this->render('jeu/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
    * @Route("/jeu/{id}", name="jeuShow")
    */
    public function show($id)
    {
        $jeu = $this->getDoctrine()->getRepository(Jeu::class)->find($id);

        if (!$jeu){
            throw $this->createNotFoundException(
                'Pas de jeu trouvé correspondant l\'id '.$id
            );
        }

        return new Response ('Le jeu correspondant à l\'id '.$id.' est le jeu '.$jeu->getName());
    }
}
