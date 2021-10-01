<?php
    class Database extends PDO{
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;

        private $dbh;
        private $stmt;
        private $error;

        public function __construct(){
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            try{
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);

            } catch(PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        // prepare statement
        public function query($sql){
            $this->stmt = $this->dbh->prepare($sql);
        }

        // bind values
        public function bind($param, $value, $type = null){
            if(is_null($type)){
                switch(true){
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;                  
                }
            }
            
            $this->stmt->bindValue($param, $value, $type);
        }

        // execute
        public function execute(){
            try{
                $this->stmt->execute();
                return true;
            } catch(PDOException $e){
                echo 'ERRO: ' . $e->getMessage(); 
                echo '<br>';
                return false;
            }
        }


        // results -> array de objetos
        public function resultSet(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // retorna um único objeto
        public function single(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        // retorna número de linhas
        public function rowCount(){
            return $this->stmt->rowCount();
        }

        // retorna o id da última query
        public function lastId(){
            $last_id = $this->dbh->lastInsertId();
            return $last_id;
        }

    }
?>