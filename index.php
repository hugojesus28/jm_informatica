<?php


require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/ServiceController.php';

$action = $_GET['action'] ?? 'index';

switch ($action) {

    case 'index':
        header('Location: /jm_informatica/views/login/index.php');

        break;

    case 'login':
        $userController = new UserController();
        $userController->login();

        break;

    case 'cadastro':
        $userController = new UserController();
        $userController->cadastrar();

        break;
    case 'cadastrar_servico':
        $serviceController = new ServiceController();
        $serviceController->cadastrar();

        break;
    case 'update_service':
        $serviceController = new ServiceController();
        $serviceController->update();

        break;

    case 'delete_service':

        $serviceController = new ServiceController();
        $serviceController->delete();

        break;

    case 'toggle_service':

        $serviceController = new ServiceController();
        $serviceController->toggleService();

        break;

    case 'teste':

        $serviceController = new ServiceController();
        $serviceController->toggleService();

        break;

    case 'dashboard':

        $dashboardController = new ServiceController();
        $dashboardController->index();

        break;

    case 'logout':

        $userController = new UserController();
        $userController->logout();

        break;

    default:

        http_response_code(404);
        echo 'Página não encontrada.';
        
        break;
}