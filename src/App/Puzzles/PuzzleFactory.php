<?php

declare(strict_types=1);

namespace App\Puzzles;

use App\Contracts\Day;
use App\Exceptions\PuzzleNotFoundException;

class PuzzleFactory
{
    public function __construct() {}

    public static function createPuzzle(string $day, string $part): Day
    {
        $potentialClassName = 'App\\Puzzles\\Days\\Day'.$day;
        if (!class_exists($potentialClassName)) {
            throw new PuzzleNotFoundException("Puzzle not found for day {$day}");
        }

        $puzzleInputFile = __DIR__.'/../../resources/puzzles/'.$day.'-'.$part.'.txt';
        $puzzleInputTestFile = __DIR__.'/../../resources/puzzles/tests/'.$day.'-'.$part.'.txt';

        $puzzleContent = NULL;
        $testContent = NULL;
        if (is_file($puzzleInputFile)) {
            $puzzleContent = file_get_contents($puzzleInputFile);
            $puzzleContent = explode("\r\n", $puzzleContent);
        }

        if (is_file($puzzleInputTestFile)) {
            $testContent = file_get_contents($puzzleInputTestFile);
            $testContent = explode("\r\n", $testContent);
        }

        if ($puzzleContent === NULL && $testContent === NULL) {
            throw new PuzzleNotFoundException("Puzzle Part {$part} not found for day {$day}");
        }


        return new $potentialClassName($puzzleContent, $testContent, $day, $part);
    }
}
