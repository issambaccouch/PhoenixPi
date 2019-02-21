<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Date;
use TestBundle\Entity\Evenement;
use TestBundle\Entity\FosUser;
use TestBundle\Form\EvenementType;

class EvenementController extends Controller
{
    public function readAction()
    {
        // parcourir la base de donne
        $user=new FosUser();
        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $evenements=$this->getDoctrine()->getRepository(Evenement::class)->findByiduser($user) ;//getdoctrine permet d'acceder au donner de la base de donnee tandis que getrepostory est utiliser pour lire des donnees de la base de donnee elle utiliser lorsque la fonction read et la methode findall() permet de lire tout les donnee de la table desirer
        return $this->render('@Test\Evenement\gererEvents.html.twig', array(
           'evenements'=>$evenements
        ));
    }



    public function detailAction(Request $request,$id)
    {
        $evenement=$this->getDoctrine()->getManager()->getRepository(Evenement::class)->find($id);
        return $this->render('@Test\Evenement\Details.html.twig', array(
            'evenement'=>$evenement
        ));
    }



    public function consulterAction()
    {
        date_default_timezone_set('Africa/Tunis');
        $date= date("Y-m-d");
        $this->getDoctrine()->getManager()->getRepository(Evenement::class)->updateEtat($date);
        $etat=1;
        $evenements=$this->getDoctrine()->getRepository(Evenement::class)->findByetatev($etat);
        return $this->render('@Test\Evenement\consulter.html.twig', array(
            'evenements'=>$evenements
        ));
    }




    public function rechercheajaxAction(Request $request)
    {
        if ($request->isXmlHttpRequest())
        {
            $nom=$request->get('nom');
            $evenements=$this->getDoctrine()->getRepository(Evenement::class)->findBynomDQL($nom);
            //inisialisation de serializer
            $se=new Serializer(array(new ObjectNormalizer()));
            //normalisation de la liste
            $data=$se->normalize($evenements);
            return new  JsonResponse($data);
        }
        return $this->render('@Test\Evenement\test.html.twig', array(

        ));
    }



    public function ajouterAction(Request $request)
    {

        $error=0;
        $evenement=new Evenement();
        //1er etape: preparation form
        $form=$this->createForm(EvenementType::class,$evenement);
        //2eme etpae: recuperation des donnees
        $form =$form->handleRequest($request);
        //tester la validiter de notre saisie
        if($form->isValid())
        {
            //3eme etape : enregistrement dans la base de donnee
            //declaration entity manager
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $fosusers=new FosUser();
            $fosusers=$this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($user->getId()) ;
            $evenement->setIduser($fosusers);
            $evenement->setEtatev(0);
            $em=$this->getDoctrine()->getManager();// la fonction getManager() est utiliser lors de l'ajout,suppression ou modification dans la base de donnee
            //persister l'objet modele dans l'ORM
            $em->persist($evenement);
            //sauvgarde les donnees dans la db
            $em->flush();

            return $this->redirectToRoute('gerer_events');
        }

        return $this->render('@Test\Evenement\AjouterEvents.html.twig', array(
            'form'=>$form->createView(),'error'=>$error

        ));
    }




    public function updateAction(Request $request,$id)
    {

        //1er etape: recuperation des donnee (objet avec id en parametre) de la BD
        $evenement=$this->getDoctrine()->getManager()->getRepository(Evenement::class)->find($id) ;//remarque : ici on  utiliser la methode getmanager pour faire la modification
        //2er etape: preparation form
        $form=$this->createForm(EvenementType::class,$evenement);
        //4eme etape : recuperation du formulaire
        $form=$form->handleRequest($request);
        if ($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('gerer_events');
        }

        return $this->render('@Test\Evenement\ModifierEvents.html.twig', array(
            'form'=>$form->createView()

        ));
    }

    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository(Evenement::class)->find($id);
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('gerer_events');
        return $this->render('@Test\Evenement\gererEvents.html.twig', array(

        ));
    }


    public function ParticiperAction($id)
    {
        $this->getDoctrine()->getManager()->getRepository(Evenement::class)->updateNbPartitipation($id);
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository(Evenement::class)->find($id);
        return $this->render('@Test\Evenement\Details.html.twig', array(
            'evenement'=>$evenement
        ));
    }


}
