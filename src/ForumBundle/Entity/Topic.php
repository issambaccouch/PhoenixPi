<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ForumBundle\Entity\Model\BaseTopic;

/**
 *
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\TopicRepository")
 * @ORM\Table(name="df_topic")
 * 
 */
class Topic extends BaseTopic
{

}
