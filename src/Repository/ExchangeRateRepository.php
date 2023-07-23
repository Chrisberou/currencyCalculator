<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;

class ExchangeRateRepository
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getExchangeRate(string $baseCurrency, string $targetCurrency): ?array
    {
        $query = 'SELECT * FROM exchange_rate WHERE base_currency = :baseCurrency AND target_currency = :targetCurrency';
        $params = [
            'baseCurrency' => $baseCurrency,
            'targetCurrency' => $targetCurrency,
        ];
        return $this->connection->executeQuery($query, $params)->fetchAssociative();
    }

    public function getAllCombinations(): array
    {
        $query = 'SELECT * FROM exchange_rate';
        return $this->connection->executeQuery($query)->fetchAllAssociative();
    }

    public function addCombination(string $fromCurrency, string $toCurrency, float $rate): array
    {
        $sql = "INSERT INTO exchange_rate (base_currency, target_currency, rate) VALUES (?, ?, ?)";
        $this->connection->executeQuery($sql, [$fromCurrency, $toCurrency, $rate]);

        $id = $this->connection->lastInsertId();

        return [
            'id' => $id,
            'base_currency' => $fromCurrency,
            'target_currency' => $toCurrency,
            'rate' => $rate,
        ];
    }

    public function updateCombination(int $id, string $fromCurrency, string $toCurrency, float $rate): array
    {
        $sql = "UPDATE exchange_rate SET base_currency = ?, target_currency = ?, rate = ? WHERE id = ?";
        $this->connection->executeQuery($sql, [$fromCurrency, $toCurrency, $rate, $id]);

        return ['message' => 'Combination updated successfully.'];
    }

    public function deleteCombination(int $id): array
    {
        $sql = "DELETE FROM exchange_rate WHERE id = ?";
        $this->connection->executeQuery($sql, [$id]);

        return ['message' => 'Combination deleted successfully.'];
    }
}
