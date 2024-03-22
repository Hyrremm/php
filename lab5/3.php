<?php
if (!isset($_REQUEST['start'])) {
?>
<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
    <div>
        <label>Ваше имя: <input name="name" type="text" size="30"></label>
    </div>
    <div>
        <label>Ваш возраст: <input name="age" type="number"></label>
    </div>
    <div>
        <label>Ваш E-mail: <input name="email" type="email"></label>
    </div>
    <div>
        <label>Ваше мнение о нас напишите тут:
            <textarea name="message" cols="40" rows="4" placeholder="Ваше мнение..."></textarea>
        </label>
    </div>
    <div>
        <input type="reset" value="Стереть"/>
        <input type="submit" value="Передать" name="start"/>
    </div>
</form>
<?php
} else {
    $errors = array();

    if (empty($_POST['name'])) {
        $errors[] = 'Имя обязательно для заполнения';
    }

    $age = $_POST['age'] ?? '';
    if (!is_numeric($age) || $age <= 0) {
        $errors[] = 'Неправильный формат возраста';
    }

    $email = $_POST['email'] ?? '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Неправильный формат email';
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
    } else {
        $data = [
            'name' => $_POST['name'],
            'age' => $age,
            'email' => $email,
            'message' => $_POST['message'] ?? "",
        ];

        $file = fopen('messages.txt', 'a+') or die("Недоступный файл!");
        foreach ($data as $field => $value) {
            fwrite($file, "$field:$value\n");
        }
        fwrite($file, "\n");
        fclose($file);

        echo 'Данные были сохранены! Вот что хранится в файле: <br />';
        $file = fopen("messages.txt", "r") or die("Недоступный файл!");
        while (!feof($file)) {
            echo fgets($file) . "<br />";
        }
        fclose($file);
    }
}
?>
