<?php
class Filme {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function register($data){
        $this->db->query('INSERT INTO movies (original_title, overview, rating) VALUES (:original_title, :overview, :rating)');
        
        $this->db->bind(':original_title', $data['original_title']);
        $this->db->bind(':overview', $data['overview']);
        $this->db->bind(':rating', $data['rating']);
        
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function find($id){
        $this->db->query('SELECT * FROM movies WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        if($this->db->rowCount() > 0){
            return $row;
        } else {
            return false;
        }
    }

    public function findAll(){
        $this->db->query('SELECT * FROM movies');

        $results = $this->db->resultSet();

        return $results; 
    }

    public function edit($data){
        $this->db->query('UPDATE movies  SET original_title = :original_title, overview = :overview, rating = :rating WHERE id = :id');
        
        $this->db->bind(':original_title', $data['original_title']);
        $this->db->bind(':overview', $data['overview']);
        $this->db->bind(':rating', $rating);
        $this->db->bind(':id', $data['id']);
        
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function delete($id){
        $this->db->query('DELETE FROM movies WHERE id = :id');
        $this->db->bind(':id', $id);
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
}
?>