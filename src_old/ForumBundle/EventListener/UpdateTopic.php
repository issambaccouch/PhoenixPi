<?php

namespace ForumBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use ForumBundle\Entity\Post;


class UpdateTopic
{
    /**
     * infos: Update LastPost on postPersist
     *
     * @param class Doctrine\ORM\Event\LifecycleEventArgs $args
     * @return sql  topic.last_post
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Post) {
            return;
        }

        $em = $args->getEntityManager();
        $topic = $em->getRepository('ForumBundle:Topic')->find($entity->getTopic());
        $topic->setLastPost($entity->getDate());
        $em->flush();

    }

    /**
     * infos: Update LastPost on postRemove
     *
     * @param class Doctrine\ORM\Event\LifecycleEventArgs $args
     * @return sql  topic.last_post
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Post) {
            return;
        }

        $em = $args->getEntityManager();
        $topic = $em->getRepository('ForumBundle:Topic')->find($entity->getTopic());
        $post = $topic->getPosts()->last();
        
        // if drop a unique post or first post in topic remove topic
        if ($post === null) {
            $em->remove($topic);
        } else {
            $topic->setLastPost($post->getDate());
        }
        $em->flush();
    }
}
