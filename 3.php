<?php

/** EXPLANATION: */
/**
 * After first part I've been thinking to optimize this algorithm to any "Joltage" length.
 * So I thougth "first digit must be in position from 0 to len-n, where len is string length and n is 'Joltage' length, coz other 11 digits must fit" ;)
 * So first number is from 0 to 99-12 = 87
 * second is from 1 to 88
 * ...
 * 12th is from 11 to 99
 * 
 * First digit is easy to find - it's the biggest digit from positions [0] to [87], coz 9xxxxxx will be always bigger than 8xxxxxx etc.
 * I will search for second digit from position immediately after first digit to [88], so:
 * 
 * 1. from [0] to [3]                       (from 0 to 15-12+i) i=0
 * |- - - -| max = 4, position = [2]
 *  2 3 4 2 3 4 2 3 4 2 3 4 2 7 8
 * 
 * 2. from [3] to [4]                       (from previous position+1 to 15-12+i) i=1                 
 *       |- -| max = 3, position = [4]
 *  2 3 4 2 3 4 2 3 4 2 3 4 2 7 8
 * 
 *  3. from [5] to [5]                      (from previous position+1 to 15-12+i) i=2           
 *           |-| max = 4, position = [5]
 *  2 3 4 2 3 4 2 3 4 2 3 4 2 7 8
 * 
 * 4. from [6] to [6]                       (from previous position+1 to 15-12+i) i=3           
 *             |-| max = 2, position = [6]
 *  2 3 4 2 3 4 2 3 4 2 3 4 2 7 8
 * 
 * 5. from [7] to [7] etc.
 */

/** CODE: */

/**
 * Function finds biggest joltage
 * @param string $line - checked line of file
 * @param int $size - size (length) of joltage (in 2025 day 3 it's 2 and 12)
 * @return string - biggest possible joltage
 */
function maxJoltage(string $line, int $size = 0): int
{
    $len = strlen($line);

    $biggest = "";

    for ($p = 0, $i = 0; $i < $size; $i++, $p++) {

        $checked = substr($line, $p, $len - $p - $size + $i + 1);

        /* finding the biggest digit */
        $max = max(str_split($checked));

        /** 
         * get the position of the biggest digit
         * (as far as I know there isn't such a function that does both)
         */
        $p += strpos($checked, $max);   // BTW - FOR THE FIRST PART (size=2) IT WORKED BOTH WITH += AND =, 2 DIGITS IN 100 GIDIT NUMBER 

        /**
         * Add the biggest digit to final number
         */
        $biggest .= $max;
    }

    echo "$line\t$biggest\n";

    return (int)$biggest;
}

$lines = file('input3.txt', FILE_IGNORE_NEW_LINES);

$sum = 0;

foreach ($lines as $line) {
    $sum += maxJoltage($line, 12);
}

echo "\n\n$sum";