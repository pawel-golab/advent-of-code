<?php

$lines = array_map(
    fn ($el) => explode(',', $el),
    file(__DIR__ . '/input9.txt', FILE_IGNORE_NEW_LINES)
);
$len = count($lines);

// isn't bruteforce just the best solution here? Sorry, but writing O(m*n) solutions is sooo fast here ;p

$biggestArea = 0;

foreach ($lines as $key => $line) {
    for ($i = 0; $i < $len; $i++) {
        if ($key == $i)
            continue;

        // part two
        if ($line[0] != )
        $area = abs(($line[0] - $lines[$i][0] + 1) * ($line[1] - $lines[$i][1] + 1));

        if ($area > $biggestArea)
            $biggestArea = $area;
    }
}

// 338423001 to low

echo $biggestArea;