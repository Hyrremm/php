<?php
ob_start();
require_once 'DataService.php';

// Start session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $dataService = DataService::getInstance();

    $user = $dataService->loginUser($username, $password);
if ($dataService->checkUserRole($username)) {
            $_SESSION['admin'] = true;
        }
    if ($user) {
        $_SESSION['logged_in'] = $username;
        if ($dataService->checkUserRole($username)) {
            $_SESSION['admin'] = true;
        }
        echo "<script>window.location.href = '/';</script>";
        exit();
    } else {
        echo "Login failed. Please check your username and password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
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
        .login-form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px #00000033;
        }
        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #cccccc;
        }
        .login-form button[type="submit"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            color: #ffffff;
            background-color: #007BFF;
        }
        .register-button {
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
        .register-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
    <a href="/register.php" class="register-button">
        Register
    </a>
</body>
</html>
