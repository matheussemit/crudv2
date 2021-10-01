<?php
    // carrega os models e views

    // carrega o model, require no arquivo e instancia o model
    class Controller {
    public function model($model){
        require_once '../app/models/' . $model . '.php';
    return new $model();
    }

    // carrega o view
    public function view($view, $data = []){
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        } else {
            // view não existe
            die('View não encontrada');
        }
    }
}
?>