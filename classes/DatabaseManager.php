<?php

class Database
{
    private $host = 'localhost';
    private $db_name = 'php_task';
    private $username = 'root';
    private $password = 'root';
    private $conn;

    // Method to establish a database connection
    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }

    // Method to close the database connection
    public function disconnect()
    {
        $this->conn = null;
    }

    // Method to execute a query with prepared statements
    public function executeQuery($query, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            echo 'Query Error: ' . $e->getMessage();
            return false;
        }
    }

    // Method to fetch a single result
    public function fetch($query, $params = [])
    {
        $stmt = $this->executeQuery($query, $params);
        return $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
    }

    // Method to fetch all results
    public function fetchAll($query, $params = [])
    {
        $stmt = $this->executeQuery($query, $params);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false;
    }

    // Method to insert data and return the last inserted email
    public function insert($query, $params = [])
    {
        $stmt = $this->executeQuery($query, $params);
        return $stmt ? $params['email'] : false;
    }


    // Method to update or delete data
    public function updateOrDelete($query, $params = [])
    {
        $stmt = $this->executeQuery($query, $params);
        return $stmt ? $stmt->rowCount() : false;
    }
}
