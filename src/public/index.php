<?php

use App\PuzzleSolver;

require_once __DIR__ ."/../vendor/autoload.php";

$requestUri = $_SERVER['REQUEST_URI'];
if ($requestUri === '/') {
    echo '<h1>All Puzzles</h1>';
    echo '<ul>';
    for ($i = 1; $i <= 25; $i++) {
        for ($j = 1; $j <= 2; $j++) {
            $day = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            $part = str_pad((string)$j, 2, '0', STR_PAD_LEFT);
            echo "<li><a href='/day/{$day}/part/{$part}'>Day {$day} Part {$part}</a></li>";
        }
    }
    echo '</ul>';
    exit;
}

$pattern = '/^\/day\/(?<day>[0-9]{2})\/part\/(?<part>[0-9]{2})$/';
preg_match($pattern, $requestUri, $matches);

$puzzleSolver = new PuzzleSolver();
try {
    $day = $puzzleSolver->loadPuzzle($matches['day'], $matches['part']);
} catch (\App\Exceptions\PuzzleNotFoundException $e) {
    http_response_code(404);
    echo "<h1>404</h1>";
    echo "<h2>{$e->getMessage()}</h2>";
    echo "<p>Go back to the <a href='/'>puzzle overview</a></p>";
    exit;
}

echo '<h1>Day '.$day->getDay().' Part '.$day->getPart().'</h1>';
echo '<h2>Test</h2>';
$day->solveTest();
echo '<h2>Your Solution</h2>';
$day->solve();
echo "<p>Go back to the <a href='/'>puzzle overview</a></p>";