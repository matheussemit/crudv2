<?php
    class Users extends Controller{
        public function __construct(){
            $this->userModel = $this->model('User');
        }

        public function index(){
            if(!isLoggedIn()){
                redirect('users/login');
            }

            $users = $this->userModel->getUsers();
    
            $data = [
                'users' => $users
            ];
    
            $this->view('users/index', $data);
        }

        public function show($id){
            if(!isLoggedIn()){
                redirect('users/login');
            }

            $user = $this->userModel->getUserById($id);
    
            $data = [
                'user' => $user
            ];
    
            $this->view('users/show', $data);
        }

        public function register(){
            if(!isLoggedIn()){
                redirect('users/login');
            }
            // verifica se é pra processar ou carregar o form
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                // carrega os dados
                $data = [
                    'nome' => trim($_POST['nome']),
                    'sobrenome' => trim($_POST['sobrenome']),
                    'usuario' => trim($_POST['usuario']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                ];

                // validação dos dados
                if(empty($data['usuario'])){
                    $data['usuario_err'] = 'Preencha seu nome de usuário';
                } else {
                    // verifica se já tem email cadastrado
                    if($this->userModel->findUserByLogin($data['usuario'])){
                        $data['usuario_err'] = 'Usuário já cadastrado';
                    }
                }

                if(empty($data['password'])){
                    $data['password_err'] = 'Preencha sua senha';
                } elseif(strlen($data['password']) < 6){
                    $data['password_err'] = 'A senha deve conter pelo menos 6 caracteres';
                }
                
                if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = 'Confirme sua senha';
                } else {
                    if($data['password'] != $data['confirm_password']){
                        $data['confirm_password_err'] = 'As senhas são diferentes';
                    }
                }

                // confirma que não teve erros
                if(empty($data['nome']) && empty($data['sobrenome']) && empty($data['usuario']) && empty($data['password']) && empty($data['confirm_password']) ){
                    $this->view('users/register', $data);
                }

                // registra o usuário
                if($this->userModel->register($data)){
                    flash('update_success', 'Cadastro efetuado');
                    redirect('users');
                } else {
                    $this->view('users/register', $data);
                    // die('Algo deu errado');
                }

            } else {
                $data = [
                    'nome' => '',
                    'sobrenome' => '',
                    'usuario' => '',
                    'password' => '',
                    'confirm_password' => '',
                ];

                // carrega view
                $this->view('users/register', $data);
            }
        }

        public function login(){
            // verifica se é pra processar ou carregar o form
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                // carrega os dados
                $data = [
                    'usuario' => trim($_POST['usuario']),
                    'password' => trim($_POST['password']),
                    'usuario_err' => '',
                    'password_err' => '',
                ];

                // valida os dados
                if(empty($data['usuario'])){
                    $data['usuario_err'] = 'Informe o seu nome de usuário';
                }                
                if(empty($data['password'])){
                    $data['password_err'] = 'Informe a sua senha';
                } 

                $existeUsuario = $this->userModel->findUserByLogin($data['usuario']);
                if($existeUsuario){
                    if($existeUsuario->primeiro_acesso){
                        redirect('users/primeiro_acesso/' .$existeUsuario->id);
                        $this->view('users/primeiro_acesso', $existeUsuario->id);
                    }

                } else {
                    $data['usuario_err'] = 'Nenhum usuário encontrado';
                }

                if(empty($data['usuario_err']) && empty($data['password_err'])){
                   $loggedInUser = $this->userModel->login($data['usuario'], $data['password']);

                   if($loggedInUser){                 
                        $this->createUserSession($loggedInUser);    
                                    
                   } else {
                       $data['password_err'] = 'Dados incorretos ou conta expirada';
                       $this->view('users/login', $data);
                   }

                } else {
                    $this->view('users/login', $data);
                }                


            } else {
                $data = [
                    'usuario' => '',
                    'password' => '',
                    'usuario_err' => '',
                    'password_err' => '',
                ];

                $this->view('users/login', $data);
            }
        }

        public function createUserSession($user){
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->nome;
            $_SESSION['user_nivel'] = $user->fk_nivel;
            redirect('projetos');
        }
        
        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_nivel']);
            session_destroy();
            redirect('users/login');
        }

        public function reset_password($id){
            $user = $this->userModel->getUserById($id);
            $usuario = $user->id;
            $data = [
                'usuario' => $user,
                'password' => '123456'
            ];
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                // registra o usuário
                if($this->userModel->resetPassword($data)){
                    flash('update_success', 'Senha resetada');
                    redirect('users');
                } else {
                    die('Algo deu errado');
                }           
        }

        public function edit($id){
            if(!isLoggedIn()){
                redirect('users');
            }
            $user = $this->userModel->getUserById($id);
            // verifica se é pra processar ou carregar o form
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                // carrega os dados
                $data = [
                    'id' => $user->id,
                    'nome' => trim($_POST['nome']),
                    'sobrenome' => trim($_POST['sobrenome']),
                    'usuario' => trim($_POST['usuario']),
                    'validade_conta' => trim($_POST['validade_conta']),
                    'nome_err' => '',
                    'sobrenome_err' => '',
                    'validade_conta_err' => ''
                ];

                // validação dos dados
                if(empty($data['usuario'])){
                    $data['usuario'] = 'Preencha seu nome de usuário';
                } 
                if(empty($data['nome'])){
                    $data['nome_err'] = 'Preencha seu nome';
                }
                if(empty($data['sobrenome'])){
                    $data['sobrenome_err'] = 'Preencha seu sobrenome';
                }
                if(empty($data['validade_conta'])){
                    $data['validade_conta_err'] = 'Preencha até quando a conta é válida';
                }
                

                // confirma que não teve erros
                if(empty($data['nome_err']) && empty($data['sobrenome_err'])  && empty($data['validade_conta_err'])){
                    $data['validade_conta'] = dataParaBanco($data['validade_conta']);
                // registra o usuário
                if($this->userModel->edit($data)){
                    flash('update_success', 'Usuário atualizado');
                    redirect('users');
                } else {
                    die('Algo deu errado');
                }

                } else {
                    // carrega view com os erros
                    $this->view('users/edit', $data);
                }

            } else {
                $data = [
                    'user' => $user,
                    'nome_err' => '',
                    'sobrenome_err' => '',
                    'validade_conta_err' => ''
                ];

                // carrega view
                $this->view('users/edit', $data);
            }
        }

        public function primeiro_acesso($id){
            $user = $this->userModel->getUserById($id);
            if(!$user->primeiro_acesso){
                redirect('projetos');
            }


            // verifica se é pra processar ou carregar o form
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                // carrega os dados
                $data = [
                    'id' => $user->id,
                    'nome' => $user->nome,
                    'sobrenome' => $user->sobrenome,
                    'usuario' => $user->login,
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];
                
                if(empty($data['password'])){
                    $data['password_err'] = 'Preencha sua senha';
                } elseif(strlen($data['password']) < 6){
                    $data['password_err'] = 'A senha deve conter pelo menos 6 caracteres';
                }

                if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = 'Confirme sua senha';
                } else {
                    if($data['password'] != $data['confirm_password']){
                        $data['confirm_password_err'] = 'As senhas são diferentes';
                    }
                }

                // confirma que não teve erros
                if(empty($data['password_err']) && empty($data['confirm_password_err'])){
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // registra o usuário
                if($this->userModel->primeiroAcesso($data)){
                    flash('update_success', 'Senha atualizada');
                    redirect('projetos');
                } else {
                    die('Algo deu errado');
                }

                } else {
                    // carrega view com os erros
                    $this->view('users/primeiro_acesso', $data);
                }

            } else {
                $data = [
                    'id' => $user->id,
                    'nome' => $user->nome,
                    'sobrenome' => $user->sobrenome,
                    'usuario' => $user->login,
                    'password' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // carrega view
                $this->view('users/primeiro_acesso', $data);
            }
        }

        public function delete($id){
            if($this->userModel->deleteUser($id)){
                flash('update_success', 'Usuário apagado');
                redirect('users');
            } else {
                die('Something went wrong');
            }
     
    }


    }
?>