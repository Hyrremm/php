
   <!DOCTYPE html>
<html>
<head>
    <title>Галерея котов</title>
    <style>
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .gallery img {
            width: 200px;
            height: 150px;
            margin: 10px;
        }
        footer {
            text-align: center;
        }
        header {
            display: flex;
            flex-wrap: nowrap;
        }
        nav li{
              float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
  padding-top: 30px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Галлерея котов</h1>
        <nav>
            <li><a href="#">Главная</a></li>
            <li><a href="#">Новости</a></li>
            <li><a href="#">Контакты</a></li>
    </nav>
    </header>
    <div class="gallery">
    <?php
        $dir = 'image/';
        $files = scandir($dir);
        if ($files === false) {
            echo 'Files in '.$files." not found";
            return;
        }
        for ($i = 0; $i < count($files); $i++) {
            if (($files[$i] != ".") && ($files[$i] != "..")) {
            $path = $dir . $files[$i]; ?>
            <img src="<?php echo $path ?>" alt="cat image" >
            <?php
            }
        }
   ?>
    </div>
    <footer>
        <p> 2024 Моя галерея изображений</p>
    </footer>
</body>
</html>