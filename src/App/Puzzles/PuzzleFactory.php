<?php

declare(strict_types=1);

namespace App\Puzzles;

use App\Contracts\Day;
use App\Exceptions\PuzzleNotFoundException;

class PuzzleFactory
{
    public function __construct() {}

    public static function createPuzzle(string $year, string $day, string $part): Day
    {
        $year = "Year". $year;
        $potentialClassName = 'App\\Puzzles\\'. $year .'\\Days\\Day'.$day;
        if (!class_exists($potentialClassName)) {
            throw new PuzzleNotFoundException("Puzzle not found for day {$day}");
        }

        $puzzleInputFile = __DIR__.'/../../resources/puzzles/'. $year .'/'.$day.'.txt';
        $puzzleInputTestFile = __DIR__ . '/../../resources/puzzles/'. $year .'/tests/' .$day.'.txt';

        $puzzleContent = null;
        $testContent = null;
        if (is_file($puzzleInputFile)) {
            $puzzleContent = file_get_contents($puzzleInputFile);
            $puzzleContent = explode("\r\n", $puzzleContent);
        }

        if (is_file($puzzleInputTestFile)) {
            $testContent = file_get_contents($puzzleInputTestFile);
            $testContent = explode("\r\n", $testContent);
        }

        if ($puzzleContent === null && $testContent === null) {
            $year = str_replace('Year', '', $year);
            $website = "https://adventofcode.com/{$year}/day/{$day}";
            $input = $website . "/input";
            throw new PuzzleNotFoundException(
                "Puzzle Input not found for day {$day}.<br />Check <a href='{$website}'>here</a><br />and <a href='{$input}'>here</a>"
            );
        }

        return new $potentialClassName($puzzleContent, $testContent, $day, $part);
    }
}
