<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TestBundle\Entity\FosUser;
use TestBundle\Entity\Participation;
use TestBundle\Entity\Workshop;

class ParticipationController extends Controller
{
    public function participateAction($idws)
    {
        $part = new Participation (); // objet vide

        $id=$this->container->get('security.token_storage')->getToken()->getUser()->getId();
       // $part->setIdadherent($this->getDoctrine()->getRepository(FosUser::class )->find($id));
        $part->setIdadherent($id);
        $part->setIdws($idws);

        $em=$this->getDoctrine()->getManager(); // Déclaration Entity Manager
        $em->persist($part); // Persister l'objet modele dans l'ORM
        $em->flush(); // Sauvegarde des données dans la BD
        // ...
        $em2=$this->getDoctrine()->getManager();//appel du manager pour la modification
        $work=$em2->getRepository(workshop::class)->find($idws);
        $nb=$work->getNbrws()-1;
		$work->setNbrws($nb);
		$em2->flush();


                    return $this->redirectToRoute('mesparticipations');
    }



    public function mesparticipationsAction()
    {
        $part=$this->getDoctrine()->getRepository(Participation::class )
            ->findAll();
        $work=$this->getDoctrine()->getRepository(Workshop::class )
            ->findAll();
        return $this->render('@Test/Participation/mesparticipations.html.twig', array(
            'part'=>$part,'works'=>$work
        ));
    }

}



