<?php
/**
 * Класс DataService
 */
class DataService {
    /**
     * @var DataService|null Экземпляр Singleton
     */
    private static $instance;
    /**
     * @var PDO Подключение к базе данных
     */
    private $pdo;

    /**
     * Конструктор DataService.
     */
    private function __construct() {
        $host = 'localhost'; // Хост базы данных
        $port = 5434; // Порт базы данных
        $dbname = 'hyrrem'; // Имя базы данных
        $user = 'hyrrem'; // Пользователь базы данных
        $password = '1233211'; // Пароль базы данных

        try {
            $this->pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Ошибка соединения: " . $e->getMessage());
        }
    }

    /**
     * Получить экземпляр DataService (паттерн Singleton).
     *
     * @return DataService|null Экземпляр Singleton
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new DataService();
        }
        return self::$instance;
    }

    /**
     * Регистрация нового пользователя.
     *
     * @param string $username Имя пользователя
     * @param string $password Пароль
     */
    public function registerUser($username, $password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (login, password) VALUES (:username, :password)";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password_hash);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Ошибка в SQL-запросе: " . $e->getMessage());
        }
    }

    /**
     * Проверить роль пользователя.
     *
     * @param string $username Имя пользователя
     * @return bool Роль админа (true) или нет (false)
     */
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
            die("Ошибка в SQL-запросе: " . $e->getMessage());
        }
    }

    /**
     * Войти пользователя.
     *
     * @param string $username Имя пользователя
     * @param string $password Пароль
     * @return array|bool Массив данных пользователя или false, если неудача
     */
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
            die("Ошибка в SQL-запросе: " . $e->getMessage());
        }
    }

    /**
     * Добавить запись к пользователю.
     *
     * @param string $username Имя пользователя
     * @param string $post_content Содержание записи
     * @return bool Успешность операции
     */
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
            die("Ошибка в SQL-запросе: " . $e->getMessage());
        }
    }

    /**
     * Получить записи пользователя.
     *
     * @param string $username Имя пользователя
     * @return array Список записей пользователя
     */
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
    
            $sql_posts = "SELECT * FROM posts WHERE user_id = :user_id"; // Выбрать все столбцы
    
            $stmt_posts = $this->pdo->prepare($sql_posts);
            $stmt_posts->bindParam(':user_id', $user_id);
            $stmt_posts->execute();
            $user_posts = $stmt_posts->fetchAll(PDO::FETCH_ASSOC);
            return $user_posts;
        } catch (PDOException $e) {
            die("Ошибка в SQL-запросе: " . $e->getMessage());
        }
    }

    /**
     * Удалить пользователя.
     *
     * @param string $username Имя пользователя
     * @return bool Успешность операции
     */
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
            die("Ошибка в SQL-запросе: " . $e->getMessage());
        }
    }

    /**
     * Проверить существование пользователя.
     *
     * @param string $username Имя пользователя
     * @return bool Существует ли пользователь
     */
    public function checkUserExists($username) {
        $sql = "SELECT COUNT(*) FROM users WHERE login = :username";
    
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0; // Если количество больше 0, пользователь существует
        } catch (PDOException $e) {
            die("Ошибка в SQL-запросе: " . $e->getMessage());
        }
    }

    /**
     * Удалить запись.
     *
     * @param int $post_id Идентификатор записи
     * @return bool Успешность операции
     */
    public function deletePost($post_id) {
        $sql_delete_post = "DELETE FROM posts WHERE post_id = :post_id";
        
        try {
            $stmt_delete_post = $this->pdo->prepare($sql_delete_post);
            $stmt_delete_post->bindParam(':post_id', $post_id);
            $stmt_delete_post->execute();
            return true;
        } catch (PDOException $e) {
            die("Ошибка в SQL-запросе: " . $e->getMessage());
        }
    }

    /**
     * Создать администратора.
     *
     * @param string $username Имя администратора
     * @param string $password Пароль
     * @return bool Успешность операции
     */
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
            die("Ошибка в SQL-запросе: " . $e->getMessage());
        }
    }
}
?>
