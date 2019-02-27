<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TestBundle\Entity\FosUser;

class DefaultController extends Controller
{
    public function indexAction()
    { $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $fosusers=new FosUser();
        $fosusers=$this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($user->getId()) ;

        return $this->render('@Admin/Default/index.html.twig');
    }
}
