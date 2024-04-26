<?php
require_once 'DataService.php';

session_start();

if(isset($_SESSION['logged_in'])) {
    $dataService = DataService::getInstance();
    $login = $_SESSION['logged_in'];

    // Check if there's a path variable and set login accordingly
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path_components = explode('/', $path);
    if(count($path_components) > 1 && !empty($path_components[1])) {
        $login = $path_components[1];
        $readOnly = true;
        // Check if the user exists
        $user_exists = $dataService->checkUserExists($login);
        if(!$user_exists) {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>User Doesn't Exist</title>
                <style>
                    /* CSS for the error message */
                    .error-message {
                        background-color: #f8d7da; /* Red background color */
                        color: #721c24; /* Red text color */
                        padding: 10px; /* Padding around the message */
                        border: 1px solid #f5c6cb; /* Red border */
                        border-radius: 5px; /* Rounded corners */
                        margin-bottom: 20px; /* Spacing below the message */
                    }
                </style>
            </head>
            <body>
                <!-- Error message for non-existing user -->
                <div class="error-message">THE USER DOESN'T EXIST</div>
            </body>
            </html>
            <?php
            exit();
        }
    } else {
        $readOnly = false;
    }

    if(isset($_POST['submit']) && !$readOnly) {
        $post_content = $_POST['post_content'];
        $dataService->addPostToUser($login, $post_content);
    }

    if(isset($_POST['logout'])) {
        session_unset();
        session_destroy();
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
        <title><?php echo ucfirst($login); ?>'s Page</title>
        <style>
            /* CSS for the container and logout button */
            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                position: relative; /* Set the container to relative position */
            }
            .logout-container {
                position: absolute; /* Position the logout container absolutely */
                top: 10px; /* Adjust top position */
                right: 10px; /* Adjust right position */
            }
            /* CSS for other elements */
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f5f5f5;
            }
            h1 {
                color: #333;
                margin-bottom: 20px; /* Add margin bottom */
            }
            h2 {
                color: #333;
            }
            form {
                margin-bottom: 20px;
            }
            textarea {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                resize: vertical;
            }
            input[type="submit"] {
                padding: 10px 20px;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            input[type="submit"]:hover {
                background-color: #0056b3;
            }
            .post {
                background-color: #fff;
                padding: 15px;
                margin-bottom: 10px;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <!-- Logout button -->
            <div class="logout-container">
                <form method="post" action="">
                    <input type="submit" name="logout" value="Logout">
                </form>
            </div>
            <h1 style="margin-bottom: 40px;"><?php echo ucfirst($login); ?>'s Page</h1>
            <?php if(!$readOnly): ?>
            <!-- Form to add a new post -->
            <h2>Add a New Post</h2>
            <form method="post" action="">
                <label for="post_content">Post Content:</label><br>
                <textarea name="post_content" id="post_content" rows="4" cols="50"></textarea><br>
                <input type="submit" name="submit" value="Submit">
            </form>
            <?php endif; ?>
            <!-- Display user's posts -->
            <h2>Posts:</h2>
            <?php
            foreach($user_posts as $post) {
                echo "<div class='post'>{$post['post_content']}</div>";
            }
            ?>
            <!-- Display home page link if on a user's page -->
            <?php if($readOnly): ?>
            <a href="/">Home Page</a>
            <?php endif; ?>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "<script>window.location.href = 'login.php';</script>";
}
?>
