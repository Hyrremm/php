<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $comment = $_POST['comment'];
    $file = fopen("comments.txt", "a");
    $data = "Username: $username|Comment: $comment\n";
    fwrite($file, $data);
    fclose($file);
    echo "<p>Your comment has been successfully submitted.</p>";
}
?>
