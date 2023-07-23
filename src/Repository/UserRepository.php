<?php
// src/Repository/UserRepository.php

namespace App\Repository;

use Doctrine\DBAL\Connection;
use App\Entity\User;

class UserRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    // Add the method to fetch user by email and password
    public function findByEmailAndPassword(string $email, string $password): ?User
    {
        // Your logic to fetch user from the database by email and password
        // This method should return a User object if found, or null otherwise.
        $query = 'SELECT * FROM users WHERE email = :email AND password = :password';
        $user = $this->connection->executeQuery($query, ['email' => $email, 'password' => $password])->fetchAssociative();

        if ($user) {
            // Create a new User instance and set its properties
            $userEntity = new User();
            $userEntity->setEmail($user['email']);
            $userEntity->setPassword($user['password']);
            $userEntity->setIsLogged(true);
            $userEntity->setIsAdmin($user['admin']);

            return $userEntity;
        }

        return null;
    }
}
