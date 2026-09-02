<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /jm_informatica/views/login/index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Serviço</title>
    <link rel="stylesheet" href="../../public/css/servicos/style.css">
    <?php include('../../components/globais.php'); ?>
</head>

<body>

    <main>
        <div class="container-cont">
        <div class="container-cadastro-servico">
            <form id="form-cadastro" action="/jm_informatica/index.php?action=cadastrar_servico" method="post">
                <h1>Cadastrar Novo Serviço</h1>

                <div class="box-inputs">
                    <label for="descricao">Descrição:</label>
                    <input type="text" name="descricao" id="descricao" placeholder="Este produto é um produto...">
                </div>

                <div class="box-inputs">
                    <label for="preco">Preço:</label>
                    <input type="text" name="preco" id="preco" placeholder="R$ 0,00">
                </div>
                <button type="submit">Cadastrar</button>
                <button type="button" onclick="window.location.href='../../index.php?action=dashboard'">Voltar</button>
            </form>
        </div>
        </div>e
    </main>

    <?php if (isset($_GET['is_cadastrado'])): ?>

        <div id="mensagem" class="<?php echo $_GET['is_cadastrado'] === 'true' ? 'mensagem-sucesso' : 'mensagem-erro' ?> animacao">

            <?php if ($_GET['is_cadastrado'] == 'true'): ?>

                Serviço cadastrado com sucesso!

            <?php else: ?>

                <?= htmlspecialchars($_GET['service_error'] ?? 'Erro ao cadastrar serviço!') ?>

            <?php endif; ?>

        </div>

    <?php endif; ?>
   
    <script src="../../public/js/msgAnimacoes.js"></script>
    <script>
        const mensagemCadastro =
    document.getElementById('mensagem');

    if (mensagemCadastro) {
        setTimeout(() => {
            mensagemCadastro.classList.add('ocultar');
        }, 2500);

        setTimeout(() => {
            window.location.href =
                '../../index.php?action=dashboard';
        }, 3000);
    }
    </script>




</body>

</html>