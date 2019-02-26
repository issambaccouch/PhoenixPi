<?php

namespace ForumBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    public function testReadcomment()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/readcomment');
    }

}
