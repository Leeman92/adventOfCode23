<?php

declare(strict_types=1);

namespace App\Puzzles\Days;

use App\Contracts\Day;
use App\Entities\Race;

readonly class Day06 extends Day
{
    #[\Override]
    public function solvePartOne(array $input): string
    {
        $race = new Race($input);

        return $race->solve();
    }

    #[\Override]
    public function solvePartTwo(array $input): string
    {
        $race = new Race($input);

        return $race->solveRealRace();
    }
}
