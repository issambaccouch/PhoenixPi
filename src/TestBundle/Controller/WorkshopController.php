<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Entity\Categoriews;
use TestBundle\Entity\FosUser;
use TestBundle\Entity\Workshop;
use TestBundle\Form\WorkshopType;
use blackknight467\StarRatingBundle\StarRatingBundle;

class WorkshopController extends Controller
{
    public function readAction()
    {
        date_default_timezone_set('Africa/Tunis');
        $date= date("Y-m-d");
        $workshops=$this->getDoctrine()->getRepository(Workshop::class )
            ->findAll();
        $this->getDoctrine()->getRepository(Workshop::class )
            ->updateEtat($date);
        return $this->render('@Test\Workshop\read.html.twig', array(
            'workshops'=>$workshops,'datejour'=>$date
        ));
    }

    public function createAction(Request $request)
    {
        $workshop = new Workshop(); // objet vide
        $form = $this->createForm(WorkshopType::class,$workshop);// Préparation du formulaire
        $form=$form->handleRequest($request);// Récuperation des données
      //  debug_to_console ($this->container->get('security.token_storage')->getToken()->getUser()->getId());
        $id=$this->container->get('security.token_storage')->getToken()->getUser()->getId();
        //$this->getDoctrine()->getRepository(FosUser::class )->findOneBy($id);
        $workshop->setIduser($this->getDoctrine()->getRepository(FosUser::class )->find($id));

        if($form->isValid())// test if our form is valid
        {
            $em=$this->getDoctrine()->getManager(); // Déclaration Entity Manager
            $em->persist($workshop); // Persister l'objet modele dans l'ORM
            $em->flush(); // Sauvegarde des données dans la BD
            return $this->redirectToRoute('read');
        }else
            return $this->render('@Test\Workshop\create.html.twig', array('form'=>$form->createView()
                // ...
            ));
    }


    public function detailAction($idws)
    {
        $em=$this->getDoctrine()->getManager();
        $workshop=$em->getRepository(Workshop::class)->find($idws);
        $cats=$this->getDoctrine()->getRepository(Categoriews::class)->find($workshop->getIdcw());
        $user=$this->getDoctrine()->getRepository(FosUser::class)->find($workshop->getIduser());

        return $this->render('@Test\Workshop\detail.html.twig', array(

            'w'=>$workshop,
            'users'=>$user,
            'cats'=>$cats
        ));
    }



    public function consulterAction()
    {
        $workshops=$this->getDoctrine()->getRepository(Workshop::class)->WorkshopsArchiver();
        return $this->render('@Test\Workshop\consulter.html.twig', array(
            'workshops'=>$workshops
        ));
    }






    public function updateAction(Request $request,$idws)
    {
        //recuperation des données (objet avec ID en parametre) de la bd
        $em=$this->getDoctrine()->getManager();//appel du manager pour la modification
        $workshop=$em->getRepository(Workshop::class)->find($idws);//recupération de l'objet
        // preparation formulaire
        $form=$this->createForm(WorkshopType::class,$workshop);
        //recuperation des données
        $form=$form->handleRequest($request);
        if ($form->isValid())
        {
            $em->flush();
            //redirection vers read
            return $this->redirectToRoute('read');
        }



        return $this->render('@Test\Workshop\update.html.twig', array(
            // ...
            'form'=>$form->createView()
        ));
    }

    public function deleteAction($idws)
    {
        $em=$this->getDoctrine()->getManager();
        $workshop=$em->getRepository(Workshop::class)->find($idws);
        $em->remove($workshop);
        $em->flush();
        return $this->redirectToRoute('read');

    }

}
