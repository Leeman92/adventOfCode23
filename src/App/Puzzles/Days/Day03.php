<?php

namespace App\Puzzles\Days;

use App\Contracts\Day;
use App\Entities\EngineSchematic;
use Override;

readonly class Day03 extends Day
{

    #[Override] public function partOne(): string
    {
        return $this->solvePartOne($this->puzzleInput);
    }

    #[Override] public function partTwo(): string
    {
        return $this->solvePartTwo($this->puzzleInput);
    }

    #[Override] public function testOne(): string
    {
        $solution =  $this->solvePartOne($this->testInput);

        assert($solution === '4361', 'Test one failed: '. $solution);

        return $solution;
    }

    #[Override] public function testTwo(): string
    {
        $solution =  $this->solvePartTwo($this->testInput);

        assert($solution === '467835', 'Test one failed: '. $solution);

        return $solution;
    }

    protected function solvePartOne(array $input): string
    {
        $schematic = new EngineSchematic($input);
        return array_sum($schematic->getNeighbouringNumbers());
    }

    protected function solvePartTwo(array $input): string
    {
        $schematic = new EngineSchematic($input);
        return (string) $schematic->getGearRatio();
    }
}