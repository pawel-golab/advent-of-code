<?php

/**
 * THE BIGGEST CATCH?
 * RANGE 1-11 DOESN'T COUNT - "ID is invalid if it is made only of some sequence of digits repeated **at least** twice"
 */

/**
 * @return int[]
 * returns biggest divisor (different than the number itself)
 * it helps to choose how to divide numbers,
 * 
 * firstly it finds smallest divisor and then divides number by it, ie. 6 -> smallest divisor is 2, 6/2 = 3
 * 123      -> 1 2 3 only
 * 1234     -> 1 2 3 4 and 12 34
 * 123456   -> 1 2 3 4 5 6 and 12 34 56 and 123 456
 */
function getDivisors(int $num) {
    $divisors = [1];

    for ($i = 2; $i <= sqrt($num); $i++)
        if (! ($num % $i))
            array_push($divisors, $i, $num / $i);

    return $divisors;
}

$ranges = explode(',', file('input2.txt', FILE_IGNORE_NEW_LINES)[0]);

$sum = 0;

// range by range
foreach ($ranges as $range) {
    [$start, $end] = explode('-', $range);

    // every number from range
    for ($number = $start; $number <= $end; $number++)
    {
        $len = strlen($number);

        // PART ONE

        // if ($len % 2) continue;
        // [$leftHalf, $rightHalf] = str_split($number, $len/2);
        // $sum += $leftHalf == $rightHalf ? $number : 0;

        // PART TWO
        if ($len == 1) continue;

        // dividing number to combination of equal parts
        foreach (getDivisors($len) as $divisors) {
            // split to equal parts with length of divisors (ie. 12 -> 1, 2, 3, 4, 6 BUT NOT 12 -> 12 = only 1 part)
            $parts = str_split($number, $divisors);


            // array unique removes all duplicates from array, if only 1 element has left - all were the same
            if (count(array_unique($parts)) == 1) {
                $sum += $number;
                break 1;
            }

            // else {
            //     var_export($parts); }
        }}
}

echo $sum;

// 52316131093
// 69564213338
// 69564213338 too high
