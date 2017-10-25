<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StartControllerTest extends WebTestCase
{
    public function testStart()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/start');
    }

}
