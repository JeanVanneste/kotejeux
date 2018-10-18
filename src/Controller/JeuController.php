<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
<<<<<<< HEAD
use App\Entity\Jeu;
=======
use App\Entity\Editeur;
>>>>>>> a3ecfed63bf0b9ffd587bd449f5d369c39c7d9d5

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
}
