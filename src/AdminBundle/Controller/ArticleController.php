<?php

namespace AdminBundle\Controller;

use TestBundle\Entity\FosUser;
use TestBundle\Entity\Tags;
use TestBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TestBundle\Entity\Article;

class ArticleController extends Controller
{
    /**
     * @Route("/Admin/article/create", name="admin_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        {

            $article = new Article();
            $form = $this->createForm(ArticleType::class, $article);
            $form->handleRequest($request);

            if ( $form->isValid()) {
                $imageart = $article->getImageart();
                if ($imageart !== null) {
                    $imageart = $article->getImageart();
                    $fileName = md5(uniqid()).'.'.$imageart->getClientOriginalExtension();
                    $imageart->move(
                        $this->getParameter('images_directory',
                            $fileName)
                    );
                    $article->setImageart($fileName);
                }
                $user = $this->container->get('security.token_storage')->getToken()->getUser();
                $fosusers=new FosUser();
                $fosusers=$this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($user->getId()) ;

                $article->setIduser($fosusers);
                $article = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
                return $this->redirectToRoute('admin_read');


            }

            return $this->render('@Admin/Default/create.html.twig', array(
                'form'  => $form->createView(),
                'title' => 'Add'
            ));
        }}





        /**
     * @Route("/Admin/Article/read", name="admin_read")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function readAction()
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)->findAll();
        $tags=new Tags();
        $tags=$this->getDoctrine()->getManager()->getRepository(Tags::class)->findAll() ;


        return $this->render('@Admin/Default/read.html.twig', ['article' => $article,
            'tags'=>$tags]);
    }

    /**
     * @Route("/Admin/Article/read", name="article_read")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function readsingleAction()
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)->findAll();

        return $this->render('@Admin/Article/read.html.twig', ['article' => $article]);
    }
    public function deleteAction($idart)
    {
        $em=$this->getDoctrine()->getManager();
        $article=$em->getRepository(Article::class)->find($idart);
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('admin_read');
    }
    public function updateAction($idart,Request $request)
    {
        //recuperation des données (objet avec ID en parametre) de la bd
        $em=$this->getDoctrine()->getManager();//appel du manager pour la modification
        $article=$em->getRepository(Article::class)->find($idart);//recupération de l'objet
        // preparation formulaire
        $form=$this->createForm(ArticleType::class,$article);
        //recuperation des données
        $form=$form->handleRequest($request);
        if ($form->isValid())
        {
            $em->flush();
            //redirection vers read
            return $this->redirectToRoute('admin_read');
        }



        return $this->render('@Admin/Default/update.html.twig', array(
            // ...
            'form'=>$form->createView()
        ));
    }
    public function rechercheAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $article=$em->getRepository(Article::class)->findAll();
        if($request->isMethod('POST')) {
            $titre = $request->get('titre');
            $article = $em->getRepository(Article::class)->findBy(array("titre"=>$titre));
}
        return $this->render('@Test/Article/rech.html.twig',array('article'=>$article));
    }

    /**
     * @Route("/Test/article/list", name="article_list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function listAction($idart)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneById($idart);

        if ($article === null) {
            throw $this->createNotFoundException('The article does not exist');
        }

        return $this->render('@Admin/articles/list.html.twig', ['article' => $article]);
    }


}
