<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use TestBundle\Entity\Categoriews;
use TestBundle\Form\CategoriewsType;

class CategorieWSController extends Controller
{
    public function createAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $cat= new Categoriews(); // objet vide
        $form = $this->createForm(CategoriewsType::class,$cat);// Préparation du formulaire
        $form=$form->handleRequest($request);// Récuperation des données

        if($form->isValid())// test if our form is valid
        {
            $em=$this->getDoctrine()->getManager(); // Déclaration Entity Manager
            $em->persist($cat); // Persister l'objet Categorie dans l'ORM
            $em->flush(); // Sauvegarde des données dans la BD
            return $this->redirectToRoute('liste');
        }else
            return $this->render('@Test\CategorieWS\create.html.twig', array('form'=>$form->createView()
                // ...
            ));

    }

    public function listeAction( Request $request)
    {
        $cats=$this->getDoctrine()->getRepository(Categoriews::class )->findAll();
        if ($request->isXmlHttpRequest())
        {
            $nom=$request->get('nom');
            $categories=$this->getDoctrine()->getRepository(Categoriews::class)->FindByNom($nom);
            $se=new Serializer(array(new ObjectNormalizer()));
            $data=$se->normalize($categories);
            return new  JsonResponse($data);
        }
        return $this->render('@Test\CategorieWS\liste.html.twig', array(
            'cats'=>$cats
        ));
    }

    public function updateAction(\Symfony\Component\HttpFoundation\Request $request,$idcw)
    {
        //recuperation des données (objet avec ID en parametre) de la bd
        $em=$this->getDoctrine()->getManager();//appel du manager pour la modification
        $cats=$em->getRepository(Categoriews::class)->find($idcw);//recupération de l'objet
        // preparation formulaire
        $form=$this->createForm(CategoriewsType::class,$cats);
        //recuperation des données
        $form=$form->handleRequest($request);
        if ($form->isValid())
        {
            $em->flush();
            //redirection vers liste
            return $this->redirectToRoute('liste');
        }



        return $this->render('@Test\CategorieWS\update.html.twig', array(
            // ...
            'form'=>$form->createView()
        ));
    }

    public function removeAction($idcw)
    {
        $em=$this->getDoctrine()->getManager();
        $workshop=$em->getRepository(Categoriews::class)->find($idcw);
        $em->remove($workshop);
        $em->flush();
        return $this->redirectToRoute('liste');
    }





}