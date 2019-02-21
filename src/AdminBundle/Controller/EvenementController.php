<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Evenement;
use AdminBundle\Form\EvenementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EvenementController extends Controller
{
    public function readAction()
    {
        // parcourir la base de donne
        $evenements=$this->getDoctrine()->getRepository(Evenement::class)->findAll() ;//getdoctrine permet d'acceder au donner de la base de donnee tandis que getrepostory est utiliser pour lire des donnees de la base de donnee elle utiliser lorsque la fonction read et la methode findall() permet de lire tout les donnee de la table desirer
        return $this->render('@Admin\Evenement\gererEvents.html.twig', array(
            'evenements'=>$evenements
        ));
    }



    public function ajouterAction(Request $request)
    {


        $evenement=new Evenement();
        //1er etape: preparation form
        $form=$this->createForm(EvenementType::class,$evenement);
        //2eme etpae: recuperation des donnees
        $form =$form->handleRequest($request);
        //tester la validiter de notre saisie
        if($form->isValid())
        {
            //3eme etape : enregitrement dans la base de donnee
            //declaration entity manager
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $liste_users=new FosUser();
            $liste_users=$this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($user->getId()) ;
            $evenement->setIduser($liste_users);
            $em=$this->getDoctrine()->getManager();// la fonction getManager() est utiliser lors de l'ajout,suppression ou modification dans la base de donnee
            //persister l'objet modele dans l'ORM
            $em->persist($evenement);
            //sauvgarde les donnees dans la db
            $em->flush();

            return $this->redirectToRoute('gerer_events_admin');
        }

        return $this->render('@Admin\Evenement\AjouterEvents.html.twig', array(
            'form'=>$form->createView()

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

            return $this->redirectToRoute('gerer_events_admin');
        }

        return $this->render('@Admin\Evenement\ModifierEvents.html.twig', array(
            'form'=>$form->createView()

        ));
    }

    public function deleteAction($id)
    {

        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository(Evenement::class)->find($id);
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('gerer_events_admin');
        return $this->render('@Admin\Evenement\gererEvents.html.twig', array(

        ));
    }

    public function approuverAction($id)
    {

        $this->getDoctrine()->getManager()->getRepository(Evenement::class)->approuvereEtat($id) ;
        return $this->redirectToRoute('gerer_events_admin');
        return $this->render('@Admin\Evenement\gererEvents.html.twig', array(

        ));
    }

}
