<?php
namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ForumBundle\Entity\Model\BaseCategory;

/**
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\CategoryRepository")
 * @ORM\Table(name="df_category")
 */
class Category extends BaseCategory
{

}
