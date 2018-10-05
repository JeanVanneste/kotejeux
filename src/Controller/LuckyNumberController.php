<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LuckyNumberController extends AbstractController
{
    public function number(){
         $number = random_int(0,100);

         return new Response(
             '<html><body>Lucky number: '.$number.'</body></html>'
         );
    }
    /*
     public function index()
    {
        return $this->render('lucky_number/index.html.twig', [
            'controller_name' => 'LuckyNumberController',
        ]);
    }*/
}
