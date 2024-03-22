<?php
// Задание 3
$varsta = 22;
if (($varsta > 12) && ($varsta < 20)) {
$mesaj=" вы подросток!";
} elseif ($varsta > 40) {
$mesaj=" вы взрослый человек!";
} else {
$mesaj=" вы в рассвете сил ...
приступайте к работе!";
}
// $nume = "Аня";
echo ($nume) ? $nume.', '.$mesaj : 'Anonymous,
'.$mesaj;
echo "<br \>";
// Задание 4
$dayOfWeek = date("N");

switch ($dayOfWeek) {
    case 1:
        $dayName = "понедельник";
        break;
    case 2:
        $dayName = "вторник";
        break;
    case 3:
        $dayName = "среда";
        break;
    case 4:
        $dayName = "четверг";
        break;
    case 5:
        $dayName = "пятница";
        break;
    case 6:
        $dayName = "суббота";
        break;
    case 7:
        $dayName = "воскресенье";
        break;
    default:
        $dayName = "неизвестно";
}

$currentDate = date("d.m.y");


echo "Сегодня, $dayName, $currentDate";
?>