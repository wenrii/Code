<?php
    // Class for database connections
    class Database{
        private $host = 'localhost';    // Database host naming
        private $username = 'root';     // Database username naming
        private $password = '';         // Database password naming
        private $dbname = 'sample';     // Database databasename naming

        // Protected PDO connection for this Class 
        protected $connection;

        // Function to connect to database
        function connect(){

            try{
            // Creating new PDO instance to connecto to the Database
            $this->connection = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname", // Database 
                $this->username,    // Calling username
                $this->password     // Calling password
            );
        }catch (PDOException $e){
            // Catch if connection is not established
            die('Connection failed: '. $e->getMessage()); // Error message
        }
        return $this->connection; // Return PDO instance
    }
}