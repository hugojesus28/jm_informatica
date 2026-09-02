

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../../public/css/login/style.css">
    <?php include('../../components/globais.php');?>
</head>

<body>

    <main>
        <div class="container-cont">
        <div class="container-login">

            <form action="/jm_informatica/index.php?action=cadastro" method="POST" id="form">

                <h1>Efetuar Cadastro</h1>

               <?php if (isset($_GET['cadastro_error'])): ?>
                    <div class="mensagem-forms-erro">
                        <?php echo htmlspecialchars($_GET['cadastro_error']); ?>
                    </div>
                <?php endif; ?>

                <div class="box-inputs">
                    <label for="email">Digite Seu Email:</label>
                    <input type="email" name="email" id="email" placeholder="exemplo@email.com">
                </div>

                <div class="box-inputs">
                    <label for="name">Digite Seu Nome:</label>
                    <input type="text" name="name" id="name" placeholder="Seu nome" minlength="3" maxlength="100">
                </div>

                <div class="box-inputs">
                    <label for="password">Digite Sua Senha:</label>
                    <input type="password" name="password" id="password" placeholder="••••••••">
                </div>

                <div class="box-inputs">
                    <label for="confirm_password">Confirme sua Senha:</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••">
                </div>

                <a href="../login/index.php">
                    Já tem uma conta? Faça login!
                </a>

                <button type="submit">Cadastrar</button>

            </form>

        </div>
        </div>
    </main>

</body>

</html>