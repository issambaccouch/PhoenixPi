<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Entity\Tags;
use TestBundle\Form\TagsType;

class TagsController extends Controller
{
    /**
     * @Route("/Test/tags/create", name="tags_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAction(Request $request)
    {

            $tags = new Tags();
            $form = $this->createForm(TagsType::class, $tags);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $tags = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($tags);
                $em->flush();


                return $this->redirectToRoute('tags_read');


            }

            return $this->render('@Test/Tags/create.html.twig', array(
                'form'  => $form->createView(),
                'title' => 'Add'
            ));
        }

    public function updateAction($idtag,Request $request)
    {
        //recuperation des données (objet avec ID en parametre) de la bd
        $em=$this->getDoctrine()->getManager();//appel du manager pour la modification
        $tags=$em->getRepository(Tags::class)->find($idtag);//recupération de l'objet
        // preparation formulaire
        $form=$this->createForm(TagsType::class,$tags);
        //recuperation des données
        $form=$form->handleRequest($request);
        if ($form->isValid())
        {
            $em->flush();
            //redirection vers read
            return $this->redirectToRoute('tags_read');
        }



        return $this->render('@Test/Tags/update.html.twig', array(
            // ...
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/Test/tags/read", name="tags_read")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function readAction()
    {
        $tags = $this->getDoctrine()
            ->getRepository(Tags::class)->findAll();

        return $this->render('@Test/tags/read.html.twig', ['tags' => $tags]);
    }
    public function deleteAction($idtag)
    {
        $em=$this->getDoctrine()->getManager();
        $tags=$em->getRepository(Tags::class)->find($idtag);
        $em->remove($tags);
        $em->flush();
        return $this->redirectToRoute('tags_read');
    }

}
