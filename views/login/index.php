<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../public/css/login/style.css">
    <?php include('../../components/globais.php'); ?>
</head>

<body>

    <main>
        <div class="container-cont">
        <div class="container-login">
            <form action="/jm_informatica/index.php?action=login" method="POST">
                <h1>Efetuar Login</h1>
                <?php if (isset($_GET['login_error'])): ?>
                    <div class="mensagem-forms-erro">
                        <?php echo htmlspecialchars($_GET['login_error']); ?>
                    </div>
                <?php endif; ?>
                <div class="box-inputs">
                    <label for="email">Digite Seu Email:</label>
                    <input type="email" name="email" id="email" placeholder="exemplo@email.com">
                </div>

                <div class="box-inputs">
                    <label for="password">Digite Sua Senha:</label>
                    <input type="password" name="password" id="password" placeholder="••••••••">
                </div>
                <a href="../cadastro/index.php">Cadastre-se!!!</a>
                <button type="submit">Entrar</button>
            </form>
        </div>
        </div>
    </main>
    <?php if (isset($_GET['deslogado'])): ?>
        <div id="mensagem" class="mensagem-sucesso animacao">
            Usuário deslogado com sucesso!
        </div>
    <?php endif; ?>

    <script src="../../public/js/msgAnimacoes.js"></script>

</body>

</html>