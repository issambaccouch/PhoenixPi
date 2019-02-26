<?php

namespace ForumBundle\Controller;

use ForumBundle\Controller\Base\BaseController;
use ForumBundle\Entity\Category;
use ForumBundle\Entity\Forum;
use ForumBundle\Entity\Post;
use ForumBundle\Entity\Topic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class AdminController extends BaseController
{

    /**
     * @Route("/admin", name="forum_admin_dashboard")
     * @Security("is_granted('ROLE_MODERATOR')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getEm();
        $posts = $em->getRepository(Post::class)->findBy(array(), array('date' => 'desc'));
        $topics = $em->getRepository(Topic::class)->findBy(array(), array('date' => 'desc'));
        if ($this->getAuthorization()->isGranted('ROLE_ADMIN')) {
            $forums = $em->getRepository(Forum::class)->findAll();
            $categories = $em->getRepository(Category::class)->findBy(array(), array('position' => 'desc', ));
        } else {
            $forums = NULL;
            $categories = NULL;
        }
        return $this->render('@Forum/Moderator/index.moderator.html.twig', array(
            'posts' => $posts,
            'topics' => $topics,
            'forums' => $forums,
            'categories' => $categories
        ));
    }
}
