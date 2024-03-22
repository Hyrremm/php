<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My own form</title>
    <style>
        .error {color: #FF0000;}
    </style>
</head>
<body>

<?php
$nameErr = $emailErr = $commentErr = $agreeErr = "";
$name = $email = $comment = $agree = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        if (strlen($name) < 3 || strlen($name) > 20 || preg_match('/\d/', $name)) {
            $nameErr = "Name must be 3-20 characters long and contain no digits";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["comment"])) {
        $commentErr = "Comment is required";
    } else {
        $comment = test_input($_POST["comment"]);
        if (strlen($comment) < 5) {
            $commentErr = "Comment must be at least 5 characters long";
        }
    }

    if (empty($_POST["agree"])) {
        $agreeErr = "Please agree to data processing";
    } else {
        $agree = test_input($_POST["agree"]);
    }

    if (empty($nameErr) && empty($emailErr) && empty($commentErr) && empty($agreeErr)) {
        echo "<h2>Thank you for your comment:</h2>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Comment:</strong> $comment</p>";
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<h2>Comment Form</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Name: <input type="text" name="name" value="<?php echo $name;?>">
    <span class="error">* <?php echo $nameErr;?></span>
    <br><br>
    Email: <input type="text" name="email" value="<?php echo $email;?>">
    <span class="error">* <?php echo $emailErr;?></span>
    <br><br>
    Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
    <span class="error">* <?php echo $commentErr;?></span>
    <br><br>
    <input type="checkbox" name="agree" value="yes">
    I agree with data processing
    <span class="error">* <?php echo $agreeErr;?></span>
    <br><br>
    <input type="submit" name="submit" value="Submit">
</form>

</body>
</html>
