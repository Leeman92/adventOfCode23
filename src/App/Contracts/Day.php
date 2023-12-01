<?php

declare(strict_types=1);

namespace App\Contracts;

abstract class Day
{
    public function __construct(protected array $puzzleInput, protected array $testInput, protected string $day, protected string $part)
    {
    }

    public function solve(): void
    {
        if ($this->part === '01') {
            echo $this->partOne();
        } elseif ($this->part === '02') {
            echo $this->partTwo();
        } else {
            throw new \RuntimeException('Invalid part');
        }
    }

    public function solveTest(): void
    {
        if ($this->part === '01') {
            echo $this->testOne();
        } elseif ($this->part === '02') {
            echo $this->testTwo();
        } else {
            throw new \RuntimeException('Invalid part');
        }
    }

    abstract public function partOne(): string;

    abstract public function partTwo(): string;

    abstract public function testOne(): string;
    abstract public function testTwo(): string;

    public function getDay(): string
    {
        return $this->day;
    }

    public function getPart(): string
    {
        return $this->part;
    }
}
