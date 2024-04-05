
<?php include __DIR__ . '/classes/Page.php'; ?> 
<?php Page::part('form-handler'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <style>
        /* CSS for inline display of navigation links */
        header nav {
            text-align: center;
        }

        header nav a {
            display: inline-block;
            margin-right: 20px; /* Adjust as needed */
        }
    </style>
</head>
<body>

<header>
    <h2 >My Cool Website</h2>
    <nav>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Services</a>
        <a href="#">Contact</a>
    </nav>
</header>
<main>
    <section>
        <?php Page::part('form'); ?>
     </section>
    <section>
    <?php Page::part('comments'); ?>
</section>
</main>

<footer>
    <p>&copy; 2024 Your Website. All rights reserved.</p>
</footer>

</body>
</html>

