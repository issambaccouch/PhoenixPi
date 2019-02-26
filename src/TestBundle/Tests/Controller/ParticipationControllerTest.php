<?php

namespace TestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ParticipationControllerTest extends WebTestCase
{
    public function testParticipate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/participate');
    }

}
