<?php
    class Filmes extends Controller{
        public function __construct(){
            $this->filmeModel = $this->model('Filme');
        }

        public function index(){
            $this->view('filmes/index');
        }

        public function list(){
            $filmes = $this->filmeModel->findAll();
            $data = [
                'filmes' => $filmes
            ];
    
            $this->view('filmes/list', $data);
        }

        public function show($id){
            if(!isLoggedIn()){
                redirect('users/login');
            }
            // get projeto
            $filme = $this->filmeModel->find($id);
    
            $data = [
                'filme' => $filme
            ];
    
            $this->view('filmes/show', $data);
        }

        public function register(){
            // verifica se é pra processar ou carregar o form
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'original_title' => trim($_POST['original_title']),
                    'overview' => trim($_POST['overview']),
                    'rating' => trim($_POST['rating']),
                ];

                if(empty($data['original_title']) || empty($data['overview']) || empty($data['rating'])){
                    $this->view('users/register', $data);
                }

                // registra o usuário
                if($this->filmeModel->register($data)){
                    flash('update_success', 'Cadastro efetuado');
                    redirect('filmes');
                } else {
                    $this->view('filmes/register', $data);
                    // die('Algo deu errado');
                }

            } else {
                $data = [
                    'original_title' => '',
                    'overview' => '',
                    'rating' => '',
                ];
                $this->view('filmes/register', $data);
            }
        }

       
        public function edit($id){
            if(!isLoggedIn()){
                redirect('filmes');
            }
            $filme = $this->filmeModel->find($id);
            // verifica se é pra processar ou carregar o form
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                // carrega os dados
                $data = [
                    'id' => $id,
                    'original_title' => trim($_POST['original_title']),
                    'overview' => trim($_POST['overview']),
                    'rating' => trim($_POST['rating']),
                ];

                // confirma que não teve erros
                if(empty($data['original_title']) || empty($data['overview'])  || empty($data['rating'])){
                    $this->view('filmes/edit', $data);
                }

                if($this->filmeModel->edit($data)){
                    flash('update_success', 'Filme atualizado');
                    redirect('index');
                } else {
                    $this->view('filmes/edit', $data);
                    // die('Algo deu errado');
                }

            } else {
                $data = [
                    'filme' => $filme,
                ];

                // carrega view
                $this->view('filmes/edit', $data);
            }
        }

        public function delete($id){
            if($this->filmeModel->delete($id)){
                flash('update_success', 'Filme apagado');
                redirect('filmes');
            } else {
                die('Something went wrong');
            }
     
    }


    }
?>