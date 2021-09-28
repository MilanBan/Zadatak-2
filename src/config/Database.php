<?php 

class Database {
    //DB params
    private $host = "127.0.0.1";
    private $db_name = "quantox-02";
    private $username = "root";
    private $password = "root";
    private $conn;

    //DB Connect
    public function connect() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection Error: ". $e->getMessage();
        }

        return $this->conn;
    }

}