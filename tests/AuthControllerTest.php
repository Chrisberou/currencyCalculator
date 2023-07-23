<?php
// tests/Controller/AuthControllerTest.php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthControllerTest extends WebTestCase
{
    public function testGetIsAdmin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/get_is_admin');

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        // Your assertions based on $data
        // For example, check if the response contains the expected data
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertArrayHasKey('isAdmin', $data);
    }
}

