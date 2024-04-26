<?php
class DataService {
    private static $instance;
    private $pdo;

    private function __construct() {
        $host = 'localhost';
        $port = 5434;
        $dbname = 'hyrrem';
        $user = 'hyrrem';
        $password = '1233211';

        try {
            $this->pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connection successful"; // Commenting out the echo for cleaner output
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new DataService();
        }
        return self::$instance;
    }

    public function registerUser($username, $password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (login, password) VALUES (:username, :password)";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password_hash);
            $stmt->execute();
            // echo "User registered successfully"; // Commenting out the echo for cleaner output
        } catch (PDOException $e) {
            die("Error in SQL query: " . $e->getMessage());
        }
    }

    public function loginUser($username, $password) {
        $sql = "SELECT * FROM users WHERE login = :username";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    // echo "Login successful"; // Commenting out the echo for cleaner output
                    return $user;
                } else {
                    // echo "Incorrect password"; // Commenting out the echo for cleaner output
                    return false;
                }
            } else {
                // echo "User not found"; // Commenting out the echo for cleaner output
                return false;
            }
        } catch (PDOException $e) {
            die("Error in SQL query: " . $e->getMessage());
        }
    }

    public function addPostToUser($username, $post_content) {
        $sql_user_id = "SELECT id FROM users WHERE login = :username";
    
        try {
            $stmt_user_id = $this->pdo->prepare($sql_user_id);
            $stmt_user_id->bindParam(':username', $username);
            $stmt_user_id->execute();
            $user = $stmt_user_id->fetch(PDO::FETCH_ASSOC);
    
            if (!$user) {
                return false;
            }
    
            $user_id = $user['id'];
    
            $sql_insert_post = "INSERT INTO posts (user_id, post_content) VALUES (:user_id, :post_content)";
    
            $stmt_insert_post = $this->pdo->prepare($sql_insert_post);
            $stmt_insert_post->bindParam(':user_id', $user_id);
            $stmt_insert_post->bindParam(':post_content', $post_content);
            $stmt_insert_post->execute();
            return true;
        } catch (PDOException $e) {
            die("Error in SQL query: " . $e->getMessage());
        }
    }

    public function getUserPosts($username) {
        $sql_user_id = "SELECT id FROM users WHERE login = :username";
    
        try {
            $stmt_user_id = $this->pdo->prepare($sql_user_id);
            $stmt_user_id->bindParam(':username', $username);
            $stmt_user_id->execute();
            $user = $stmt_user_id->fetch(PDO::FETCH_ASSOC);
    
            if (!$user) {
                return [];
            }
    
            $user_id = $user['id'];
    
            $sql_posts = "SELECT post_content FROM posts WHERE user_id = :user_id";
    
            $stmt_posts = $this->pdo->prepare($sql_posts);
            $stmt_posts->bindParam(':user_id', $user_id);
            $stmt_posts->execute();
            $user_posts = $stmt_posts->fetchAll(PDO::FETCH_ASSOC);
            return $user_posts;
        } catch (PDOException $e) {
            die("Error in SQL query: " . $e->getMessage());
        }
    }
    
}
?>
