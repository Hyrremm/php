<?php
// ЗАДАНИЕ 2
file_put_contents(
    "file.txt",
    "1. William Smith, 1990, 2344455666677\n".
    "2. John Doe, 1988, 4445556666787\n".
    "3. Michael Brown, 1991, 7748956996777\n".
    "4. David Johnson, 1987, 5556667779999\n".
    "5. Ivan Ivanov, 1992, 99933456678888\n"
);
file_put_contents("file.txt", "6. Ivan Mihailov, 1993, 234234326678888\n"
."7. Ivan Sergeev, 1994, 43243278832488\n"
."8. Ivan Alexandrov, 1995, 543534345678888\n"
, FILE_APPEND);

$file_contents = file_get_contents("file.txt");
if (!$file_contents) {
    echo("Не был найден файл для чтения данных!");
} else {
    ?>
    <div>Данные из файла: </div>
    <?php
    $lines = explode("\n", $file_contents);
    foreach ($lines as $line) {
        echo $line . "<br/>";
    }
}
?>
