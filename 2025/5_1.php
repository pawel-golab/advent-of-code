<?php

/** 5_1.php is about database, inserting etc. and 5_2.php is about searching for fresh ingridients */

/**
 * First thing first - store IDs as two indexed columns (id_start and id_end) or one (and loop through all), because ranges may overlap it'll be definetelly one column (with "ignore on duplicate").
 * At what is the best tool for looking for values - DB of course.
 * But then I looked at range sizes - they where to big for range() function and for concatenation, doing ->prepare('insert ...') and ->begintransaction before loop and inserting values in loop was taking to long
 * So change of plans - doing  
 */

/** CODE */

// pdo_sqlite should be turned on by default, but it wasn't on my device, so i run `php --ini`, went to the file and uncommented ";extension=pdo_sqlite" 
if (!extension_loaded('pdo_sqlite')) {
    die("Uncomment extension=pdo_sqlite in php.ini");
}

$lines = file('input5_1.txt', FILE_IGNORE_NEW_LINES);

$pdo = new PDO('sqlite:_5.sqlite');

/** create table of fresh ingridients ids */
$pdo->exec('CREATE TABLE IF NOT EXISTS ingridients (id INTEGER PRIMARY KEY AUTOINCREMENT, start INTEGER, end INTEGER);');
$pdo->exec('CREATE INDEX IF NOT EXISTS idx_start ON ingridients(start);');
$pdo->exec('CREATE INDEX IF NOT EXISTS idx_end ON ingridients(end);');

/** delete existing data */
$delete = $pdo->prepare('DELETE FROM ingridients');
$delete = $pdo->prepare('DELETE FROM sqlite_sequence');

/** query for searching for overlapping values */
$select = $pdo->prepare('SELECT id, start, end FROM ingridients WHERE ? BETWEEN start AND end OR ? BETWEEN start AND end;');
/** query for inserting values */
$insert = $pdo->prepare('INSERT INTO ingridients (start, end) VALUES (?, ?)');
/** query for updating when overlapping ocures */
$delete = $pdo->prepare('DELETE FROM ingridients WHERE id IN (?)');

try {
    $pdo->beginTransaction();
    /** every id RANGE */
    foreach ($lines as $line)
    {
        $pair = [$start, $end] = explode('-', $line);

        $select->execute($pair);
        $res = $select->fetchAll();

        // overlapped ranges
        if ($res)
        {
            /** NEW pair of start and end*/
            $pair = array_reduce($res, 'startEndSet', [$start, $end]);
            /** ids to delete */
            $ids = array_column($res, 'id');

            // "debugging"
            // echo sprintf(
            //     "\e[31m%s \e[0m- \e[31m%s\e[0m\t overlaps with ids: \e[33m%s\e[0m\tand becomes:\n\e[92m%s \e[0m- \e[92m%s\n\n",
            //     number_format($start),
            //     number_format($end),
            //     implode(', ', $ids),
            //     number_format($pair[0]),
            //     number_format($pair[1])
            // );

            foreach ($ids as $id) $delete->execute([$id]);
        }

        $insert->execute($pair);
    }
    $pdo->commit();
}
catch (\Exception $e) {
    $pdo->rollback();
    throw $e;
}

/** functions reduces array of overlapping ranges rows into two values - start and end of new range */
function startEndSet($carry, $item) {
    return [
        min($carry[0], $item['start']),
        max($carry[1], $item['end'])
    ];
}