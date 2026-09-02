<?php

use DAO\ServiceDAO;
require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../dao/ServiceDAO.php';

require_once __DIR__ . '/../services/emailService.php';

class ServiceController
{
    private ServiceDAO $serviceDAO;

    private EmailService $emailService;

    public function __construct()
    {
        /* Aqui estou chamando a conexão com o banco e passando para o DAO */
        $pdo = (new Database())->getConnection();
        $this->emailService = new EmailService();
        $this->serviceDAO = new ServiceDAO($pdo);
    }

    /* Essa função exibe o dashboard com os serviços do usuário */
    public function index(): void
    {
        session_start();

       

        $userId = (int) $_SESSION['user_id'];
        $userName = $_SESSION['user_name'];
        $description = $_GET['description'] ?? '';
        $dateStart = $_GET['date_start'] ?? '';
        $dateEnd = $_GET['date_end'] ?? '';
        $user = $_GET['user'] ?? '';
        $status = $_GET['status'] ?? '';

        // Chamo a função de listar todos, passando filtros e os gets coletados no formulário
        $services = $this->serviceDAO->listarTodos(
            $userId,
            $description,
            $dateStart,
            $dateEnd,
            $user,
            $status
        );

        /* Aqui estou chamando a função de ver SUM de serviços */
        $totalValue = $this->serviceDAO->verTotalValorServicos();

        /*Aqui estou chamando um SELECT de ver Serviços Pendentes */
        $pendingServices = $this->serviceDAO->verServicosPendentes($userId, 5);

        /* Aqui estou chamando um require_once que irá exibir os dados na tela */
        require_once '../jm_informatica/views/dashboard/index.php';
    }

    public function cadastrar(): void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            $this->exibirMsg(
                'Usuário não existente!!!',
                '/jm_informatica/views/login/index.php'
            );
        }

        $description = trim($_POST['descricao'] ?? '');
        $price = $_POST['preco'] ?? '';

        // aqui estou validadno os campos obrigatórios
        if ($description === '' || $price === '') {
            $this->exibirMsg(
                'Os campos de preço e descrição são obrigatórios!!!',
                '/jm_informatica/views/servicos/index.php'
            );
        }

        // aqui estou validando a descrição
        if (mb_strlen($description) > 45) {
            $this->exibirMsg(
                'O campo de descrição não pode ser maior que 45 caracteres!!!',
                '/jm_informatica/views/servicos/index.php'
            );
        }

        // aqui estou validando o preço
        if (!is_numeric($price)) {
            $this->exibirMsg(
                'O preço deve ser um número decimal!!!',
                '/jm_informatica/views/servicos/index.php'
            );
        }

        $price = (float) $price;

        // validando se o preço é maior que zero
        if ($price <= 0) {
            $this->exibirMsg(
                'O preço deve ser maior que zero!!!',
                '/jm_informatica/views/servicos/index.php'
            );
        }

        // validando se é maior que o limite do banco de dados
        if ($price > 99999999.999) {
            $this->exibirMsg(
                'O preço informado é muito grande!!!',
                '/jm_informatica/views/servicos/index.php'
            );
        }

        $service = new Service(
            null,
            (int) $_SESSION['user_id'],
            $description,
            $price
        );

        $this->serviceDAO->cadastrar($service);

        header(
            'Location: /jm_informatica/views/servicos/index.php?is_cadastrado=true'
        );
        exit;
    }

    public function update(): void
    {
        
        $id = (int) $_POST['id_service'];
        $description = trim($_POST['description']);
        $price = (float) $_POST['price'];

         // aqui estou validadno os campos obrigatórios
        if ($description === '' || $price === '') {
            $this->exibirMsg(
                'Os campos de preço e descrição são obrigatórios!!!',
                '/jm_informatica/views/servicos/index.php'
            );
        }

        // aqui estou validando a descrição
        else if (mb_strlen($description) > 45) {
            $this->exibirMsg(
                'O campo de descrição não pode ser maior que 45 caracteres!!!',
                '/jm_informatica/views/servicos/index.php'
            );
        }

        // aqui estou validando o preço
        if (!is_numeric($price)) {
            $this->exibirMsg(
                'O preço deve ser um número decimal!!!',
                '/jm_informatica/views/servicos/index.php'
            );
        }

        $price = (float) $price;

        // validando se o preço é maior que zero
         if ($price <= 0) {
            $this->exibirMsg(
                'O preço deve ser maior que zero!!!',
                '/jm_informatica/views/servicos/index.php'
            );
        }

        // validando se é maior que o limite do banco de dados
        else if ($price > 99999999.999) {
            $this->exibirMsg(
                'O preço informado é muito grande!!!',
                '/jm_informatica/views/servicos/index.php'
            );
        }

        $service = $this->serviceDAO->buscarPorId($id);

        if ($service === null) {
            die('Serviço não encontrado.');
        }

        $service->setDescription($description);
        $service->setPrice($price);

        $this->serviceDAO->atualizar($service);


    }
    public function delete(): void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            exit;
        }

        $id = (int) $_POST['id_service'];

        $userId = (int) $_SESSION['user_id'];

        $deleted = $this->serviceDAO->delete($id, $userId);

        if (!$deleted) {
            http_response_code(404);
            exit;
        }

        http_response_code(200);
    }
    public function toggleService(): void
    {
        session_start();
        // validações
        if (!isset($_SESSION['user_id'])) {
            throw new Exception('Usuário não está autenticado.');
        }

        if (!isset($_POST['id_service'])) {
            throw new Exception('ID do serviço não foi informado.');
        }

        $idService = (int) $_POST['id_service'];
        $userId = (int) $_SESSION['user_id'];

        $service = $this->serviceDAO->buscarPorId($idService);

        if ($service === null) {
            throw new Exception('Serviço não encontrado.');
        }


        if ($service->getFinishedAt() === null) {

            $service->setFinishedAt(date('Y-m-d H:i:s'));

            $price = $service->getPrice();

            if ($price <= 1000) {
                $commission = $price * 0.05;
            } elseif ($price <= 10000) {
                $commission = $price * 0.10;
            } else {
                $commission = $price * 0.20;
            }

            $service->setCommissionUser($commission);

            // Envia o e-mail
        if ($service->getUser() !== null) {
            $this->emailService->enviarServicoFinalizado(
                $service->getUser(),
                $service
            );
        }
        } else {

            $service->setFinishedAt(null);
            $service->setCommissionUser(null);
        }
        $this->serviceDAO->alterarStatus($service, $userId);

       
    }


    
    private function exibirMsg(
        string $mensagem,
        string $local
    ): void {

        header(
            "Location: $local?is_cadastrado=false&service_error="
            . urlencode($mensagem)
        );

        exit;
    }
}