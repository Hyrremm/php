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
    public function checkUserRole($username) {
        $sql = "SELECT role FROM users WHERE login = :username";
    
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user && $user['role'] === 'admin') {
                return true;
            } else {
                return false;
            }
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
                    return $user;
                } else {
                    return false;
                }
            } else {
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
    public function deleteUser($username) {
        $this->pdo->beginTransaction(); 
    
        try {
            $sql_delete_posts = "DELETE FROM posts WHERE user_id = (SELECT id FROM users WHERE login = :username)";
            $stmt_delete_posts = $this->pdo->prepare($sql_delete_posts);
            $stmt_delete_posts->bindParam(':username', $username);
            $stmt_delete_posts->execute();
    
            $sql_delete_user = "DELETE FROM users WHERE login = :username";
            $stmt_delete_user = $this->pdo->prepare($sql_delete_user);
            $stmt_delete_user->bindParam(':username', $username);
            $stmt_delete_user->execute();
    
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollback();
            die("Error in SQL query: " . $e->getMessage());
        }
    }
    public function checkUserExists($username) {
        $sql = "SELECT COUNT(*) FROM users WHERE login = :username";
    
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0; // If count is greater than 0, user exists
        } catch (PDOException $e) {
            die("Error in SQL query: " . $e->getMessage());
        }
    }
    
    public function deletePost($post_id) {
        $sql_delete_post = "DELETE FROM posts WHERE post_id = :post_id";
        
        try {
            $stmt_delete_post = $this->pdo->prepare($sql_delete_post);
            $stmt_delete_post->bindParam(':post_id', $post_id);
            $stmt_delete_post->execute();
            return true;
        } catch (PDOException $e) {
            die("Error in SQL query: " . $e->getMessage());
        }
    }
    
    public function createAdminUser($username, $password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (login, password, role) VALUES (:username, :password, 'admin')";
    
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password_hash);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            die("Error in SQL query: " . $e->getMessage());
        }
    }
    
}
?>
