<?php
namespace DAO;
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Service.php';
use Models\Service;
use Database;
use PDO;
use Service as GlobalService;
use User;

class ServiceDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function salvar(GlobalService $servico): bool
    {
        $sql = "INSERT INTO servicos (usuario_id, descricao, valor, data_cadastro) 
                VALUES (:usuario_id, :descricao, :valor, NOW())";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':usuario_id' => $servico->getUserIdUser(),
            ':descricao' => $servico->getDescription(),
            ':valor' => $servico->getPrice()
        ]);
    }

    public function finalizar(GlobalService $servico): bool
    {
        $sql = "UPDATE servicos SET data_finalizacao = NOW(), comissao = :comissao WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':comissao' => $servico->getCommissionUser(),
            ':id' => $servico->getIdService()
        ]);
    }

    public function buscarPorId(int $id): ?GlobalService
    {
        $stmt = $this->pdo->prepare("
       SELECT
            service.*,
            user.id_user AS user_id,
            user.name AS user_name,
            user.email AS user_email,
            user.password AS user_password,
            user.ativo AS user_ativo
        FROM service
        INNER JOIN user
            ON service.user_id_user = user.id_user
        WHERE service.id_service = :id");

        $stmt->execute([':id' => $id]);
        $dados = $stmt->fetch();

        if (!$dados)
            return null;

        
        $servico = new GlobalService($dados['id_service'], $dados['user_id_user'], $dados['description'], (float) $dados['price']);
        $user = new User();
            $user->setIdUser($dados['user_id']);
            $user->setName($dados['user_name']);
            $user->setEmail($dados['user_email']);
            $user->setPassword($dados['user_password']);
            $user->setAtivo((bool) $dados['user_ativo']);

        if ($dados['finished_at']) {
            $servico->setFinishedAt($dados['finished_at']);
            $servico->setPrice($dados['price']);
            $servico->setCommissionUser(
                $dados['commission_user'] !== null
                ? (float) $dados['commission_user']
                : null
            );
        }
        $servico->setUser($user);

        return $servico;
    }

    public function verTotalValorServicos(): float
    {

        $sql = "SELECT SUM(price) as total FROM service";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetch();
        return (float) $resultado['total'] ?? 0.0;

    }
    public function verServicosPendentes(int $userId, int $limit = 5): array
    {
        $sql = "SELECT * 
                FROM service 
                WHERE finished_at IS NULL 
                ORDER BY created_at DESC 
                LIMIT :limit";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $services = [];

        foreach ($rows as $row) {
            $service = new GlobalService(
                (int) $row['id_service'],
                (int) $row['user_id_user'],
                $row['description'],
                (float) $row['price']
            );
            $service->setCreatedAt($row['created_at']);
            $service->setUpdatedAt($row['updated_at']);
            $service->setFinishedAt($row['finished_at']);
            $service->setCommissionUser($row['commission_user'] !== null ? (float) $row['commission_user'] : null);

            $services[] = $service;
        }

        return $services;
    }

    public function atualizar(GlobalService $service): bool
    {
        // função de atualizar serviço do banco, atualiza descrição e valor
        $sql = "UPDATE service
            SET description = :description,
                price = :price,
                updated_at = NOW()
            WHERE id_service = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':description' => $service->getDescription(),
            ':price' => $service->getPrice(),
            ':id' => $service->getIdService()
        ]);
    }
    public function delete(int $idService, int $userId): bool
    {
        // função de deletar serviço do banco, qualquer usuário logado pode deletar um serviço
        $sql = "DELETE FROM service
            WHERE id_service = :id_service";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id_service' => $idService,
        ]);
    }
    public function cadastrar(GlobalService $service): bool
    {
        $sql = "INSERT INTO service
            (description, price, user_id_user)
            VALUES
            (:description, :price, :user_id_user)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':description' => $service->getDescription(),
            ':price' => $service->getPrice(),
            ':user_id_user' => $service->getUserIdUser()
        ]);
    }
    public function alterarStatus(GlobalService $service, int $userId): bool
    {
        // função de toggler status do banco, se pendente vai pra finalizado, se finalizado vai pra pendente
        $sql = "UPDATE service
            SET finished_at = :finished_at,
                commission_user = :commission_user,
                updated_at = NOW()
            WHERE id_service = :id_service";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':finished_at' => $service->getFinishedAt(),
            ':commission_user' => $service->getCommissionUser(),
            ':id_service' => $service->getIdService()
        ]);

    }
    public function listarTodos(
        int $userId,
        string $description = '',
        string $dateStart = '',
        string $dateEnd = '',
        string $user = '',
        string $status = ''
    ): array {

        $sql = "SELECT service.*, user.name as user_name
        FROM service
        INNER JOIN user
            ON service.user_id_user = user.id_user
        WHERE 1 = 1";

        $params = [

        ];
        // adicionando filtros 
        if (!empty($description)) {
            $sql .= " AND service.description LIKE :description";
            $params[':description'] = '%' . $description . '%';
        }

        if (!empty($dateStart)) {
            $sql .= " AND DATE(service.created_at) >= :date_start";
            $params[':date_start'] = $dateStart;
        }

        if (!empty($dateEnd)) {
            $sql .= " AND DATE(service.created_at) <= :date_end";
            $params[':date_end'] = $dateEnd;
        }

        if (!empty($user)) {
            $sql .= " AND user.name LIKE :user";
            $params[':user'] = '%' . $user . '%';
        }
        if ($status === 'pendente') {
            $sql .= " AND service.finished_at IS NULL";
        }

        if ($status === 'finalizado') {
            $sql .= " AND service.finished_at IS NOT NULL";
        }


        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $servicos = [];
        // aqui fiz um while para verificar os dados do banco e armazenar em dados pra retornar pra o controller
        while ($dados = $stmt->fetch()) {

            $servico = new GlobalService(
                $dados['id_service'],
                $dados['user_id_user'],
                $dados['description'],
                (float) $dados['price'],
            );
            $servico->setUserName($dados['user_name']);

            if ($dados['finished_at']) {
                $servico->setFinishedAt($dados['finished_at']);
                $servico->setCommissionUser(
                    (float) $dados['commission_user']
                );
            }

            $servicos[] = $servico;
        }

        return $servicos;
    }
}