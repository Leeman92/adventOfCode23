<?php

declare(strict_types=1);

namespace App;

use App\Contracts\Day;
use App\Puzzles\PuzzleFactory;

readonly class PuzzleSolver
{
    public function __construct() {}

    public function loadPuzzle(string $year, string $day, string $part): Day
    {
        return PuzzleFactory::createPuzzle($year, $day, $part);
    }
}
