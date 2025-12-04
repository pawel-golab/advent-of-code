<?php

/** EXPLANATION: */
/**
 * I couldm't begin with doing this task at 7:30 CEST, maybe the reason was no coffe - but I couldn't imagine "8 adjacent positions"
 * I was imagining something like that xxxx@xxxx-- but it doesn't have a sense, so yeah, 8 adjacent positions means:
 * 
 * -----###--
 * -----#@#--
 * -----###--
 */

/** CODE: */

$lines = file('input4.txt', FILE_IGNORE_NEW_LINES);

$sum = 0;

$count = count($lines);

foreach ($lines as &$line) $line .= "."; // PHP has negative indices access - "hello"[-1] = "o", so I'm adding . after each line so it'll be picked instead of random "@"

for ($i = 0; $i < $count; $i++)
{
    $len = strlen($lines[$i]);

    // echo "---\n[$i]\n";

    for ($j = 0; $j < $len; $j++) {
        if ($lines[$i][$j] == '.') continue;

        $c = @array_count_values([
            $lines[$i-1][$j-1], $lines[$i-1][$j], $lines[$i-1][$j+1],
            $lines[$i][$j-1], /*8 adjacent pos.*/ $lines[$i][$j+1],
            $lines[$i+1][$j-1], $lines[$i+1][$j], $lines[$i+1][$j+1]
        ]);

        if (($c['@'] ?? 0) < 4){
            $sum ++ ;
            // ONLY PART TWO - START
            $lines[$i][$j] = '.';       // better way would probably be to have two arrays, in second array dots would be set and loop wouldn't be interfered, then second array would be assigned to first. Everythind in do {...} while
            $i = 0; $j = 0;
            // ONLY PART TWO - END
        }
    }
    // echo "\n$sum\n";
}

echo $sum;