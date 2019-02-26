<?php

namespace TestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FollowersControllerTest extends WebTestCase
{
    public function testListefor()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listefor');
    }

    public function testListews()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listews');
    }

}
