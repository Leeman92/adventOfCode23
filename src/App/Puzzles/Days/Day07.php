<?php

declare(strict_types=1);

namespace App\Puzzles\Days;

use App\Contracts\Day;
use App\Entities\CamelCard\CamelCard;

readonly class Day07 extends Day
{
    #[\Override]
    public function solvePartOne(array $input): string
    {
        $camelCard = new CamelCard($input);
        $solution = $camelCard->getSolutionPartOne();

        if ($this->testInput === $input) {
            assert($solution === '6440', 'Wrong solution. Expected 6440 got '.$solution);
        }

        return $solution;
    }

    #[\Override]
    public function solvePartTwo(array $input): string
    {
        return '0';
    }
}
