<?php

namespace App\Puzzles\Days;

use App\Contracts\Day;
use App\Entities\EngineSchematic;
use Override;

readonly class Day03 extends Day
{

    public function solvePartOne(array $input): string
    {
        $schematic = new EngineSchematic($input);
        return array_sum($schematic->getNeighbouringNumbers());
    }

    public function solvePartTwo(array $input): string
    {
        $schematic = new EngineSchematic($input);
        return (string) $schematic->getGearRatio();
    }
}