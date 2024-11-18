<?php
// Database.php: Database Connection Class

class Database {
    private $host = 'localhost'; // Replace with your database host
    private $dbname = 'QuoteItSystem'; // Database name
    private $username = 'root'; // Database username
    private $password = ''; // Database password
    private $pdo = null;

    // Get database connection
    public function getConnection() {
        if ($this->pdo === null) {
            try {
                // Create a new PDO instance
                $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);

                // Set PDO error mode to exception for debugging
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Optional: Set default fetch mode
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                // Handle connection errors
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}
