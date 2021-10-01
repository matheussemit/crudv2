<?php
class User {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function register($data){

        $this->db->query('INSERT INTO tb_usuarios (nome, sobrenome, login, senha ) VALUES (:nome, :sobrenome, :usuario, :password)');
        
        $this->db->bind(':nome', $data['nome']);
        $this->db->bind(':sobrenome', $data['sobrenome']);
        $this->db->bind(':usuario', $data['usuario']);
        $this->db->bind(':password', $data['password']);
        
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }


    public function login($usuario, $password){
        $this->db->query('SELECT * FROM tb_usuarios WHERE login = :usuario');
        $this->db->bind(':usuario', $usuario);

        $row = $this->db->single();
        
        if($row){
            $hashed_password = $row->senha;
            
            if(password_verify($password, $hashed_password)){
                // atualiza o ultimo acesso
                $this->db->query('UPDATE tb_usuarios set ultimoAcesso = now() WHERE id = :id');
                $this->db->bind(':id', $row->id);
                $this->db->execute();
                return $row;
            } else return false;
        }
    }

    public function findUserByLogin($usuario){
        $this->db->query('SELECT * FROM tb_usuarios WHERE login = :usuario');
        $this->db->bind(':usuario', $usuario);

        $row = $this->db->single();

        if($this->db->rowCount() > 0){
            return $row;
        } else {
            return false;
        }
    }

    public function getUserById($id){
        $this->db->query('SELECT * FROM tb_usuarios WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row; 
    }

    public function getUsers(){
        $this->db->query('SELECT *, CONCAT(nome, " ", sobrenome) as nome_completo FROM tb_usuarios
        WHERE excluido = 0
        ');

        $results = $this->db->resultSet();

        return $results; 
    }

    public function resetPassword($data){
        $this->db->query('UPDATE tb_usuarios set senha = :senha, primeiro_acesso = 1 WHERE id = :id');
        $this->db->bind(':senha', $data['password']);
        $this->db->bind(':id', $data['usuario']->id);
        
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    function primeiroAcesso($data){
        $this->db->query('UPDATE tb_usuarios set senha = :senha, primeiro_acesso = 0 WHERE id = :id');
        $this->db->bind(':senha', $data['password']);
        $this->db->bind(':id', $data['id']);
        
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function edit($data){
        $usuario_modificacao = $_SESSION['user_id'];

        $this->db->query('UPDATE tb_usuarios  SET nome = :nome, sobrenome = :sobrenome, fk_usuario_modificacao = :usuario_modificacao, DataValidadeFinal = :validade_conta WHERE id = :id');
        
        $this->db->bind(':nome', $data['nome']);
        $this->db->bind(':sobrenome', $data['sobrenome']);
        $this->db->bind(':usuario_modificacao', $usuario_modificacao);
        $this->db->bind(':validade_conta', $data['validade_conta']);
        // $this->db->bind(':usuario', $data['usuario']);
        // $this->db->bind(':password', $data['password']);
        $this->db->bind(':id', $data['id']);
        
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function deleteUser($id){
        $this->db->query('UPDATE tb_usuarios SET excluido = 1 WHERE id = :id');
        $this->db->bind(':id', $id);
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
}
?>