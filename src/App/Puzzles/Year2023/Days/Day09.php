<?php

declare(strict_types=1);

namespace App\Puzzles\Year2023\Days;

use App\Contracts\Day;
use App\Entities\SequenceSolver;

readonly class Day09 extends Day
{
    #[\Override]
    public function solvePartOne(array $input): string
    {
        $sequenceSolver = new SequenceSolver($input);

        return $sequenceSolver->solve();
    }

    #[\Override]
    public function solvePartTwo(array $input): string
    {
        $sequenceSolver = new SequenceSolver($input);

        return $sequenceSolver->solve(true);
    }
}
