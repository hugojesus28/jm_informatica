    <?php

    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../dao/UserDAO.php';

    class UserController
    {
        private User $user;
        private UserDAO $userDAO;
        
        public function __construct()
        {
            $this->user = new User();

            $pdo = (new Database())->getConnection();
            $this->userDAO = new UserDAO($pdo);
        }

            public function login(): void
            {
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';

               
                /* validando campos vazios */
                if (empty($email) || empty($password)) {
                    $this->showError('login_error', 'Ops, email e senha são obrigatórios!!!', '/jm_informatica/views/login/index.php');
                    return;
                }
                
                $user = $this->userDAO->buscarPeloEmail($email);
                 
                if (!$user || $password !== $user->getPassword()) {
                    $this->showError('login_error', 'Ops, email ou senha incorretos!!!', '/jm_informatica/views/login/index.php');
                    return;
                }
                
                /* chamando a sessão para criar as sessão do usuario */
                session_start();

                $_SESSION['user_id'] = $user->getIdUser();
                $_SESSION['user_name'] = $user->getName();
                $_SESSION['user_email'] = $user->getEmail();


                header('Location: /jm_informatica/index.php?action=dashboard');
                exit;
            }

        public function cadastrar(): void
        {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            /* validações */
            if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
                $this->showError('cadastro_error', 'Todos os campos são obrigatórios.', '/jm_informatica/views/cadastro/index.php');
                return;
            }

            if ($password !== $confirmPassword) {
                $this->showError('cadastro_error', 'As senhas não coincidem.', '/jm_informatica/views/cadastro/index.php');
                return;
            }

            if ($this->userDAO->buscarPeloEmail($email)) {
                $this->showError('cadastro_error', 'Este email já está em uso.', '/jm_informatica/views/cadastro/index.php');
                return;
            }

            /* criando o usuário */
            $this->user->setName($name);
            $this->user->setEmail($email);
            $this->user->setPassword($password);
            $this->user->setAtivo(true);

            if ($this->userDAO->save($this->user)) {
                header('Location: ./views/login/index.php');
                exit;
            }

            $this->showError('cadastro_error', 'Erro ao registrar usuário. Tente novamente.', '/jm_informatica/views/cadastro/index.php');
        }

        public function logout(): void
        {
            session_start();

            session_unset();
            session_destroy();

            header('Location: ./views/login/index.php?deslogado=true');
            exit;
        }

        
        /* função direcionada a exibir erros para o usuário */
        private function showError(string $parametro_msg, string $mensagem, string $url): void
        {
            header("Location: $url?{$parametro_msg}=" . urlencode($mensagem));
            exit;
        }

      
    }