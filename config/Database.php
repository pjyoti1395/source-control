<?php
    class Database {

        private $host = "localhost";
        private $user = "root";
        private $password = "";
        private $dbname = "company_db";        
        private $conn;

        public function connect() {
            $this->conn = null;

            try {

                $this->conn = new PDO("mysql:host=" . $this->host .
                                        ";dbname=" . $this->dbname,
                                        $this->user,
                                        $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            }
            catch(PDOException $ex) {
                echo "Error in connecting " . $ex->getMessage();
            }       
            
            return $this->conn;
        }

    }
?>