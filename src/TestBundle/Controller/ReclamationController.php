<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TestBundle\Entity\Article;
use TestBundle\Entity\FosUser;
use TestBundle\Entity\Reclamation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;
use TestBundle\Form\ReclamationType;

class ReclamationController extends Controller
{
    /**
     * Lists all reclamation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reclamations = $em->getRepository(Reclamation::class)->findAll();

        return $this->render('@Test/Reclamation/index.html.twig', array(
            'reclamations' => $reclamations,
        ));
    }
    /**
     * @Route("/read")
     */
    public function readAction()
    {
        return $this->render('TestBundle:Reclamation:read.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/Test/reclamation/new", name="reclamation_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
    $reclamation = new Reclamation();
            $form = $this->createForm(ReclamationType::class,$reclamation);
            $form->handleRequest($request);
            $securityContext = $this->container->get('security.authorization_checker');
            if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)

    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $fosusers = new FosUser();
    $fosusers = $this->getDoctrine()->getManager()->getRepository(FosUser::class)->find($user->getId());
    $reclamation->setIduser($fosusers);
    $reclamation = $form->getData();
    $em = $this->getDoctrine()->getManager();
    $em->persist($reclamation);
    $em->flush();

                }

return $this->render('@Test/Reclamation/new.html.twig', array(
    'form' => $form->createView(),
    'title' => 'Add'
));
}





    /**
     * @Route("/Test/Reclamation/show", name="Reclamation_read")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function showAction(Reclamation $reclamation)
    {
        {
            $deleteForm = $this->createDeleteForm($reclamation);

            return $this->render('@Test\reclamation\show.html.twig', array(
                'reclamation' => $reclamation,
                'delete_form' => $deleteForm->createView(),
            ));
        }

    }

    /**
     * @Route("/edit")
     */
    public function editAction()
    {
        $deleteForm = $this->createDeleteForm($reclamation);
        $editForm = $this->createForm('PiBundle\Form\ReclamationType', $reclamation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamation_edit', array('id' => $reclamation->getId()));
        }

        return $this->render('reclamation/edit.html.twig', array(
            'reclamation' => $reclamation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/delete")
     */
    public function deleteAction()
    {
        $form = $this->createDeleteForm($reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reclamation);
            $em->flush();
        }

        return $this->redirectToRoute('reclamation_index');
    }

    private function createDeleteForm(Reclamation $reclamation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reclamation_delete', array('id' => $reclamation->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
