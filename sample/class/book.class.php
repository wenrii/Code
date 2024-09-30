<?php
    // Getting the Database class for Database connection
    require_once "database.class.php";

    // Product class to be called later on
    class Product{

        // Product attributes to be used 
        public $name; // Name of the product
        public $category; // Category of the product
        public $price; // Price of the product
        public $availability; // Availability of the product
        public $id; // ID of the product

        // Database connection object to be used in the class methods
        protected $db;

        // Database connection
        function __construct(){
            $this->db = new Database();
        }

        // fetchRecord() retieves a single record from the database based on its ID
        function fetchRecord($id){
            // Get the record from the database
            $sql = "SELECT * FROM book WHERE id = :id";

            // Prepare the SQL to be executed
            $query = $this->db->connect()->prepare($sql);

            // Bind the parameter to the SQL query
            $query->bindParam(':id', $id);

            // Nulling $data to clear
            $data = null; 

            // Execute the query to fetch the result
            if ($query->execute()) {
                $data = $query->fetch(); // Fetch the single row from the result set
            }
            return $data; // Return the fetched result
        }

        // Providing a keyword for Searching to show  all Products
        function showAll($keyword, $category){
            // SQL query to select all products from the database where name contains the keyword in ascending order by name
            $sql = "SELECT * FROM book WHERE name LIKE '%' :keyword '%' AND category LIKE '%' :category '%' ORDER BY name ASC ";

            // Prepare the SQL to be executed
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':keyword', $keyword);
            $query->bindParam(':category', $category);
            $data = null; // Making $data to null

            // Execute the query to fetch all result
            if ($query->execute()) {
                $data = $query->fetchAll(); // Fetch all results into an array
            }
            return $data; // Return the fetched results
        }

        // // Function to Get all and display all products from database
        // function showAll(){ // Show All Products
        //     // SQL query to select all products from the database in ascending order by name
        //     $sql = "SELECT * FROM book ORDER BY name ASC";

        //     // Prepare the SQL to be executed
        //     $query = $this->db->connect()->prepare($sql);
        //     $data = null; // Making $data to null

        //     // Execute the query to fetch all result
        //     if ($query->execute()) {
        //         $data = $query->fetchAll(); // Fetch all results into an array
        //     }
        //     return $data; // Return the fetched results
        // }

        // Function for Adding a Product
        function add(){

            // SQL query to insert product data into the database
            $sql = "INSERT INTO `book`(name, category, price, availability, id) VALUES (:name, :category, :price, :availability, :id)";
            
            // Prepare the SQL to be executed
            $query = $this->db->connect()->prepare($sql);

            // Bind the parameters to the SQL query
            $query->bindParam(':name', $this->name);
            $query->bindParam(':category', $this->category);
            $query->bindParam(':price', $this->price);
            $query->bindParam(':availability', $this->availability);
            $query->bindParam(':id', $this->id);
            // Execute the query and return true if successful, false otherwise
            if ($query->execute()) {
                return true;
        }else{
            return false;
        }
    }

        // Function for Editing a Product
        function edit(){
            // SQL query to update product data in the database
            $sql = "UPDATE book SET name = :name, category = :category, price = :price, availability = :availability WHERE id = :id;"; 

            // Prepare the SQL to be executed
            $query = $this->db->connect()->prepare($sql);

            // Bind the parameters to the SQL query
            $query->bindParam(':name', $this->name);
            $query->bindParam(':category', $this->category);
            $query->bindParam(':price', $this->price);
            $query->bindParam(':availability', $this->availability);
            $query->bindParam(':id', $this->id);

            // Execute the query and return true if successful, false otherwise
            return $query->execute();     
        }

        function delete($id) {
            // SQL query to delete a product from the database
            $sql = "DELETE FROM book WHERE id = :id";
            
            // Prepare the SQL to be executed
            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':id', $id);

            return $query->execute();
        }
        
    }
