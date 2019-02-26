<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Entity\Favoris;
use TestBundle\Entity\FosUser;
use TestBundle\Entity\Categorieprod;

class FavorisController extends Controller
{
    public function createAction(Request $request,$idcp)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $fosusers=new FosUser();
        $fosusers=$this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($user->getId()) ;

        $cats=$this->getDoctrine()->getRepository(Categorieprod::class)->find($idcp);

        $fovoris=new Favoris();
        $fovoris->setIdcp($cats);
        $fovoris->setIduser($fosusers);
        $em=$this->getDoctrine()->getManager();
        $em->persist($fovoris);
        $em->flush();
        return $this->redirectToRoute('read_mesProd');

    }

    public function deleteAction($idfav)
    {
        $em=$this->getDoctrine()->getManager();
        $fav=$em->getRepository(Favoris::class)->find($idfav);
        $em->remove($fav);
        $em->flush();
        return $this->redirectToRoute('read_mesProd');
    }

}
