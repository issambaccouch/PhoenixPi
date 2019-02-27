<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use TestBundle\Entity\Categorieprod;
use TestBundle\Entity\Favoris;
use TestBundle\Entity\FosUser;
use TestBundle\Entity\Produit;
use TestBundle\Form\CategorieprodType;
use TestBundle\Form\ProduitType;

class ProduitController extends Controller
{
    public function createAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $fosusers=new FosUser();
        $fosusers=$this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($user->getId()) ;
        $prod = new Produit(); // objet vide
        $form = $this->createForm(ProduitType::class,$prod);// Préparation du formulaire
        $form=$form->handleRequest($request);// Récuperation des données
        if($form->isValid())// test if our form is valid
        {
            $prod->setEnpromo(0);
            $prod->setEtatpr(0);
            $em=$this->getDoctrine()->getManager(); // Déclaration Entity Manager
            $em->persist($prod); // Persister l'objet modele dans l'ORM
            $em->flush(); // Sauvegarde des données dans la BD
            return $this->redirectToRoute('read');
        }else
            return $this->render('@Test\Produit\create_prod.html.twig', array('form'=>$form->createView()
                // ...
            ));
    }

    public function readAction(Request $request)
    {
        (int)$prix=$request->get('nom');
        if($prix <> null){
            $em = $this->get('doctrine.orm.entity_manager');
            $dql = "SELECT a FROM TestBundle:Produit a where a.etatpr=1 AND a.prix='$prix'";
            $query = $em->createQuery($dql);


            $cats = $this->getDoctrine()->getRepository(Categorieprod::class)->findAll();
            $nbr_prod = $this->getDoctrine()->getRepository(Produit::class)->compterProduitParPrix($prix);

            $paginator = $this->get('knp_paginator');
            $result = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                $request->query->getInt('Limit', 6)


            );

        }else {

            $em = $this->get('doctrine.orm.entity_manager');
            $dql = "SELECT a FROM TestBundle:Produit a where a.etatpr=1";
            $query = $em->createQuery($dql);


            $cats = $this->getDoctrine()->getRepository(Categorieprod::class)->findAll();
            $nbr_prod = $this->getDoctrine()->getRepository(Produit::class)->compterProduit();

            $paginator = $this->get('knp_paginator');
            $result = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                $request->query->getInt('Limit', 6)


            );
        }

        return $this->render('@Test\Produit\read_prod2.html.twig', array(
            'Produits'=>$result,
            'cats'=>$cats,
            'nbr'=>$nbr_prod
        ));

    }

    public function updateAction(Request $request,$idpr)
    {

        $em=$this->getDoctrine()->getManager();//appel du manager pour la modification
        $prod=$em->getRepository(Produit::class)->find($idpr);//recupération de l'objet
        // preparation formulaire
        $form=$this->createForm(ProduitType::class,$prod);
        //recuperation des données
        $form=$form->handleRequest($request);
        if ($form->isValid())
        {
            $prod->setEtatpr(0);
            $em=$this->getDoctrine()->getManager(); // Déclaration Entity Manager
            $em->persist($prod);
            $em->flush();
            return $this->redirectToRoute('read');
        }



        return $this->render('@Test\Produit\update_prod.html.twig', array(
            // ...
            'form'=>$form->createView()
        ));
    }

    public function deleteAction($idpr)
    {
        $em=$this->getDoctrine()->getManager();
        $prod=$em->getRepository(Produit::class)->find($idpr);
        $em->remove($prod);
        $em->flush();
        return $this->redirectToRoute('read');
    }


    public function DetailProdAction($idpr)
    {
        $em=$this->getDoctrine()->getManager();
        $prod=$em->getRepository(Produit::class)->find($idpr);
        $cats=$this->getDoctrine()->getRepository(Categorieprod::class)->find($prod->getIdcp());
        $user=$this->getDoctrine()->getRepository(FosUser::class)->find($prod->getIduser());


        return $this->render('@Test\Produit\detail_prod.html.twig', array(

            'produits'=>$prod,
            'users'=>$user,
            'cats'=>$cats

        ));
    }

    public function DetailMesProdAction($idpr)
    {
        $em=$this->getDoctrine()->getManager();
        $prod=$em->getRepository(Produit::class)->find($idpr);
        $cats=$this->getDoctrine()->getRepository(Categorieprod::class)->find($prod->getIdcp());
        $user=$this->getDoctrine()->getRepository(FosUser::class)->find($prod->getIduser());

        return $this->render('@Test\Produit\detail_MesProd.html.twig', array(

            'produits'=>$prod,
            'users'=>$user,
            'cats'=>$cats
        ));
    }

    public function readMesProdAction(Request $request){


        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $fosusers=new FosUser();
        $fosusers=$this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($user->getId()) ;

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM TestBundle:Produit a where a.etatpr=1 and a.iduser='$fosusers'";
        $query = $em->createQuery($dql);

        $cats=$this->getDoctrine()->getRepository(Categorieprod::class)->findAll();
        $favoris=$this->getDoctrine()->getRepository(Favoris::class)->findAll();
        $nbr_prod=$this->getDoctrine()->getRepository(Produit::class )->compterMesProduit($fosusers);

        $paginator  = $this->get('knp_paginator');
        $result=$paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            $request->query->getInt('Limit',6)


        );

        return $this->render('@Test\Produit\read_MesProd.html.twig', array(
            'Produits'=>$result,
            'cats'=>$cats,
            'nbr'=>$nbr_prod,
            'favoris'=>$favoris,
            'fos'=>$fosusers
        ));

    }
    public function readProdFilterAction(Request $request,$idcat){
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM TestBundle:Produit a where a.etatpr=1 and a.idcp='$idcat'";
        $query = $em->createQuery($dql);





        $cats=$this->getDoctrine()->getRepository(Categorieprod::class)->find($idcat);
        $nbr_prod=$this->getDoctrine()->getRepository(Produit::class )->compterFiltredProduit($idcat);

        $paginator  = $this->get('knp_paginator');
        $result=$paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            $request->query->getInt('Limit',6)


        );

        return $this->render('@Test\Produit\prod_filtred.html.twig', array(
            'Produits'=>$result,
             'cats'=>$cats,
            'nbr'=>$nbr_prod
        ));


    }
    public function readMyProdFilterAction(Request $request,$idcat){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $fosusers=new FosUser();
        $fosusers=$this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($user->getId()) ;

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM TestBundle:Produit a where a.etatpr=1 and a.idcp='$idcat' AND a.iduser='$fosusers'";
        $query = $em->createQuery($dql);






        $nbr_prod=$this->getDoctrine()->getRepository(Produit::class )->compterMyFiltredProduit($idcat,$fosusers);
        $cats=$this->getDoctrine()->getRepository(Categorieprod::class)->find($idcat);
        $cat=$this->getDoctrine()->getRepository(Categorieprod::class)->findAll();
        $favoris=$this->getDoctrine()->getRepository(Favoris::class)->findAll();

        $paginator  = $this->get('knp_paginator');
        $result=$paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            $request->query->getInt('Limit',6)


        );

        return $this->render('@Test\Produit\Myprod_filtred.html.twig', array(
            'Produits'=>$result,
             'cats'=>$cats,
            'cat'=>$cat,
            'favoris'=>$favoris,
            'fos'=>$fosusers,
            'nbr'=>$nbr_prod
        ));

    }
    public function readAdminAction(Request $request){



        $prod=$this->getDoctrine()->getRepository(Produit::class )
            ->findByEtatProdAdmin();


        if ($request->isXmlHttpRequest())
        {
            $nom=$request->get('nom');

            $produits=$this->getDoctrine()->getRepository(Produit::class)->findBCats($nom);
            //inisialisation de serializer
            $se=new Serializer(array(new ObjectNormalizer()));
            //normalisation de la liste
            $data=$se->normalize($produits);
            return new  JsonResponse($data);

        }
        return $this->render('@Test\Produit\read_prod.html.twig', array(
            'Produits'=>$prod
        ));




    }
    public function approuveAction($idpr){
        $em=$this->getDoctrine()->getManager();
        $prod=$em->getRepository(Produit::class)->find($idpr);
        $prod->setEtatpr(1);
        $em=$this->getDoctrine()->getManager(); // Déclaration Entity Manager
        $em->persist($prod);
        $em->flush();
        return $this->redirectToRoute('read_admin');

    }
    public function readRecAction(Request $request){
        $em    = $this->get('doctrine.orm.entity_manager');

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $fosusers=new FosUser();
        $fosusers=$this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($user->getId()) ;










        $dql   = "SELECT a FROM TestBundle:Produit a where a.etatpr=1 and a.idcp in (SELECT IDENTITY(f.idcp) from TestBundle:Favoris f WHERE f.iduser='$fosusers')";
        $query = $em->createQuery($dql);





        $cats=$this->getDoctrine()->getRepository(Categorieprod::class)->findAll();
        $nbr_prod=$this->getDoctrine()->getRepository(Produit::class )->compterRecProduit($fosusers);

        $paginator  = $this->get('knp_paginator');
        $result=$paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            $request->query->getInt('Limit',6)


        );

        return $this->render('@Test\Produit\read_prod2.html.twig', array(
            'Produits'=>$result,
            'cats'=>$cats,
            'nbr'=>$nbr_prod
        ));

    }

    public function MailSendAction($id){

        $em    = $this->get('doctrine.orm.entity_manager');
        $cat=$this->getDoctrine()->getRepository(Categorieprod::class)->findAll();
        $prod=$em->getRepository(Produit::class)->find(3);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $fosusers=new FosUser();
        $fosusers=$this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($user->getId()) ;
        $owner=$this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($id) ;
        $mail_owner=$owner->getEmail();


        require_once 'C:\xampp\htdocs\pidevtow\vendor\autoload.php';

// Create the Transport
        $transport = (new \Swift_SmtpTransport('localhost', 25))
            ->setUsername('FERCHICHI.2 Ahmed')
            ->setPassword('Genkobeloba 58')
        ;

// Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

// Create a message
        $message = (new \Swift_Message('About Product Eco-System'))
            ->setFrom(['ahmed.ferchichi.2@esprit.tn' => 'Admin'])
            ->setTo([$mail_owner => $owner->getUsername()])
            ->setBody('Mr/M/Mlle'.$fosusers->getUsername()."veut acheter votre produit et ceci le mail a contacter".$fosusers->getEmail()." Cordialement")
        ;

// Send the message
        $result = $mailer->send($message);
        return $this->render('@Test\Produit\detail_prod.html.twig', array(

            'produits'=>$prod,
            'users'=>$fosusers,
            'cats'=>$cat

        ));







    }










}
