<?php

require_once 'database.class.php';

class Auth
{
    public $user_id;
    public $username;
    public $password;
    public $lastError = '';

    protected $db;

    public function __construct()  // Add public keyword
    {
        $this->db = new Database(); // Add parentheses for consistency
    }

    public function register()  // Add public keyword
    {
        try {  // Wrap in try...catch for better error handling
            $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
            $stmt = $this->db->connect()->prepare($sql); // Use $stmt for clarity

            $stmt->bindParam(':username', $this->username);
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT); // More descriptive variable name
            $stmt->bindParam(':password', $hashedPassword);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error during registration: " . $e->getMessage());
            $this->lastError = $e->getMessage(); // Assign to class property
            return false; 
        }
    }

    public function login($username, $password)  // Add public keyword
    {
        try {
            $sql = "SELECT * FROM user WHERE username = :username LIMIT 1";
            $stmt = $this->db->connect()->prepare($sql);
            $stmt->bindParam(':username', $username);

            if ($stmt->execute()) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC); // Use FETCH_ASSOC for clarity
                if ($data && password_verify($password, $data['password'])) {
                    $this->user_id = $data['id']; // Set user_id property after successful login
                    return $data;
                }
            }
        } catch (PDOException $e) {
            error_log("Database error during login: " . $e->getMessage());
            // Handle the exception appropriately
        }

        return false;
    }

    public function usernameExist($username, $excludeID = null)  // Use null as default
    {
        try {
            $sql = "SELECT COUNT(*) FROM user WHERE username = :username";
            if ($excludeID !== null) { // Strict comparison
                $sql .= " AND id != :excludeID";  // Use AND for clarity
            }


            $stmt = $this->db->connect()->prepare($sql);
            $stmt->bindParam(':username', $username);


            if ($excludeID !== null) {
                $stmt->bindParam(':excludeID', $excludeID, PDO::PARAM_INT);  // Specify data type
            }


            $stmt->execute();
            $count = $stmt->fetchColumn();


            return $count > 0;
        } catch (PDOException $e) {
            error_log("Database error in usernameExist: " . $e->getMessage());
            return false; // Or throw an exception
        }
    }
}
