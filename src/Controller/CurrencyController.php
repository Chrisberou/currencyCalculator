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

    #[Route("/api/exchange_rates", methods: ['GET'])]
    public function getCombinations(): JsonResponse
    {
        // Fetch all currency combinations from the database using SQL query
        $query = 'SELECT * FROM exchange_rate';
        $combinations = $this->connection->executeQuery($query)->fetchAllAssociative();

        // Return the currency combinations as a JSON response
        return new JsonResponse($combinations);
    }
    #[Route("/api/exchange_rates/add", methods: ['POST'])]
    public function addCombination(Request $request): JsonResponse
    {
        // Get data from the request
        $data = json_decode($request->getContent(), true);
        $fromCurrency = $data['baseCurrency'] ?? null;
        $toCurrency = $data['targetCurrency'] ?? null;
        $rate = $data['rate'] ?? null;

        // Validate the data
        if (!$fromCurrency || !$toCurrency || !$rate) {
            return new JsonResponse(['error' => 'Invalid request data.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Insert the new combination into the database using raw SQL query
        $sql = "INSERT INTO exchange_rate (base_currency, target_currency, rate) VALUES (?, ?, ?)";
        $this->connection->executeQuery($sql, [$fromCurrency, $toCurrency, $rate]);
        
        $id = $this->connection->lastInsertId();

        $combination = [
            'id' => $id,
            'base_currency' => $fromCurrency,
            'target_currency' => $toCurrency,
            'rate' => $rate,
        ];
        // Return success response
        return new JsonResponse( $combination);
    }

    
    #[Route("/api/exchange_rates/{id}", methods: ['PUT'])]
    public function updateCombination(Request $request, int $id): JsonResponse
    {
        // Get the combination ID from the request
        $data = json_decode($request->getContent(), true);
        $fromCurrency = $data['baseCurrency'] ?? null;
        $toCurrency = $data['targetCurrency'] ?? null;
        $rate = $data['rate'] ?? null;

        // Validate the data
        if (!$fromCurrency || !$toCurrency || !$rate) {
            return new JsonResponse(['error' => 'Invalid request data.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Update the combination in the database using raw SQL query
        $sql = "UPDATE exchange_rate SET base_currency = ?, target_currency = ?, rate = ? WHERE id = ?";
        $this->connection->executeQuery($sql, [$fromCurrency, $toCurrency, $rate, $id]);

        // Return success response
        return new JsonResponse(['message' => 'Combination updated successfully.']);
    }

   
    #[Route("/api/exchange_rates/{id}", methods: ['DELETE'])]
    public function deleteCombination(int $id): JsonResponse
    {
        // Delete the combination from the database using raw SQL query
        $sql = "DELETE FROM exchange_rate WHERE id = ?";
        $this->connection->executeQuery($sql, [$id]);

        // Return success response
        return new JsonResponse(['message' => 'Combination deleted successfully.']);
    }
    #[Route("/api/exchange_rates/add/currency", methods: ['POST'])]
public function addCurrency(Request $request): JsonResponse
{
    // Get the currency code and name from the request
    $data = json_decode($request->getContent(), true);
    $currencyCode = $data['currencyCode'] ?? null;
    $currencyName = $data['currencyName'] ?? null;

    // Validate the data
    if (!$currencyCode || !$currencyName) {
        return new JsonResponse(['error' => 'Invalid request data.'], JsonResponse::HTTP_BAD_REQUEST);
    }

    // Check if the currency already exists in the database based on the code
    $query = 'SELECT * FROM currency WHERE code = :currencyCode';
    $params = ['currencyCode' => $currencyCode];
    $existingCurrency = $this->connection->executeQuery($query, $params)->fetchAssociative();

    if ($existingCurrency) {
        return new JsonResponse(['error' => 'Currency with the same code already exists.'], JsonResponse::HTTP_CONFLICT);
    }

    // Insert the new currency into the database using raw SQL query
    $sql = "INSERT INTO currency (code, name) VALUES (?, ?)";
    $this->connection->executeQuery($sql, [$currencyCode, $currencyName]);

    $id = $this->connection->lastInsertId();

    $currency = ['id' => $id, 'code' => $currencyCode, 'name' => $currencyName];

    // Return success response
    return new JsonResponse($currency, JsonResponse::HTTP_CREATED);
}
}


