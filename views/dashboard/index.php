<?php

if (!isset($_SESSION['user_id'])|| $userId === '') {
    header('Location: views/login/index.php');
    exit;
}

$userName = $_SESSION['user_name'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="public/css/dashboard/style.css">
    <link rel="stylesheet" href="public/css/components/modais.css">
    <link rel="stylesheet" href="public/css/global.css">

</head>

<body>

    <main>
        <aside>
            <div class="perfil">
                <h1>Logado Como: <br> <hr> <span> <?php echo $userName; ?> </span></h1>
            </div>

            <div class="navegacao">
                <ul>
                    <li><a href="views/servicos/index.php">Cadastrar Serviço</a></li>
                </ul>
            </div>

            <div class="logoff">
                <button onclick="window.location.href='/jm_informatica/index.php?action=logout'">
                    Deslogar-se
                </button>
            </div>
        </aside>
        <div class="container-column">
            <div class="container-resumo-servicos">
                <h1>Dashboard</h1>
                <div class="container-row">
                    <div class="ultimos-servicos">
                        <h2>Valor total</h2>
                        <div class="servico">
                            <span>R$ <?php echo number_format($totalValue ?? 0, 2, ',', '.'); ?></span>
                        </div>
                    </div>
                    <div class="servicos-pendentes">
                        <h2>Serviços Pendentes</h2>
                        <ul>
                        <?php if (empty($pendingServices)): ?>
                            <li style="color: var(--text-sem-destaque); text-align: center;">Nenhum serviço pendente.</li>
                        <?php else: ?>
                            <?php foreach ($pendingServices as $service): ?>
                                <li>
                                    <span>#<?php echo $service->getIdService(); ?> </span> -
                                    <?php echo htmlspecialchars($service->getDescription()); ?>
                                    <span class="valor">(R$ <?php echo number_format($service->getPrice(), 2, ',', '.'); ?>)</span>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="form-filtros">
                <form method="GET" class="form-filtros"  action="/jm_informatica/index.php">
                     
                    <input type="hidden" name="action" value="dashboard">

                    <input type="text" name="description" class="input-filtro" placeholder="Filtrar por descrição..."
                        value="<?php echo htmlspecialchars($_GET['description'] ?? ''); ?>">

                    <input type="date" name="date_start" class="input-filtro"
                        value="<?php echo htmlspecialchars($_GET['date_start'] ?? ''); ?>">

                    <input type="date" name="date_end" class="input-filtro"
                        value="<?php echo htmlspecialchars($_GET['date_end'] ?? ''); ?>">

                    <input type="text" name="user" class="input-filtro" placeholder="Filtrar por usuário..."
                        value="<?php echo htmlspecialchars($_GET['user'] ?? ''); ?>">
                     <select name="status" class="input-filtro">
                        <option value="">Todos os status</option>

                        <option
                            value="pendente"
                            <?php echo (($_GET['status'] ?? '') === 'pendente') ? 'selected' : ''; ?>>
                            Pendente
                        </option>

                        <option
                            value="finalizado"
                            <?php echo (($_GET['status'] ?? '') === 'finalizado') ? 'selected' : ''; ?>
                        >
                            Finalizado
                        </option>
                    </select>
                    <button type="submit" class="btn-filtro" >
                        Filtrar
                    </button>

                </form>
            </div>

            <table class="tabela-servicos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Status</th>
                        <th>Valor</th>
                        <th>Usuário</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($services)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-sem-destaque); font-size: 20px; font-weight: bold;">Nenhum serviço encontrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td>
                                    <?php echo $service->getIdService(); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($service->getDescription()); ?>
                                </td>
                                <td>
                                    <?php echo $service->getFinishedAt() ? 'Concluído' : 'Pendente'; ?>
                            </td>
                                <td>R$ <?php echo number_format($service->getPrice(), 2, ',', '.'); ?> 
                                <span style="color: var(--money-destaque); font-size: 12px; font-weight: bold;">
                                    R$ <?php echo number_format($service->getCommissionUser(), 2, ',', '.'); ?>
                                </span> 
                            </td>
                                <td>
                                    <?php echo htmlspecialchars($service->getUserName()); ?>
                            </td>
                                <td class="coluna-acoes">
 <button type="button" class="btn-acoes" onclick="abrirModalAlterar(
                                            <?php echo $service->getIdService(); ?>,
                                            '<?php echo htmlspecialchars($service->getDescription(), ENT_QUOTES); ?>',
                                            '<?php echo $service->getPrice(); ?>'
                                        )">
                                       <img src="public/assets/pen.png" alt="">
                                    </button>
                                     <button type="button" class="btn-acoes"
                                        onclick="abrirModalExcluir(<?php echo $service->getIdService(); ?>)"
                                        style="background-color: red">
                                        <img src="public/assets/remove.png" alt="">
                                    </button>
                                     <button type="button" class="btn-acoes"
                                        onclick="abrirModalStatus(<?php echo $service->getIdService(); ?>, <?php echo $service->getFinishedAt() ? 'true' : 'false'; ?>)"
                                        style="<?php echo $service->getFinishedAt() ? "background-color: var(--amarelo);" :  "background-color: var(--verde);"; ?>"
                                        >
                                        <?php echo $service->getFinishedAt() ?                                        
                                        '<img src="/jm_informatica/public/assets/undo.png" alt="Editar">' :
                                        '<img src="/jm_informatica/public/assets/check.png" alt="Editar">'; ?>
                                    </button>
                                </td>
                                
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Componentes e funções JS -->
    <?php include_once 'components/modalAlterar.php'; ?>
    <?php include_once 'components/modalExcluir.php'; ?>
    <?php include_once 'components/modalStatus.php'; ?>
    <script src="public/js/modalAlterar.js"></script>
    <script src="public/js/modalExcluir.js"></script>
    <script src="public/js/modalStatus.js"></script>

</body>

</html>