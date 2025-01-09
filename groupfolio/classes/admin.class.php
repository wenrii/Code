<?php

require_once 'database.class.php';

class Admin
{
    private $error = "";
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAdmin()
    {
        $sql = "SELECT * FROM user WHERE is_admin = 1";
        $query = $this->db->connect()->prepare($sql);

        try {
            if ($query->execute()) {
                return $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows
            } else {
                $this->error = $query->errorInfo()[2];
                return false;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function getUser()
    {
        $sql = "SELECT * FROM profile";
        $query = $this->db->connect()->prepare($sql);

        try {
            if ($query->execute()) {
                return $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows
            } else {
                $this->error = $query->errorInfo()[2];
                return false;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }
}
