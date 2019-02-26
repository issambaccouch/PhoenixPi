<?php

namespace TestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Cat_ProdControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Create_Cat_Prod');
    }

    public function testUpdate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Update_Cat_Prod');
    }

    public function testRead()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Read_Cat_Prod');
    }

}
