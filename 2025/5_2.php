<?php
/** 5_1.php is about database, inserting etc. and 5_2.php is about searching for fresh ingridients */

/** CODE FOR PART ONE */

// pdo_sqlite should be turned on by default, but it wasn't on my device, so i run `php --ini`, went to the file and uncommented ";extension=pdo_sqlite" 
if (!extension_loaded('pdo_sqlite')) {
    die("Uncomment extension=pdo_sqlite in php.ini");
}

$lines = file('input5_2.txt', FILE_IGNORE_NEW_LINES);

$pdo = new PDO('sqlite:_5.sqlite');
$select = $pdo->prepare('SELECT 1 FROM ingridients WHERE ? BETWEEN start AND end;');

$sum = 0;

foreach ($lines as $line) {
    $select->execute([$line]);

    if ($select->fetch())
        $sum++;
}

echo $sum , PHP_EOL;

/** CODE FOR PART TOW */

$stmt = $pdo->query('SELECT SUM(end-start+1) FROM ingridients');
var_export($stmt->fetch());