<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;

class CurrencyRepository
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getAllCurrencies(): array
    {
        // Fetch all currencies from the database using SQL query
        $query = 'SELECT * FROM currency';
        return $this->connection->executeQuery($query)->fetchAllAssociative();
    }

    public function addCurrency(string $currencyCode, string $currencyName): array
    {
        // Check if the currency already exists in the database based on the code
        $query = 'SELECT * FROM currency WHERE code = :currencyCode';
        $params = ['currencyCode' => $currencyCode];
        $existingCurrency = $this->connection->executeQuery($query, $params)->fetchAssociative();

        if ($existingCurrency) {
            return ['error' => 'Currency with the same code already exists.'];
        }

        // Insert the new currency into the database using raw SQL query
        $sql = "INSERT INTO currency (code, name) VALUES (?, ?)";
        $this->connection->executeQuery($sql, [$currencyCode, $currencyName]);

        $id = $this->connection->lastInsertId();

        return ['id' => $id, 'code' => $currencyCode, 'name' => $currencyName];
    }
}
