<?php

namespace App\Puzzles\Year2024\Days;

use App\Contracts\Day;

readonly class Day03 extends Day
{
    protected string $pattern;
    protected string $cleanupPattern;

    public function __construct(array $puzzleInput, array $testInput, string $day, string $part)
    {
        parent::__construct($puzzleInput, $testInput, $day, $part);

        $this->pattern = "/.*?(mul\((\d{1,3}),(\d{1,3})\)).*?/";
        $this->cleanupPattern = '/(don\'t\(\).*?do\(\))/';
    }

    public function solvePartOne(array $input, bool $test = false): string
    {
        return (string) $this->sumUpLine($input[0]);
    }

    public function solvePartTwo(array $input, bool $test = false): string
    {
        $line = $input[0];
        $newLine = preg_replace($this->cleanupPattern, '', $line);

        return (string)$this->sumUpLine($newLine);
    }

    protected function mul(int $a, int $b): int
    {
        return $a * $b;
    }

    protected function sumUpLine(string $line): string
    {
        $matches = [];
        preg_match_all($this->pattern, $line, $matches);
        if (count($matches) !== 4) {
            return "Input isn't parsed properly";
        }


        $firstParams = $matches[2];
        $secondParams = $matches[3];

        if (count($firstParams) !== count($secondParams)) {
            return "Input isn't parsed properly";
        }

        $sum = 0;
        for ($i = 0; $i < count($firstParams); $i++) {
            $sum += $this->mul($firstParams[$i], $secondParams[$i]);
        }

        return $sum;
    }
}