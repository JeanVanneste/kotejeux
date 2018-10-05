<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class nameController extends AbstractController {
    /**
    * @Route(/hello);
    **/

    function render {
        return $this->render('hello.html.twig')
    }

    /**
    * @Route(/hello/{name})
    **/

    function render($name) {
        return $this->render('name/hello.html.twig')
    }
}
