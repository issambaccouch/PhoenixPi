<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Entity\Promotion;
use TestBundle\Entity\FosUser;
use TestBundle\Form\PromotionType;

class PromotionController extends Controller
{

    public function readAction()
    {
        // parcourir la base de donne
        $user=new FosUser();
        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $promos=$this->getDoctrine()->getRepository(Promotion::class)->findByiduser($user) ;//getdoctrine permet d'acceder au donner de la base de donnee tandis que getrepostory est utiliser pour lire des donnees de la base de donnee elle utiliser lorsque la fonction read et la methode findall() permet de lire tout les donnee de la table desirer
        return $this->render('@Test\Promotion\gererPromo.html.twig', array(
            'promos'=>$promos
        ));
    }



    public function ajouterAction(Request $request)
    {
        $promotion=new Promotion();
        //1er etape: preparation form
        $form=$this->createForm(PromotionType::class,$promotion);
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
            $promotion->setIduser($fosusers);
            $em=$this->getDoctrine()->getManager();// la fonction getManager() est utiliser lors de l'ajout,suppression ou modification dans la base de donnee
            //persister l'objet modele dans l'ORM
            $em->persist($promotion);
            //sauvgarde les donnees dans la db
            $em->flush();

            return $this->redirectToRoute('gerer_promo');
        }

        return $this->render('@Test\Promotion\AjouterPromo.html.twig', array(
            'form'=>$form->createView()

        ));
    }


    public function deleteAction($id)
    {

        $em=$this->getDoctrine()->getManager();
        $promotion=$em->getRepository(Promotion::class)->find($id);
        $em->remove($promotion);
        $em->flush();
        return $this->redirectToRoute('gerer_promo');
        return $this->render('@Test\Promotion\gererPromo.html.twig', array(

        ));
    }


    public function updateAction(Request $request,$id)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $promos=$this->getDoctrine()->getRepository(Promotion::class)->findByiduser($user) ;
        //1er etape: recuperation des donnee (objet avec id en parametre) de la BD
        $promotion=$this->getDoctrine()->getManager()->getRepository(Promotion::class)->find($id) ;//remarque : ici on  utiliser la methode getmanager pour faire la modification
        //2er etape: preparation form
        $form=$this->createForm(PromotionType::class,$promotion);
        //4eme etape : recuperation du formulaire
        $form=$form->handleRequest($request);
        if ($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('gerer_promo');
        }

        return $this->render('@Test\Promotion\ModifierPromo.html.twig', array(
            'form'=>$form->createView()

        ));
    }

}
