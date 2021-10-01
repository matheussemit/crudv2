<?php
    class FTPAccess {
        private $host = FTP_HOST;
        private $user = FTP_USER;
        private $pass = FTP_PASS;

        private $conn;
        private $login;
        private $error;
        private $diretorioAtual;

        public function __construct() {
            $this->conn = ftp_connect($this->host);
            $this->login = ftp_login($this->conn, $this->user, $this->pass);
            $this->error = "";
            $this->diretorioAtual = [];

            $this->error = $this->conn ? '' : 'Conexão não estabelecida com o servidor FTP';
            $this->error = $this->login ? '' : 'Acesso inválido ao servidor FTP';
        }

        public function conectar() {
            $this->conn = ftp_connect($this->host);
            $this->error = $this->conn ? '' : 'Acesso inválido ao servidor FTP';
        }

        public function mudarDiretorio($caminho) {
            $this->error = ftp_chdir($this->conn, $caminho) ? '' : 'Diretório FTP não encontrado';
        }
 
        public function listarArquivos($caminho) {
            $this->diretorioAtual = ftp_nlist($this->conn, $caminho);
            $this->error = !empty($this->diretorioAtual) ? "" : 'O Diretório FTP atual encontra-se vazio';
        }

        public function desconectar() {
            return ftp_close($this->conn);
        }
    }
?>