<?php

// src/Controller/CurrencyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;
use App\Repository\CurrencyRepository;
use App\Repository\ExchangeRateRepository;

class CurrencyController extends AbstractController
{
    private $currencyRepository;
    private $exchangeRateRepository;

    public function __construct(CurrencyRepository $currencyRepository, ExchangeRateRepository $exchangeRateRepository)
    {
        $this->currencyRepository = $currencyRepository;
        $this->exchangeRateRepository = $exchangeRateRepository;
    }

    #[Route("/api/currencies", methods: ['GET'])]
    public function getCurrencies(): JsonResponse
    {
        $currencies = $this->currencyRepository->getAllCurrencies();
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

        $exchangeRate = $this->exchangeRateRepository->getExchangeRate($baseCurrency, $targetCurrency);

        if (!$exchangeRate) {
            return new JsonResponse(['error' => 'Exchange rate not found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        $convertedAmount = $amount * $exchangeRate['rate'];

        return new JsonResponse(['convertedAmount' => $convertedAmount]);
    }

    #[Route("/api/exchange_rates", methods: ['GET'])]
    public function getCombinations(): JsonResponse
    {
        $combinations = $this->exchangeRateRepository->getAllCombinations();
        return new JsonResponse($combinations);
    }

    #[Route("/api/exchange_rates/add", methods: ['POST'])]
    public function addCombination(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $fromCurrency = $data['baseCurrency'] ?? null;
        $toCurrency = $data['targetCurrency'] ?? null;
        $rate = $data['rate'] ?? null;

        if (!$fromCurrency || !$toCurrency || !$rate) {
            return new JsonResponse(['error' => 'Invalid request data.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $result = $this->exchangeRateRepository->addCombination($fromCurrency, $toCurrency, $rate);

        return new JsonResponse($result);
    }

    #[Route("/api/exchange_rates/{id}", methods: ['PUT'])]
    public function updateCombination(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $fromCurrency = $data['baseCurrency'] ?? null;
        $toCurrency = $data['targetCurrency'] ?? null;
        $rate = $data['rate'] ?? null;

        if (!$fromCurrency || !$toCurrency || !$rate) {
            return new JsonResponse(['error' => 'Invalid request data.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $result = $this->exchangeRateRepository->updateCombination($id, $fromCurrency, $toCurrency, $rate);

        return new JsonResponse($result);
    }

    #[Route("/api/exchange_rates/{id}", methods: ['DELETE'])]
    public function deleteCombination(int $id): JsonResponse
    {
        $result = $this->exchangeRateRepository->deleteCombination($id);

        return new JsonResponse($result);
    }

    #[Route("/api/exchange_rates/add/currency", methods: ['POST'])]
    public function addCurrency(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $currencyCode = $data['currencyCode'] ?? null;
        $currencyName = $data['currencyName'] ?? null;

        if (!$currencyCode || !$currencyName) {
            return new JsonResponse(['error' => 'Invalid request data.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $result = $this->currencyRepository->addCurrency($currencyCode, $currencyName);

        if (isset($result['error'])) {
            return new JsonResponse($result, JsonResponse::HTTP_CONFLICT);
        }

        return new JsonResponse($result, JsonResponse::HTTP_CREATED);
    }
}
