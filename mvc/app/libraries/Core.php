<?php
    // cria url e carrega controllers
    // URL: /controller/metodo/parametros

    class Core{
        protected $currentController = 'Filmes';
        protected $currentMethod = 'index';
        protected $params = [];


        public function __construct(){
            $url = $this->getUrl();

            // encontra o controller e direciona pra ele
            if($url){
                if(file_exists('../app/controllers/' . ucwords($url[0]) . '.controller.php')){
                    $this->currentController = ucwords($url[0]);
                    unset($url[0]);
                }
            }

                require_once '../app/controllers/' . $this->currentController . '.controller.php';

                // instancia o controller
                $this->currentController = new $this->currentController;

                // procura a segunda parte da url
                if(isset($url[1])){
                    // procura o metodo no controller
                    if(method_exists($this->currentController, $url[1])){
                        $this->currentMethod = $url[1];
                        unset($url[1]);
                    }
                }

                // pega os parametros
                $this->params = $url ? array_values($url) : [];
                call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        public function getUrl(){
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }
        }
    }
?>