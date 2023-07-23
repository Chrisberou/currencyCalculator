<?php
// tests/Controller/CurrencyControllerTest.php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;

class CurrencyControllerTest extends WebTestCase
{
    public function testGetCurrencies(): void
    {
        // Create a test client
        $client = static::createClient();
         // Create a new User instance with the provided data
         $user = new User();
         $user->setEmail('testadmin@testadmin.com');
         $user->setPassword('1234');
         $user->setIsLogged(false);
         $user->setIsAdmin(true);
 
         // Simulate authentication by providing the User instance as the authenticated user
         $client->loginUser($user);

        // Make a GET request to the endpoint
        $client->request('GET', '/api/currencies');

        // Get the response
        $response = $client->getResponse();

        // Perform assertions on the response
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);
        // Assuming your getCurrencies method returns an array of currencies
        $this->assertIsArray($data);
        // Add more specific assertions based on the expected data returned by the method
        // For example, check if the array contains currency codes and names.
        $this->assertArrayHasKey('currencyCode', $data[0]);
        $this->assertArrayHasKey('currencyName', $data[0]);
    }

    // Add more tests for other methods in the CurrencyController as needed
}
