<?php
require_once 'DataService.php';

if(isset($_COOKIE['logged_in'])) {
    $dataService = DataService::getInstance();
    $login = $_COOKIE['logged_in'];

    // Check if there is a path in the URL
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path_components = explode('/', $path);
    if(count($path_components) > 1 && !empty($path_components[1])) {
        // If there is a non-empty path, use it as the login
        $login = $path_components[1];
        // Prevent adding posts if accessed via path
        $readOnly = true;
    } else {
        $readOnly = false;
    }

    if(isset($_POST['submit']) && !$readOnly) {
        $post_content = $_POST['post_content'];
        $dataService->addPostToUser($login, $post_content);
    }

    if(isset($_POST['logout'])) {
        // Remove the 'logged_in' cookie
        setcookie('logged_in', '', time() - 3600, '/');
        // Redirect to login page
        header('Location: login.php');
        exit();
    }

    $user_posts = $dataService->getUserPosts($login);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Posts</title>
    </head>
    <body>
        <h1>My Posts</h1>
        <?php if(!$readOnly): ?>
        <h2>Add a New Post</h2>
        <form method="post" action="">
            <label for="post_content">Post Content:</label><br>
            <textarea name="post_content" id="post_content" rows="4" cols="50"></textarea><br>
            <input type="submit" name="submit" value="Submit">
        </form>
        <?php endif; ?>
        <h2>My Posts:</h2>
        <?php
        foreach($user_posts as $post) {
            echo "<p>{$post['post_content']}</p>";
        }
        ?>
        <!-- Logout button -->
        <form method="post" action="">
            <input type="submit" name="logout" value="Logout">
        </form>
    </body>
    </html>
<?php
} else {
    echo "<script>window.location.href = 'login.php';</script>";
    exit(); 
}
?>
