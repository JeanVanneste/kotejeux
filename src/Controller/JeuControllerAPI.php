<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use App\Entity\Jeu;
use App\Entity\Editeur;

class JeuControllerAPI extends AbstractController
{
    /**
    * @Route("/api/editeur", name="editeurAPI", methods={"GET", "HEAD"})
    */
    public function index()
    {
        // TODO réparer fonction

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $em = $this->getDoctrine()->getManager();
        $jeux = $em->getRepository(Jeu::class)->findAll();
        $jsonContent = $serializer->serialize($editeurs, 'json');

        $response = new JsonResponse();
        $response->setContent($jsonContent);

        return $response;
    }

    /**
    * @Route("/api/jeu/add", name="jeuAddAPI", methods={"POST", "HEAD"})
    */
    public function add(Request $request)
    {
        $request = Request::createFromGlobals();

        $name = $request->request->get('name', $default= NULL);
        $editeurId = $request->request->get('editeurId', $default= NULL);
        $auteur = $request->request->get('auteur', $default= NULL);
        $category = $request->request->get('category', $default= NULL);
        $gameDuration = $request->request->get('gameDuration', $default= NULL);
        $playerMin = $request->request->get('playerMin', $default= NULL);
        $playerMax = $request->request->get('playerMax', $default= NULL);
        $description = $request->request->get('description', $default= NULL);

        if  ($name && $editeurId && $auteur && $category && $gameDuration && $playerMin && $playerMax && $description)
        {
            $jeu = new Jeu();
            $jeu->setName($name);
            $jeu->setAuteur($auteur);
            $jeu->setCategory($category);
            $jeu->setGameDuration($gameDuration);
            $jeu->setPlayerMin($playerMin);
            $jeu->setPlayerMax($playerMax);
            $jeu->setDescription($description);

            $editeur = $this->getDoctrine()->getRepository(Editeur::class)->find($editeurId);
            $jeu->setEditeur($editeur);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jeu);
            $entityManager->flush();

            $response = new Response();
            $response->setStatusCode(Response::HTTP_CREATED);

            return $response;
        }
        else {
            $response = new Response();
            $response->setContent("Invalid request");
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);

            return $response;
        }
    }

    /**
    * @Route("/api/jeu/{id}", name="jeuShowAPI", methods={"GET", "HEAD"})
    */

    public function show($id)
    {
        $jeu = $this->getDoctrine()->getRepository(Jeu::class)->find($id);

        if (!$jeu) {
            throw $this->createNotFoundException(
                'No editeur found for id '.$id
            );
        }

        $encoders = new JsonEncoder();
        $normalizers = new ObjectNormalizer();

        $normalizers->setCircularReferenceHandler(function ($object, string $format = null, array $context = array()){
            return $object->getName();
        });

        $serializer = new Serializer(array($normalizers), array($encoders));

        $jsonContent = $serializer->serialize($jeu, 'json');

        $response = new JsonResponse();
        $response->setContent($jsonContent);

        return $response;
    }

    // TODO : Change POST to PUT
    /**
    * @Route("/api/jeu/{id}/update", name="jeuUpdateAPI", methods={"POST", "HEAD"})
    */

    public function update($id, Request $request)
    {
        $request = Request::createFromGlobals();
        $response = new Response();

        $editeur = $this->getDoctrine()->getRepository(Editeur::class)->find($id);

        $name = $request->request->get('name');
        $nationalite = $request->request->get('nationalite');
        $creationYear = $request->request->get('creationYear');
        $isCorrect = FALSE;

        if ($name != null) {
            $editeur->setName($name);
            $isCorrect = TRUE;
        }
        if ($nationalite != null) {
            $editeur->setNationalite($nationalite);
            $isCorrect = TRUE;
        }
        if ($creationYear != null) {
            $editeur->setCreationYear($creationYear);
            $isCorrect = TRUE;
        }

        if ($isCorrect) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($editeur);
            $entityManager->flush();

            $response->setStatusCode(Response::HTTP_ACCEPTED);

        }
        else {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $response->setContent("Request sent");
        return $response;

    }
}
