<?php
class DataService {
    private $pdo;

    public function __construct() {
        $host = 'localhost';
        $port = 5434;
        $dbname = 'hyrrem';
        $user = 'hyrrem';
        $password = '1233211';

        try {
            $this->pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
            // Setting PDO to throw exceptions on errors
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connection successful";
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function registerUser($username, $password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (login, password_hash) VALUES (:username, :password)";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password_hash);
            $stmt->execute();
            echo "User registered successfully";
        } catch (PDOException $e) {
            die("Error in SQL query: " . $e->getMessage());
        }
    }
}
?>
