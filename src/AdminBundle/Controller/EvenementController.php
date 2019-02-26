<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Evenement;
use AdminBundle\Entity\FosUser;
use AdminBundle\Entity\Promotion;
use AdminBundle\Form\EvenementType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EvenementController extends Controller
{
    public function readAction(Request $request)
    {
        // parcourir la base de donne
        $evenements=$this->getDoctrine()->getRepository(Evenement::class)->findAll() ;//getdoctrine permet d'acceder au donner de la base de donnee tandis que getrepostory est utiliser pour lire des donnees de la base de donnee elle utiliser lorsque la fonction read et la methode findall() permet de lire tout les donnee de la table desirer
        if ($request->isXmlHttpRequest())
        {
            $nom=$request->get('nom');
            $evenements=$this->getDoctrine()->getRepository(Evenement::class)->findBynomev($nom);
            //inisialisation de serializer
            $se=new Serializer(array(new ObjectNormalizer()));
            //normalisation de la liste
            $data=$se->normalize($evenements);
            return new  JsonResponse($data);
        }
        return $this->render('@Admin\Evenement\gererEvents.html.twig', array(
            'evenements'=>$evenements
        ));
    }


    public function readEnCoursAction()
    {
        // parcourir la base de donne
        $evenements=$this->getDoctrine()->getRepository(Evenement::class)->EventsEnCours() ;//getdoctrine permet d'acceder au donner de la base de donnee tandis que getrepostory est utiliser pour lire des donnees de la base de donnee elle utiliser lorsque la fonction read et la methode findall() permet de lire tout les donnee de la table desirer
        return $this->render('@Admin\Evenement\gererEventsEnCours.html.twig', array(
            'evenements'=>$evenements
        ));
    }



    public function readAValiderAction()
    {
        // parcourir la base de donne
        $evenements=$this->getDoctrine()->getRepository(Evenement::class)->EventsAValider() ;//getdoctrine permet d'acceder au donner de la base de donnee tandis que getrepostory est utiliser pour lire des donnees de la base de donnee elle utiliser lorsque la fonction read et la methode findall() permet de lire tout les donnee de la table desirer
        return $this->render('@Admin\Evenement\gererEventsAValider.html.twig', array(
            'evenements'=>$evenements
        ));
    }




    public function readArchiveAction()
    {
        // parcourir la base de donne
        $evenements=$this->getDoctrine()->getRepository(Evenement::class)->EventsArchiver() ;//getdoctrine permet d'acceder au donner de la base de donnee tandis que getrepostory est utiliser pour lire des donnees de la base de donnee elle utiliser lorsque la fonction read et la methode findall() permet de lire tout les donnee de la table desirer
        return $this->render('@Admin\Evenement\gererEventsArchive.html.twig', array(
            'evenements'=>$evenements
        ));
    }



    public function ajouterAction(Request $request)
    {
        $evenement=new Evenement();
        //1er etape: preparation form
        $form=$this->createForm(EvenementType::class,$evenement);
        //2eme etpae: recuperation des donnees
        $form =$form->handleRequest($request);
        //tester la validiter de notre saisie
        if($form->isValid())
        {
            //3eme etape : enregitrement dans la base de donnee
            //declaration entity manager
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $liste_users=new FosUser();
            $liste_users=$this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($user->getId()) ;
            $evenement->setIduser($liste_users);
            $evenement->setEtatev(1);
            if ($evenement->getDatedebut()<$evenement->getDatefin()) {
                $em = $this->getDoctrine()->getManager();// la fonction getManager() est utiliser lors de l'ajout,suppression ou modification dans la base de donnee
                //persister l'objet modele dans l'ORM
                $em->persist($evenement);
                //sauvgarde les donnees dans la db
                $em->flush();
                date_default_timezone_set('Africa/Tunis');
                $date= date("Y-m-d");
                $this->getDoctrine()->getManager()->getRepository(Evenement::class)->updateEtat($date);

                return $this->redirectToRoute('gerer_events_admin');
            }
        }

        return $this->render('@Admin\Evenement\AjouterEvents.html.twig', array(
            'form'=>$form->createView()

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

            return $this->redirectToRoute('gerer_events_admin');
        }

        return $this->render('@Admin\Evenement\ModifierEvents.html.twig', array(
            'form'=>$form->createView()

        ));
    }

    public function deleteAction($id)
    {

        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository(Evenement::class)->find($id);
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('gerer_events_admin');
        return $this->render('@Admin\Evenement\gererEvents.html.twig', array(

        ));
    }

    public function approuverAction($id)
    {

        $this->getDoctrine()->getManager()->getRepository(Evenement::class)->approuvereEtat($id) ;
        return $this->redirectToRoute('gerer_events_admin');
        return $this->render('@Admin\Evenement\gererEvents.html.twig', array(

        ));
    }



    public function statistiqueAction()
    {
        $pieChart = new PieChart();
        $em= $this->getDoctrine();
        $totalEvents=$em->getRepository(Evenement::class)->NombreDesEvenements();
        $EventsArchive=($em->getRepository(Evenement::class)->NombreDesEvenementsArchiver()*100)/$totalEvents;
        $EventsEnCours=($em->getRepository(Evenement::class)->NombreDesEvenementsEnCours()*100)/$totalEvents;
        $EventsAValider=($em->getRepository(Evenement::class)->NombreDesEvenementsAValider()*100)/$totalEvents;
        $pieChart->getData()->setArrayToDataTable(
            [['etat evenement', 'etat'],
                ['Approuver',     $EventsAValider],
                ['En cours',      $EventsEnCours],
                ['Archiver',  $EventsArchive],
            ]
        );
        $pieChart->getOptions()->setTitle('Pourcentages des evenements selon leurs etats');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        //**************************************************************************************

        $pieChart1 = new PieChart();
        $em= $this->getDoctrine();
        $totalPromo=$em->getRepository(Promotion::class)->NombreDesPromotions();
        $Promos_0_25=($em->getRepository(Promotion::class)->NombreDesPromos_0_25()*100)/$totalPromo;
        $Promos_25_50=($em->getRepository(Promotion::class)->NombreDesPromos_25_50()*100)/$totalPromo;
        $Promos_50_75=($em->getRepository(Promotion::class)->NombreDesPromos_50_75()*100)/$totalPromo;
        $Promos_75_100=($em->getRepository(Promotion::class)->NombreDesPromos_75_100()*100)/$totalPromo;
        $pieChart1->getData()->setArrayToDataTable(
            [['etat evenement', 'etat'],
                ['0%-25%',     $Promos_0_25],
                ['25%-50%',      $Promos_25_50],
                ['50%-75%',  $Promos_50_75],
                ['75%-100%',  $Promos_75_100],
            ]
        );
        $pieChart1->getOptions()->setTitle('Pourcentages des promotion par pourcentage');
        $pieChart1->getOptions()->setHeight(500);
        $pieChart1->getOptions()->setWidth(900);
        $pieChart1->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart1->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart1->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart1->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart1->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('@Admin\statistique.html.twig', array(
            'piechart' => $pieChart,'piechart1' => $pieChart1
        ));
    }

}
