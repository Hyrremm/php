# Лабораторная работа N8.
## 1,2,5. Создаем все необходимые директории и поддиректории
## 3,4,6,7. Создаем все необходимые файлы которые нам понадобятся в будущем для обьеденения в index.php
## 8. Обьеденяем файлы посредством команд include 
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