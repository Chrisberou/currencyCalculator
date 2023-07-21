<?php

// src/Controller/CurrencyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;


class CurrencyController extends AbstractController
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    #[Route("/api/currencies", methods: ['GET'])]
    public function getCurrencies(): JsonResponse
    {
        // Fetch all currencies from the database using SQL query
        $query = 'SELECT * FROM currency';
        $currencies = $this->connection->executeQuery($query)->fetchAllAssociative();

        // Return the currencies as a JSON response
        return new JsonResponse($currencies);
    }

    #[Route("/api/convert", methods: ['POST'])]
    public function convertCurrency(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $baseCurrency = $data['baseCurrency'] ?? null;
        $targetCurrency = $data['targetCurrency'] ?? null;
        $amount = $data['amount'] ?? null;

        if (empty($baseCurrency) || empty($targetCurrency) || !is_numeric($amount) || $amount <= 0) {
            return new JsonResponse(['error' => 'Invalid request data.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Retrieve the exchange rate from the database using SQL query based on baseCurrency and targetCurrency
        $query = 'SELECT * FROM exchange_rate WHERE base_currency = :baseCurrency AND target_currency = :targetCurrency';
        $params = [
            'baseCurrency' => $baseCurrency,
            'targetCurrency' => $targetCurrency,
        ];
        $exchangeRate = $this->connection->executeQuery($query, $params)->fetchAssociative();

        if (!$exchangeRate) {
            return new JsonResponse(['error' => 'Exchange rate not found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Calculate the converted amount
        $convertedAmount = $amount * $exchangeRate['rate'];

        return new JsonResponse(['convertedAmount' => $convertedAmount]);
    }

    // Other methods in the controller...
}


