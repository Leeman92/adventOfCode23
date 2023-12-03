<?php

declare(strict_types=1);

namespace App\Puzzles\Days;

use App\Contracts\Day;
use App\Entities\EngineSchematic;

readonly class Day03 extends Day
{
    public function solvePartOne(array $input): string
    {
        $schematic = new EngineSchematic($input);

        return (string) array_sum($schematic->getNeighbouringNumbers());
    }

    public function solvePartTwo(array $input): string
    {
        $schematic = new EngineSchematic($input);

        return (string) $schematic->getGearRatio();
    }
}
