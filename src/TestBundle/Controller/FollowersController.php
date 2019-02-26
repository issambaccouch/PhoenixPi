<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TestBundle\Entity\Followers;
use TestBundle\Entity\FosUser;

class FollowersController extends Controller
{
    public function listeforAction()
    {
        $foll=$this->getDoctrine()->getRepository(FosUser::class )
            ->findAll();
        $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM TestBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_FORMATEUR"%');
        $users = $query->getResult();
        $folws=$this->getDoctrine()->getRepository(Followers::class )
            ->findAll();
        return $this->render('@Test/Followers/listefor.html.twig', array(
            'foll'=>$users,
            'folws'=>$folws
        ));
    }

    public function listewsAction()
    {

        return $this->render('TestBundle:Followers:listews.html.twig', array(
            // ...
        ));
    }


    public function createfAction($idformateur)
    {
        $foll = new Followers (); // objet vide

        $id=$this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $foll->setIdadherent($this->getDoctrine()->getRepository(FosUser::class )->find($id));

        $foll->setIdformateur($this->getDoctrine()->getRepository(FosUser::class )->find($idformateur));

            $em=$this->getDoctrine()->getManager(); // Déclaration Entity Manager
            $em->persist($foll); // Persister l'obje dans l'ORM
            $em->flush(); // Sauvegarde des données dans la BD
                // ...

                    return $this->redirectToRoute('mesfollowers');




    }


    public function mesfollowersAction()
    {
        $foll=$this->getDoctrine()->getRepository(Followers::class )
            ->findAll();
        $user=$this->getDoctrine()->getRepository(FosUser::class )
            ->findAll();
        return $this->render('@Test/Followers/mesfollowers.html.twig', array(
            'foll'=>$foll,'users'=>$user
        ));
    }
    public function removeFolAction($idfoll)
    {
        $em=$this->getDoctrine()->getManager();
        $follow=$em->getRepository(Followers::class)->find($idfoll);
        $em->remove($follow);
        $em->flush();
        return $this->redirectToRoute('mesfollowers');
    }
}
