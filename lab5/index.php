    <?php
    /**
    * Sanitizes the given data.
    * @param string $data The data to sanitize.
    * @return string The sanitized data.
    */
    function sanitizeData(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    $errors = [];
    if (isset($_POST['login'])) {
        $_POST['login'] = sanitizeData($_POST['login']);
    }
        if (isset($_POST["register"])) {
        if (empty($_POST['login'])) {
            $errors['login'][] = 'Введите имя!';
        }
        if (empty($_POST['password'])) {
            $errors['password'][] = 'Введите пароль!';
        }
        if(strlen($_POST['login'])>=32||strlen($_POST['login'])<=4){
            $errors['login'][] = 'Имя должно содержать меньше 32 и больше 4 символов';
        }
        if(strlen($_POST['password'])>=64||strlen($_POST['password'])<=8){
            $errors['password'][] = 'Пароль должно содержать меньше 64 и больше 8 символов';
        }
        if (count($errors) === 0) {
            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            $data = [
                'name' => $_POST['login'],
                'password' => $hashedPassword,
            ];
            
            $log = fopen("users.txt", "a+") or die("Недоступный файл!");
            $ifExist = false;
            while (!feof($log)) {
                $line = trim(strstr(fgets($log), ':', true));
                if ($line == $data['name']) {
                    $ifExist = true;
                    $errors['login'][] = 'Пользователь с таким именем уже существует!';
                    break;
                }
            }
            if (!$ifExist) {
                fwrite($log, $data['name'] . ':' . $data['password'] . PHP_EOL);
                fclose($log);
                header("HTTP/1.1 201 Created");
                $successMessage = 'Регистрация успешна!';
            }
        }
    }

    if (isset($_POST["auth"])) {
        $data = [
            'login' => $_POST['login'],
            'password' => $_POST['password'],
        ];

        $log = fopen("users.txt", "r") or die("Недоступный файл!");
        $ifExist = false;
        while (!feof($log)) {
            $line = trim(fgets($log));
            if (strpos($line, $data['login']) !== false) {
                $ifExist = true;
                [$storedName, $storedHashedPassword] = explode(":", $line);
                if (password_verify($data['password'], $storedHashedPassword)) {
                    header("Location: cats.php");     
                    exit();
                } else {
                    $errors['auth'][] = 'Неправильный логин или пароль!';
                }
                break;
            }
        }
        if (!$ifExist) {
            $errors['auth'][] = 'Пользователь не найден!';
        }
        fclose($log);
    }
    ?>

    <div>
        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
            <label>
                <span>Name</span>
                <input name="login"/>
                <?php if (!empty($errors["login"])) : ?>
                    <?php foreach ($errors["login"] as $error) : ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </label>
            <label>
                <span>Password</span>
                <input type="password" name="password">
                <?php if (!empty($errors["password"])) { 
                    foreach ($errors["password"] as $error) { ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php } 
                } ?>
            </label>
            <input type="submit" name="register" value="Регистрация"/>
            <?php if (!empty($successMessage)) { ?>
                <p><?php echo $successMessage; ?></p>
            <?php } ?>
        </form>
    </div>

    <div>
        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
            <label>
                <span>Name</span>
                <input name="login"/>
            </label>
            <label>
                <span>Password</span>
                <input type="password" name="password">
                <?php if (!empty($errors["auth"])) { ?>
                    <?php foreach ($errors["auth"] as $error) { ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php } ?>
                <?php } ?>
            </label>
            <input type="submit" name="auth" value="Авторизация"/>
        </form>
    </div>
