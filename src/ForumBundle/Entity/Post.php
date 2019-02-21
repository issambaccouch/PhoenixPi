<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ForumBundle\Entity\Model\BasePost;

/**
 * 
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\PostRepository")
 * @ORM\Table(name="df_post")
 * 
 */
class Post extends BasePost
{


    /**
     * Get topic
     *
     * @return \ForumBundle\Entity\Topic
     */
    public function getTopic()
    {
        return $this->topic;
    }
}
