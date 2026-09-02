<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPeloEmail(string $email): ?User
    {
        $sql = "SELECT * FROM user WHERE email = :email";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':email' => $email
        ]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->mapUser($data);
    }
    public function buscarId(string $id): ?User
    {
        $sql = "SELECT * FROM user WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $this->mapUser($data);
    }

    public function save(User $user): bool
    {
        $sql = "INSERT INTO user
                (name, email, password, ativo)
                VALUES (:name, :email, :password, :ativo)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':name' => $user->getName(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':ativo' => $user->isAtivo()
        ]);
    }

    private function mapUser(array $data): User
    {
        $user = new User();

        $user->setIdUser((int) $data['id_user']);
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setAtivo((bool) $data['ativo']);

        if ($data['created_at'] !== null) {
            $user->setCreatedAt($data['created_at']);
        }

        if ($data['updated_at'] !== null) {
            $user->setUpdatedAt($data['updated_at']);
        }

        return $user;
    }
}