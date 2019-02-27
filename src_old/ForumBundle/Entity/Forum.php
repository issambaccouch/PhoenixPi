<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ForumBundle\Entity\Model\BaseForum;

/**
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\ForumRepository")
 * @ORM\Table(name="df_forum")
 */
class Forum extends BaseForum
{


    /**
     * Get category
     *
     * @return \ForumBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
