<?php

class Database
{
    private string $host = 'localhost';
    private string $database = 'jm_informatica';
    private string $username = 'root';
    private string $password = '';

    public function getConnection(): PDO
    {
        try {
            $pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $pdo;

        } catch (PDOException $e) {
            die('Erro ao conectar com o banco de dados.');
        }
    }
}