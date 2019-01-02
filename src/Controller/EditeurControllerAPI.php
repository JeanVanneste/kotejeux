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

use App\Entity\Editeur;

class EditeurControllerAPI extends AbstractController
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
        $editeurs = $em->getRepository(Editeur::class)->findAll();
        $jsonContent = $serializer->serialize($editeurs, 'json');

        $response = new JsonResponse();
        $response->setContent($jsonContent);

        return $response;
    }

    /**
    * @Route("/api/editeur/add", name="editeurAddAPI", methods={"POST", "HEAD"})
    */
    public function add(Request $request)
    {
        $request = Request::createFromGlobals();

        $name = $request->request->get('name');
        $nationalite = $request->request->get('nationalite');
        $creationYear = $request->request->get('creationYear');

        if  ($name != null && $nationalite != null && $creationYear != null)
        {
            $editeur = new Editeur();
            $editeur->setName($name);
            $editeur->setNationalite($nationalite);
            $editeur->setCreationYear($creationYear);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($editeur);
            $entityManager->flush();

            $response = new Response();
            $response->setStatusCode(Response::HTTP_CREATED);

            return $response;
        }
        else
        {
            $response = new Response();
            $response->setContent("Invalid request");
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);

            return $response;
        }
    }

    /**
    * @Route("/api/editeur/{id}", name="editeurShowAPI", methods={"GET", "HEAD"})
    */

    public function show($id)
    {
        $editeur = $this->getDoctrine()->getRepository(Editeur::class)->find($id);

        if (!$editeur) {
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

        $jsonContent = $serializer->serialize($editeur, 'json');

        $response = new JsonResponse();
        $response->setContent($jsonContent);

        return $response;
    }

    // TODO : Change POST to PUT
    /**
    * @Route("/api/editeur/{id}/update", name="editeurUpdateAPI", methods={"POST", "HEAD"})
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

            $entityManager->flush();

            $response->setStatusCode(Response::HTTP_ACCEPTED);

        }
        else {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $response->setContent("Request sent");
        return $response;
    }

    /**
     * @Route("/api/editeur/{id}/delete", name="editeurDeleteAPI", methods={"DELETE", "HEAD"})
    */

    public function delete($id)
    {
        $response = new Response();

        $editeur = $this->getDoctrine()->getRepository(Editeur::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($editeur);
        $entityManager->flush();

        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent("Editeur ".$id." supprimé");
        return $response;
    }
}
