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
