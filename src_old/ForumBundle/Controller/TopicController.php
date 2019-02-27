<?php

namespace ForumBundle\Controller;

use ForumBundle\Controller\Base\BaseTopicController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use ForumBundle\Form\Type\TopicEditType;
use ForumBundle\Entity\Forum;
use ForumBundle\Entity\Topic;
use Symfony\Component\HttpFoundation\Request;

/**
 * TopicController
 * @access   public
 */
class TopicController extends BaseTopicController
{
    /**
     *
     * @Route("/cat/{slug}", name="forum_topic")
     * @ParamConverter("forum")
     * @Security("is_granted('CanReadForum', forum)")
     * @param Request $request
     * @param Forum $forum
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function topicAction(Request $request, Forum $forum)
    {
        $topics = $forum->getTopics(); 
        
        $pagination = $this->get('forum.pagin')->pagignate('topics', $topics);
        
        if (($form = $this->generateTopicForm($forum)) !== NULL) {
            $form->handleRequest($request);

            if (($form->isSubmitted()) && ($form->isValid())) 
            {
                $content = $form->get('content')->getData();
                $post = $this->createPost($content, $this->topic);
                $em = $this->getEm();
                $em->persist($this->topic);
                $em->persist($post);
                $em->flush();

                $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('forum.topic.create'));
                return $this->redirect($this->generateUrl('forum_post', array('slug' => $this->topic->getSlug())));
            }

            $form = $form->createView();
        }
        
        return $this->render('@Forum/topic.html.twig', array(
            'forum' => $forum,
            'pagination' => $pagination,
            'form' => $form
        ));
    }

    /**
     * @Route("/topic/delete/{id}", name="forum_topic_delete")
     * @ParamConverter("topic")
     * @Security("has_role('ROLE_MODERATOR') and is_granted('CanReadTopic', topic)")
     *
     * @param Request $request
     * @param Topic $topic
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Topic $topic)
    {
        $forumSlug = $topic->getForum()->getSlug();
        $em = $this->getEm();
        $em->remove($topic);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('forum.topic.delete'));

        return $this->redirect($this->generateUrl('forum_topic', array('slug' => $forumSlug)));
    }

    /**
     * @Route("/topic/edit/{id}", name="forum_topic_edit")
     * @ParamConverter("topic")
     * @Security("has_role('ROLE_MODERATOR') and is_granted('CanReadTopic', topic)")
     *
     * @param Request $request
     * @param Topic $topic
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Topic $topic)
    {
        $form = $this->createForm(TopicEditType::class, $topic);
        
        $form->handleRequest($request);
        
        if (($form->isSubmitted()) && ($form->isValid())) 
        {
            $forumSlug = $topic->getForum()->getSlug();
            $this->getEm()->flush();
            $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('forum.topic.edit'));
            return $this->redirect($this->generateUrl('forum_topic', array('slug' => $forumSlug)));
        }
         
        return $this->render('@Forum/Form/topic_edit.html.twig', array(
            'form'  => $form->createView()
        ));
    }
}
