<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyNumberController extends AbstractController
{
    /**
    *@Route("/lucky/number");
    **/

    public function number(){
         $number = random_int(0,100);

         return $this->render('lucky/number.html.twig', ['number'=> $number,
     ]);
    }
    /*
     public function index()
    {
        return $this->render('lucky_number/index.html.twig', [
            'controller_name' => 'LuckyNumberController',
        ]);
    }*/
}
