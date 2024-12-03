<?php

use App\PuzzleSolver;

require_once __DIR__ ."/../vendor/autoload.php";

$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = trim($requestUri, "/");
$requestUri = explode("/", $requestUri);
$year = NULL;
$day = NULL;
$part = NULL;

if (array_key_exists(1, $requestUri)) {
    $year = $requestUri[1];
}

if (array_key_exists(3, $requestUri)) {
    $day = $requestUri[3];
}

if (array_key_exists(5, $requestUri)) {
    $part = $requestUri[5];
}

if (is_null($day) || is_null($part)) {
    $day = $part = NULL;
}

if (is_null($year)) {
    echo '<h1>Select your year</h1>';
    echo '<ul>';
    echo "<li><a href='/year/2023'>2023</a></li>";
    echo "<li><a href='/year/2024'>2024</a></li>";
    echo '</ul>';
    exit;
    exit;
}

if (is_null($day) && is_null($part)) {
    echo '<h1>All Puzzles for year '. $year .'</h1>';
    echo '<ul>';
    for ($i = 1; $i <= 25; $i++) {
        for ($j = 1; $j <= 2; $j++) {
            $day = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            $part = str_pad((string)$j, 2, '0', STR_PAD_LEFT);
            echo "<li><a href='/year/{$year}/day/{$day}/part/{$part}'>Day {$day} Part {$part}</a></li>";
        }
    }
    echo '</ul>';
    exit;
}

$puzzleSolver = new PuzzleSolver();
try {
    $day = $puzzleSolver->loadPuzzle($year, $day, $part);
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