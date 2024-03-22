<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тест</title>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        echo "Пожалуйста, введите ваше имя.<br>";
    } else {
        $username = $_POST["username"];
        echo "<h2>Результаты для $username:</h2>";

        $score = 0;

        if ($_POST["q1"] == "10") {
            $score++;
        }
        echo "Вопрос 1: Сколько будет 5 + 5? Ваш ответ: " . $_POST["q1"] . ". Правильный ответ: 10.<br>";

        if ($_POST["q2"] == "Java") {
            $score++;
        }
        echo "Вопрос 2: Какой язык используется для создания веб-страниц? Ваш ответ: " . $_POST["q2"] . ". Правильный ответ: JAVA.<br>";

        $correctOptions = array("GO", "SQL");
        $selectedOptions = isset($_POST["q3"]) ? $_POST["q3"] : array();
        if (array_diff($correctOptions, $selectedOptions) === array()) {
            $score++;
        }
        echo "Вопрос 3: Какие из перечисленных являются языками фронтенда? Ваш ответ: " . implode(", ", $selectedOptions) . ". Правильный ответ: " . implode(", ", $correctOptions) . ".<br>";

        echo "<h3>Ваш итоговый результат: $score/3</h3>";
    }
}
?>

<h2>Тест</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Пожалуйста, введите ваше имя: <input type="text" name="username"><br><br>

    <p>Вопрос 1: Сколько будет 5 + 5?</p>
    <input type="text" name="q1"><br><br>

    <p>Вопрос 2: Какой язык программирования преимущественно используется в Back-End?</p>
    <input type="radio" name="q2" value="Java"> Java<br>
    <input type="radio" name="q2" value="CSS"> CSS<br>
    <input type="radio" name="q2" value="JavaScript"> JavaScript<br><br>

    <p>Вопрос 3: Какие из перечисленных являются не являются языками фронтенда?</p>
    <input type="checkbox" name="q3[]" value="Javascript"> Javascript<br>
    <input type="checkbox" name="q3[]" value="GO"> GO<br>
    <input type="checkbox" name="q3[]" value="SQL"> SQL<br><br>

    <input type="submit" value="Отправить">
</form>

</body>
</html>
