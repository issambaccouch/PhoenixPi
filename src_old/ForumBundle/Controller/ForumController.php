<?php

namespace ForumBundle\Controller;

use ForumBundle\Controller\Base\BaseController;
use ForumBundle\ForumBundle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ForumBundle\Entity\Category;
use ForumBundle\Entity\Forum;
use ForumBundle\Form\Type\ForumType;
use ForumBundle\Form\Type\Remover\RemoveForumType;
use ForumBundle\Repository\ForumRepository ;

/**
 * ForumController 
 * 
 * This class contains actions methods for forum.
 * This class extends BaseForumController.
 * 
 * @access   public
 */
class ForumController extends BaseController
{

    /**
     * @Route("", name="forum_homepage")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $categories = $this->getEm()
            ->getRepository(Category::class)
            ->findBy(array(), array('position' => 'asc', ));


        return $this->render('@Forum/index.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * @Route("/forum/new/{id}", name="forum_create_forum")
     * @ParamConverter("category")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newForumAction(Request $request, Category $category)
    {
        $forum = new Forum();
        $forum->setCategory($category);
        
        $form = $this->createForm(ForumType::class, $forum);

        $form->handleRequest($request);
        
        if (($form->isSubmitted()) && ($form->isValid())) 
        {
            $em = $this->getEm();
            $em->persist($forum);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('forum.forum.created'));
            return $this->redirect($this->generateUrl('forum_admin_dashboard'));
        }

        return $this->render('@Forum/Admin/forum.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("forum/edit/{id}", name="forum_edit_forum")
     * @ParamConverter("forum")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Forum $forum
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editForumAction(Request $request, Forum $forum)
    {
        $form = $this->createForm(ForumType::class, $forum);

        $form->handleRequest($request);
        
        if (($form->isSubmitted()) && ($form->isValid())) 
        {
            $em = $this->getEm();
            $em->persist($forum);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('forum.forum.edit'));
            return $this->redirect($this->generateUrl('forum_admin_dashboard'));
        }

        return $this->render('@Forum/Admin/forum.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("forum/remove/{id}", name="forum_remove_forum")
     * @ParamConverter("forum")
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Forum $forum
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function removeForumAction(Request $request, Forum $forum)
    {
        $form = $this->createForm(RemoveForumType::class);
        $em = $this->getEm();
        $form->handleRequest($request);
        
        if (($form->isSubmitted()) && ($form->isValid())) 
        {
            if ($form->getData()['purge'] === false) {
                $newFor = $em->getRepository(Forum::class)->find($form->getData()['movedTo']) ;
                foreach ($forum->getTopics() as $topic) { $topic->setForum($newFor); }
                $em->flush();
                $em->clear();
                $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('forum.forum.movedtopics'));
            }
            
            
            $forum = $em->getRepository(Forum::class)->find($forum->getId()); // Fix detach error
            $em->remove($forum);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('forum.forum.delete'));
            return $this->redirect($this->generateUrl('forum_admin_dashboard'));
        }
 
        return $this->render('@Forum/Admin/remove_forum.html.twig', array(
            'form' => $form->createView()
        ));
    }


}
