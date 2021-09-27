<?php 

class Database {
    //DB params
    private $host = 'localhost';
    private $db_name = 'quantox-02';
    private $username = 'root';
    private $password = 'root';
    private $conn;

    //DB Connect
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,
            $this->username, $this->password);
            $this->conn->serAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: '. $e->getMessage();
        }

        return $this->conn;
    }

}