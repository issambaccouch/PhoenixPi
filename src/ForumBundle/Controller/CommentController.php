<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Post;
use ForumBundle\ForumBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CommentController extends Controller
{
    /**
     * @Route("/searchcomment", name="searchcomment")
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function searchAction( Request $request)
    {
        $cats=$this->getDoctrine()->getRepository('TestBundle:Proposition' )->FindAll();
        if ($request->isXmlHttpRequest())
        {
            $nom=$request->get('nom');
            dump($nom);
            $cats=$this->getDoctrine()->getRepository('TestBundle:Proposition')->FindByNom($nom);
            $se=new Serializer(array(new ObjectNormalizer()));
            $data=$se->normalize($cats);
            return new  JsonResponse($data);
        }
        return $this->render('@Forum/Comment/searchcomment.html.twig', array(
            'cats'=>$cats
        ));
    }

}
