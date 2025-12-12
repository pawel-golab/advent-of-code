<?php

$file = file(__DIR__ . '/input11.txt', FILE_IGNORE_NEW_LINES);
$graph = [];

foreach ($file as $line) {
    [$key, $values] = explode(': ', $line);
    $graph[$key] = explode(' ', $values);
}

$graph['out'] = [];

                                            // THOSE TWO ARGUMENTS ARE ONLY FOR PART TWO
function dfs($visited, $graph, $current_node, $visitedDac = false, $visitedFft = false) {
                                // THIS PART OF CONDITION IS ONLY FOR PART TWO
    if ($current_node == 'out') {
        return $visitedDac && $visitedFft;
    }

    // PART TWO START:
    if ($current_node == 'dac') $visitedDac = true;
    if ($current_node == 'fft') $visitedFft = true;
    // PART TWO END;

    $count = 0;

    if (!key_exists($current_node, $visited)) {
        array_push($visited, $current_node);

        foreach ($graph[$current_node] as $nei)
            if (!key_exists($current_node, $visited))
                $count += dfs($visited, $graph, $nei, $visitedDac, $visitedFft);
    }

    return $count;
}

echo dfs([], $graph, 'svr'); // standard counting would be when third argument was array_key_first($graph)