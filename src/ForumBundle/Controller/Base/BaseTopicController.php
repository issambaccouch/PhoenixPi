<?php

namespace ForumBundle\Controller\Base;

use ForumBundle\Entity\Forum;
use ForumBundle\Form\Type\TopicType;
use ForumBundle\Entity\Topic;
use ForumBundle\Entity\Post;


class BaseTopicController extends BaseController
{
    /**
     * @var object $post ForumBundle\Controller\Entity\Topic
     */
    protected $topic;

    /**
     *
     * @param Forum $forum
     * @return null|\Symfony\Component\Form\FormInterface
     */
    protected function generateTopicForm(Forum $forum) {
        
        if ($this->getAuthorization()->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->get('security.token_storage')->getToken()->getUser();       
            $this->topic = new Topic();
            $this->topic->setForum($forum);
            $this->topic->setUser( $user );
            return $this->createForm(TopicType::class, $this->topic);
        }
        
        return NULL;
    }

    /**
     * @param $content
     * @param Topic $topic
     * @return Post
     */
    protected function createPost($content, Topic $topic) {
        $post = new post();
        $post->setContent($content);
        $post->setTopic($topic);
        $post->setPoster($topic->getUser());
        return $post;
    }
    
}
