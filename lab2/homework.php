<?php
$dayOfWeek = date("N");

if ($dayOfWeek == 1 || $dayOfWeek == 3 || $dayOfWeek == 5) {
    $workingHours = "8:00-12:00";
} elseif ($dayOfWeek == 2 || $dayOfWeek == 4 || $dayOfWeek == 6) {
    $workingHours = "12:00-16:00";
} else {
    $workingHours = "Нерабочий день";
}

echo "<table border='1'>";
echo "<tr><th colspan='3'>График работы докторов, каб. 333</th></tr>";
echo "<tr><th>П.н.</th><th>Фамилия, имя</th><th>График</th></tr>";
echo "<tr><td>1.</td><td>Аксенти Елена</td><td>$workingHours</td></tr>";
echo "<tr><td>2.</td><td>Петрова Мария</td><td>$workingHours</td></tr>";
echo "</table>";

// Свой пример

$dayOfWeek = date("N");

$taskList = "";

switch ($dayOfWeek) {
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        $taskList = "Рабочие задачи:\n";
        $taskList .= "1. Идти в университет\n";
        $taskList .= "2. Учиться\n";
        $taskList .= "3. Делать домашнюю работу\n";
        break;
    case 6:
    case 7:
        $taskList = "Задачи на выходные:\n";
        $taskList .= "1. Отдохнуть\n";
        $taskList .= "2. Отдохнуть от отдыха\n";
        $taskList .= "3. Ничего не делать\n";
        break;
    default:
        $taskList = "Неизвестный день.";
}

echo "<pre>$taskList</pre>";
?>