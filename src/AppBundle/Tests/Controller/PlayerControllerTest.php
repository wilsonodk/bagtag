<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/players');
    }

    public function testCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/player/add');
    }

    public function testInfo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/player/:id');
    }

}
