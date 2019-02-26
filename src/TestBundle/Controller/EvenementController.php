<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use TestBundle\Entity\Evenement;
use TestBundle\Entity\FosUser;
use TestBundle\Entity\Interesser;
use TestBundle\Form\EvenementType;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Overlay\Animation;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\Marker;
use Ivory\GoogleMap\Overlay\MarkerShape;
use Ivory\GoogleMap\Overlay\MarkerShapeType;
use Ivory\GoogleMap\Overlay\Symbol;
use Ivory\GoogleMap\Overlay\SymbolPath;

class EvenementController extends Controller
{
    public function readAction(Request $request)
    {
        // parcourir la base de donne
        $user=new FosUser();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if (is_string($user))
        { return $this->redirectToRoute('fos_user_security_login');}
        else {
            $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findByiduser($user->getId());//getdoctrine permet d'acceder au donner de la base de donnee tandis que getrepostory est utiliser pour lire des donnees de la base de donnee elle utiliser lorsque la fonction read et la methode findall() permet de lire tout les donnee de la table desirer
            if ($request->isXmlHttpRequest()) {
                $nom = $request->get('nom');
                $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findBynomev($nom);
                //inisialisation de serializer
                $se = new Serializer(array(new ObjectNormalizer()));
                //normalisation de la liste
                $data = $se->normalize($evenements);
                return new  JsonResponse($data);
            }
        }
        return $this->render('@Test\Evenement\gererEvents.html.twig', array(
           'evenements'=>$evenements
        ));
    }



    public function detailAction(Request $request,$id)
    {
        $map = new Map();
        $marker = new Marker(
            new Coordinate(),
            Animation::BOUNCE,
            new Icon(),
            new Symbol(SymbolPath::CIRCLE),
            new MarkerShape(MarkerShapeType::CIRCLE, [1.1, 2.1, 1.4]),
            ['clickable' => false]
        );
        $marker->setPosition(new Coordinate(36.7850918 , 10.16921997));
        $marker->setAnimation(Animation::DROP);
        $marker->setOption('flat', true);
        $marker->setStaticOption('location', 'Paris, France');
        $map->getOverlayManager()->addMarker($marker);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $evenement=$this->getDoctrine()->getManager()->getRepository(Evenement::class)->find($id);
        $interesser=$this->getDoctrine()->getManager()->getRepository(Interesser::class)->findOneByiduser($user->getId());
        $verif="false";
        if (empty($interesser))
            $verif="true";
        return $this->render('@Test\Evenement\Details.html.twig', array(
            'evenement'=>$evenement,'map'=>$map,'user'=>$user,'interesser'=>$interesser,'verif'=>$verif
        ));
    }



    public function consulterAction()
    {
        date_default_timezone_set('Africa/Tunis');
        $date= date("Y-m-d");
        $this->getDoctrine()->getManager()->getRepository(Evenement::class)->updateEtat($date);
        $etat=1;
        $evenements=$this->getDoctrine()->getRepository(Evenement::class)->findByetatev($etat);
        return $this->render('@Test\Evenement\consulter.html.twig', array(
            'evenements'=>$evenements
        ));
    }


    public function ajouterAction(Request $request)
    {

        $error=0;
        $evenement=new Evenement();
        //1er etape: preparation form
        $form=$this->createForm(EvenementType::class,$evenement);
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
            $evenement->setIduser($fosusers);
            $evenement->setEtatev(0);
            if ($evenement->getDatedebut()<$evenement->getDatefin()) {
                $em = $this->getDoctrine()->getManager();// la fonction getManager() est utiliser lors de l'ajout,suppression ou modification dans la base de donnee
                //persister l'objet modele dans l'ORM
                $em->persist($evenement);
                //sauvgarde les donnees dans la db
                $em->flush();

                return $this->redirectToRoute('gerer_events');
            }
        }

        return $this->render('@Test\Evenement\AjouterEvents.html.twig', array(
            'form'=>$form->createView(),'error'=>$error

        ));
    }




    public function updateAction(Request $request,$id)
    {

        //1er etape: recuperation des donnee (objet avec id en parametre) de la BD
        $evenement=$this->getDoctrine()->getManager()->getRepository(Evenement::class)->find($id) ;//remarque : ici on  utiliser la methode getmanager pour faire la modification
        //2er etape: preparation form
        $form=$this->createForm(EvenementType::class,$evenement);
        //4eme etape : recuperation du formulaire
        $form=$form->handleRequest($request);
        if ($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('gerer_events');
        }

        return $this->render('@Test\Evenement\ModifierEvents.html.twig', array(
            'form'=>$form->createView()

        ));
    }

    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository(Evenement::class)->find($id);
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('gerer_events');
        return $this->render('@Test\Evenement\gererEvents.html.twig', array(

        ));
    }


    public function ParticiperAction($id)
    {
        $map = new Map();
        $marker = new Marker(
            new Coordinate(),
            Animation::BOUNCE,
            new Icon(),
            new Symbol(SymbolPath::CIRCLE),
            new MarkerShape(MarkerShapeType::CIRCLE, [1.1, 2.1, 1.4]),
            ['clickable' => false]
        );
        $marker->setPosition(new Coordinate(36.7850918 , 10.16921997));
        $marker->setAnimation(Animation::DROP);
        $marker->setOption('flat', true);
        $marker->setStaticOption('location', 'Paris, France');
        $map->getOverlayManager()->addMarker($marker);
        $interesser=new Interesser();
        $evenement=new Evenement();
        $evenement=$this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $iduser=$this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $fosuser=$this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($iduser) ;
        $interesser->setIdev( $evenement);
        $interesser->setIduser($fosuser);
        $em = $this->getDoctrine()->getManager();
        //persister l'objet modele dans l'ORM
        $em->persist($interesser);
        //sauvgarde les donnees dans la db
        $em->flush();
        $this->getDoctrine()->getManager()->getRepository(Evenement::class)->updateNbPartitipation($id);
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository(Evenement::class)->find($id);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $interesser=$this->getDoctrine()->getManager()->getRepository(Interesser::class)->findOneByiduser($user->getId());
        $verif="false";
        if (empty($interesser))
            $verif="true";
        return $this->render('@Test\Evenement\Details.html.twig', array(
            'evenement'=>$evenement,'map'=>$map,'verif'=>$verif,'user'=>$user
        ));
    }


}
