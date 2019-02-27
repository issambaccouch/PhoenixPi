<?php

namespace ForumBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use ForumBundle\DependencyInjection\ForumExtension;


class ForumBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new ForumExtension();
    }
}
