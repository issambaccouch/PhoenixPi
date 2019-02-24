<?php

namespace TestBundle\Controller;

use TestBundle\Entity\FosUser;
use TestBundle\Entity\Reclamation;
use TestBundle\Entity\Tags;
use TestBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TestBundle\Entity\Article;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use TestBundle\Repository\ArticleRepository;

class ArticleController extends Controller
{
    /**
     * @Route("/Test/article/create", name="article_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        {

            $article = new Article();
            $form = $this->createForm(ArticleType::class, $article);
            $form->handleRequest($request);
            $securityContext = $this->container->get('security.authorization_checker');
            if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            }
            if ($form->isValid()) {
                $imageart = $article->getImageart();
                if ($imageart !== null) {
                    $imageart = $article->getImageart();
                    $fileName = md5(uniqid()) . '.' . $imageart->getClientOriginalExtension();
                    $imageart->move(
                        $this->getParameter('images_directory',$fileName)
                    );
                    $article->setImageart($fileName);
                }
                $user = $this->container->get('security.token_storage')->getToken()->getUser();
                $fosusers = new FosUser();
                $fosusers = $this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($user->getId());
                $article->setIduser($fosusers);
                $article = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();


                return $this->redirectToRoute('article_read');


            }

            return $this->render('@Test/Article/create.html.twig', array(
                'form' => $form->createView(),
                'title' => 'Add'
            ));
        }
    }


    /**
     * @Route("/Test/Article/read", name="article_read")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function readAction(Request $request)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)->findAll();
        $tags = new Tags();
        $tags = $this->getDoctrine()->getManager()->getRepository(Tags::class)->findAll();
           return $this->render('@Test/Article/read.html.twig', ['article' => $article,
            'tags' => $tags]);
    }

    /**
     * @Route("/Test/Article/readsingle", name="article_readsingle")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function readsingleAction()
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)->findAll();
        $tags = new Tags();
        $tags = $this->getDoctrine()->getManager()->getRepository(Tags::class)->findAll();
        return $this->render('@Test/Article/read.html.twig', ['article' => $article,
            'tags' => $tags]);
    }

    public function deleteAction($idart)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($idart);
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('article_read');
    }

    public function updateAction( Request $request,$idart)
    {
        //recuperation des données (objet avec ID en parametre) de la bd
        $em = $this->getDoctrine()->getManager();//appel du manager pour la modification
        $article = $em->getRepository(Article::class)->find($idart);//recupération de l'objet
        // preparation formulaire
        $form = $this->createForm(Article::class,$article);
        //recuperation des données
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $em->flush();
            //redirection vers read
            return $this->redirectToRoute('article_read');
        }


        return $this->render('@Test/Article/update.html.twig', array(
            // ...
            'form' => $form->createView()
        ));
    }

    public function rechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
$articles=$em->getRepository(Article::class)->findAll();
        if ($request->isMethod("POST")) {
            if ($request->isXmlHttpRequest()) {
                $articles = $em->getRepository(Article::class)->findAjax($request->get('text'));
                $serializer = new Serializer(
                    array(
                        new ObjectNormalizer()
                    )
                );
                $data = $serializer->normalize($articles);
                return new JsonResponse($data);
            }
            return $this->render('@Test\Article\rech.html.twig', array('articles'=>$articles

            ));
        }
    }

    /**
     * @Route("/Test/Article/list", name="article_list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function listAction($idart )
    {
        $em=$this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository(Article::class) ->find($idart);
        $tags = new Tags();
        $tags = $this->getDoctrine()->getManager()->getRepository(Tags::class)->findAll();
        $reclamation = new Reclamation();
        $reclamation = $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->findAll();
               $user=$this->getDoctrine()->getRepository(FosUser::class)->find($article->getIduser());

        return $this->render('@Test/Article/list.html.twig', ['article' =>$this->viewarticle($article),'user'=>$user,'tags'=>$tags,'reclamation'=>$reclamation]);
        }




    public function pdfAction(Request $request)
    {
        $snappy=$this->get('knp_snappy.pdf');
        $snappy->setOption('no-outline', true);
        $snappy->setOption('page-size','LETTER');
        $snappy->setOption('encoding', 'UTF-8');
        $idart=$request->get('idart');
        $titre=$request->get('titre');
        $text=$request->get('text');
        $imageart=$request->get('imageart');
        $dateajout=($request->get('dateajout'));

        $html = $this->renderView('@Test\Article\pdf.html.twig',
            array( 'idart'=>$idart,'text'=>$text,
                'titre'=>$titre,'titre'=>$titre,'dateajout'=>$dateajout,'imageart'=>$imageart
            ));


        $filename = 'myFirstSnappyPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }

    /**
     * @param Article $article
     * @return Article
     */
    public function viewarticle(Article $article)
    {
        $article->addnbrvue();
        $em=$this->getDoctrine()->getManager();
        $em->persist($article);
            $em->flush();
        return $article;
    }
}