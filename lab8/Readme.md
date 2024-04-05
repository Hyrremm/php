
# Лабораторная работа N8.
## 1,2,5. Создаем все необходимые директории и поддиректории
## 3,4,6,7. Создаем все необходимые файлы которые нам понадобятся в будущем для обьеденения в index.php
```php
#comments.php
<?php
$file = fopen("comments.txt", "r");
if ($file) {
    while (($line = fgets($file)) !== false) {
        $parts = explode('|',$line);
        echo $parts[0] . "<br>";
        echo $parts[1]. "<br><br>";
    }
    fclose($file);
} else {
    echo "Unable to open file.";
}
?>
#form.php

    <h2>Leave a Comment</h2>
    <form action="index.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="comment">Comment:</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br><br>
        
        <input type="submit" value="Submit">
    </form>

#form-handler.php
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

```

## 8. Обьеденяем файлы посредством команд include например:
```php
<?php include __DIR__ . '/views/components/form.php'; ?> 
```
## 10. Создаем специальный класс Page со статическими функциями для упрощения добавления компонентов.
```php
<?php

class Page {
    public static function includePath($path){
        if (file_exists($path)) {
            include $path;
            return true;
        } 
        return false;
    }
    public static function part($component) {
        $componentPath = "./views/components/{$component}.php";
        if(self::includePath($componentPath)) return;
        $componentPath = "./handlers/{$component}.php";
        if(self::includePath($componentPath)) return;
        echo "Component {$component} not found";
    }

}

?>
```
## ~ Используем его посредством следующих команд
```php
        <?php Page::part('form'); ?> # etc
```