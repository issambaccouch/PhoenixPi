<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use TestBundle\Entity\Categorieprod;
use TestBundle\Form\CategorieprodType;

class Cat_ProdController extends Controller
{
    public function CreateAction(Request $request)
    {
        $cat_prod = new Categorieprod(); // objet vide
        $form = $this->createForm(CategorieprodType::class,$cat_prod);// Préparation du formulaire
        $form=$form->handleRequest($request);// Récuperation des données
        if($form->isValid())// test if our form is valid
        {
            $em=$this->getDoctrine()->getManager(); // Déclaration Entity Manager
            $em->persist($cat_prod); // Persister l'objet modele dans l'ORM
            $em->flush(); // Sauvegarde des données dans la BD
            return $this->redirectToRoute('_read');
        }else
            return $this->render('@Test\Cat_Prod\create_Cat_Prod.html.twig', array('form'=>$form->createView()
                // ...
            ));

    }

    public function UpdateAction(Request $request,$idcp)
    {
        //recuperation des données (objet avec ID en parametre) de la bd
        $em=$this->getDoctrine()->getManager();//appel du manager pour la modification
        $cat=$em->getRepository(Categorieprod::class)->find($idcp);//recupération de l'objet
        // preparation formulaire
        $form=$this->createForm(CategorieprodType::class,$cat);
        //recuperation des données
        $form=$form->handleRequest($request);
        if ($form->isValid())
        {
            $em->flush();
            //redirection vers read
            return $this->redirectToRoute('_read');
        }



        return $this->render('@Test\Cat_Prod\update_Cat_Prod.html.twig', array(
            // ...
            'form'=>$form->createView()
        ));
    }

    public function readAction()
    {
        $cat=$this->getDoctrine()->getRepository(Categorieprod::class )
            ->findAll();
        return $this->render('@Test\Cat_Prod\read_Cat_Prod.html.twig', array(
            'Categories'=>$cat
        ));
    }
    public function deleteAction($idcp)
    {
        $em=$this->getDoctrine()->getManager();
        $cat=$em->getRepository(Categorieprod::class)->find($idcp);
        $em->remove($cat);
        $em->flush();
        return $this->redirectToRoute('_read');

    }



}
