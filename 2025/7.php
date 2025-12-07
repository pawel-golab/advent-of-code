<?php

$lines = file('input7.txt', FILE_IGNORE_NEW_LINES);

    /** second line */
        /** position of S in second line */
$lines[1][strpos($lines[0], 'S')] = '|';        /** | unnder S */

$count = count($lines);
$len = strlen($lines[0]);

$splits = 0;

for ($i = 2; $i < $count; $i++) {
    for ($j = 0; $j < $len; $j++) {
        if ($lines[$i-1][$j] != '|')
            continue;

        if ($lines[$i][$j] == '^') {
            $lines[$i][$j-1] = '|';
            $lines[$i][$j+1] = '|';
            $splits++;
            continue;
        }

        $lines[$i][$j] = '|';
    }
}

echo $splits;