<?php
session_start();

require_once 'DataService.php';

if(isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    echo "<h1>Hello admin</h1>";
    $dataService = DataService::getInstance();

    if(isset($_POST['deleteUser'])) {
        $usernameToDelete = $_POST['usernameToDelete'];
        $deletedUser = $dataService->deleteUser($usernameToDelete);
        if($deletedUser) {
            echo "<p>User deleted successfully</p>";
        } else {
            echo "<p style='color: red;'>Failed to delete user</p>";
        }
    }

    if(isset($_POST['deletePost'])) {
        $postIdToDelete = $_POST['postIdToDelete'];
        $deletedPost = $dataService->deletePost($postIdToDelete);
        if($deletedPost) {
            echo "<p>Post deleted successfully</p>";
        } else {
            echo "<p style='color: red;'>Failed to delete post</p>";
        }
    }

    if(isset($_POST['createAdminUser'])) {
        $newAdminUsername = $_POST['newAdminUsername'];
        $newAdminPassword = $_POST['newAdminPassword'];
        $createdAdmin = $dataService->createAdminUser($newAdminUsername, $newAdminPassword);
        if($createdAdmin) {
            echo "<p>Admin user created successfully</p>";
        } else {
            echo "<p style='color: red;'>Failed to create admin user</p>";
        }
    }

} else {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Actions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
        }
        h1, h2 {
            text-align: center;
        }
        form {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 20px;
            max-width: 400px;
            margin: 0 auto;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        p {
            text-align: center;
            margin-bottom: 20px;
        }
        p.error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Delete User</h2>
    <form method="post" action="">
        <label for="usernameToDelete">Username to delete:</label><br>
        <input type="text" id="usernameToDelete" name="usernameToDelete"><br>
        <input type="submit" name="deleteUser" value="Delete User">
    </form>

    <h2>Delete Post</h2>
    <form method="post" action="">
        <label for="postIdToDelete">Post ID to delete:</label><br>
        <input type="text" id="postIdToDelete" name="postIdToDelete"><br>
        <input type="submit" name="deletePost" value="Delete Post">
    </form>

    <h2>Create Admin User</h2>
    <form method="post" action="">
        <label for="newAdminUsername">New Admin Username:</label><br>
        <input type="text" id="newAdminUsername" name="newAdminUsername"><br>
        <label for="newAdminPassword">New Admin Password:</label><br>
        <input type="password" id="newAdminPassword" name="newAdminPassword"><br>
        <input type="submit" name="createAdminUser" value="Create Admin User">
    </form>
</body>
</html>
