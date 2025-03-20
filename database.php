<?php
    class Database {
        private $host = "localhost";
        private $db_name = "test1";
        private $username = "root";
        private $password = "";
        public $db;

        public function dbConnection() {
            $this->db = null;
            try {
                $this->db = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->db->exec("set names utf8");
            } catch(PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
            }
            return $this->db;
        }
    }
?>