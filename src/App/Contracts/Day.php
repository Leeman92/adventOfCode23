<?php

declare(strict_types=1);

namespace App\Contracts;

use RuntimeException;

readonly abstract class Day
{
    public function __construct(protected array $puzzleInput, protected array $testInput, protected string $day, protected string $part)
    {
    }

    public function solve(): void
    {
        if ($this->part === '01') {
            echo $this->solvePartOne($this->puzzleInput);
        } elseif ($this->part === '02') {
            echo $this->solvePartTwo($this->puzzleInput);
        } else {
            throw new RuntimeException('Invalid part');
        }
    }

    public function solveTest(): void
    {
        if ($this->part === '01') {
            echo $this->solvePartOne($this->testInput);
        } elseif ($this->part === '02') {
            echo $this->solvePartTwo($this->testInput);
        } else {
            throw new RuntimeException('Invalid part');
        }
    }

    public function getDay(): string
    {
        return $this->day;
    }

    public function getPart(): string
    {
        return $this->part;
    }

    abstract function solvePartOne(array $input): string;

    abstract function solvePartTwo(array $input): string;
}
