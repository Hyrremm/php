<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numberInput = $_POST["number"];
    $selectOption = $_POST["option"];

    echo "<h2>Вы преобрели:</h2>";
    echo "Количество: $numberInput <br>";
    echo "Выбранный товар: $selectOption";
}
?>

<h2>Форма</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="number">Введите число товара:</label>
    <input type="number" id="number" name="number" required><br><br>

    <label for="option">Выберите товар:</label>
    <select id="option" name="option">
        <option value="Еда">Еда</option>
        <option value="Древесина">Древесина</option>
        <option value="Камень">Камень</option>
    </select><br><br>

    <input type="submit" value="Отправить">
</form>

</body>
</html>
