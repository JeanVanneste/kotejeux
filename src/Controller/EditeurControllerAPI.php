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
use App\Form\EditeurType;

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


    // TODO : gestion d'erreurs + crea
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
            $response->setContent("Accepted");

            return $response;
        }
        else
        {
            $response = new Response();
            $response->setContent("Invalid request");

            return $response;
        }

        /*
        $response = new Response();
        $response->setContent($name.$nationalite.$fondationYear);

        return $response;
        */
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

    // TODO
    /**
    * @Route("/api/editeur/{id}/update", name="editeurUpdateAPI",
    *    methods={"PUT", "HEAD"})
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
