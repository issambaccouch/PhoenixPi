<?php

namespace ForumBundle\Controller;

use ForumBundle\Controller\Base\BasePostController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use ForumBundle\Entity\Post;
use ForumBundle\Form\Type\PostType;
use ForumBundle\Entity\Topic;
use Symfony\Component\HttpFoundation\Request;

/**
 * PostController 
 *
 * @access   public
 */
class PostController extends BasePostController
{

    /**
     * @Route("topic/{slug}", name="forum_post")
     * @ParamConverter("topic")
     * @Security("is_granted('CanReadTopic', topic)")
     *
     * @param Request $request
     * @param Topic $topic
     * @return object|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Request $request, Topic $topic)
    {
        $preview = false;
        $posts = $this->getPaginator()->pagignate('posts', $topic->getPosts());

        if (( $form = $this->generatePostForm($request, $topic) ) !== NULL) {
            $form->handleRequest($request);

            if (($form->isSubmitted()) && ($form->isValid())) 
            {
                if ( !$preview = $this->getPreview($request, $form, $this->post) ) 
                {
                    $em = $this->getEm();
                    $em->persist($this->post);
                    $em->flush();
                    $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('forum.post.create'));
                    return $this->redirectAfterPost($posts);
                }
            }
            $form = $this->autorizedPostForm($posts, $request, $form);
        }
        
        return $this->render('@Forum/post.html.twig', array(
            'topic' => $this->incrementeView($topic),
            'posts' => $posts,
            'form'  => $form,
            'postpreview' => $preview
        ));
    }

    /**
     * Delete a post and redirection in post page or topic page after delete.
     *
     * @Route("post/delete/{id}", name="forum_post_delete")
     * @ParamConverter("post")
     * @Security("has_role('ROLE_MODERATOR') and is_granted('CanEditPost', post)")
     *
     * @param Request $request
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Post $post)
    {
        $topic = $post->getTopic();

        if ($topic->getPosts()->first() === $post)
        {
            $em = $this->getEm();
            $em->remove($topic);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('forum.topic.delete'));
            $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('forum.post.deleteall'));
            $redirect = $this->generateUrl('forum_topic', array('slug' => $topic->getForum()->getSlug()));
        } else {
            $em = $this->getEm();
            $em->remove($post);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('forum.post.delete'));
            $redirect = $this->generateUrl('forum_post', array('slug' => $topic->getSlug())); 
        }
        return $this->redirect($redirect);
    }

    /**
     * @Route("post/edit/{id}", name="forum_post_edit")
     * @ParamConverter("post")
     * @Security("is_granted('CanEditPost', post)")
     *
     * @param Request $request
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editAction(Request $request, Post $post)
    {
        $preview = false;

        $form = $this->createForm(PostType::class, $post, array( 
            'preview' => $this->container->getParameter('forum.preview')
        ));

        $form->handleRequest($request);
        
        if (($form->isSubmitted()) && ($form->isValid())) 
        {
            if ( !$preview = $this->getPreview($request, $form, $post) ) {
                $user = $this->get('security.token_storage')->getToken()->getUser();
                $post->setUpdated(new \DateTime());
                $post->setUpdatedBy($user);
                $this->getEm()->flush();
                $request->getSession()->getFlashBag()->add('success', $this->getTranslator()->trans('forum.post.edit'));
                return $this->redirect( $this->generateUrl('forum_post', array('slug' => $post->getTopic()->getSlug())) ); 
            }
        }

        return $this->render('@Forum/Post/edit_post.html.twig', array(
            'form'  => $form->createView(),
            'post'  => $post,
            'topic' => $post->getTopic(),
            'postpreview' => $preview
        ));

    }

    /**
     * @param Topic $topic
     * @return Topic
     */
    private function incrementeView(Topic $topic)
    {
        $topic->addView();
        $em = $this->getEm();
        $em->persist($topic);
        $em->flush();

        return $topic;
    }
}
