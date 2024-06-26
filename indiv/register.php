<?php
require_once 'DataService.php';

/**
 * Обработчик регистрации пользователя.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        echo "Error: Passwords do not match";
        exit;
    }

    $dataService = DataService::getInstance();

    $dataService->registerUser($username, $password);
    echo '<script>window.location.href = "login.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Страница регистрации</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px #00000033;
        }
        .register-form input[type="text"],
        .register-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #cccccc;
        }
        .register-form button[type="submit"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            color: #ffffff;
            background-color: #007BFF;
        }
        .login-button {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            color: #ffffff;
            background-color: #007BFF;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .login-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="register-form">
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
    </div>
    <a href="/login.php" class="login-button">
        Вход
    </a>
</body>
</html>
