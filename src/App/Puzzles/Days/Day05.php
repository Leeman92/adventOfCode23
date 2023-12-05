<?php

namespace App\Puzzles\Days;

use App\Contracts\Day;
use App\Entities\Almanac;

readonly class Day05 extends Day
{

    #[\Override] public function solvePartOne(array $input): string
    {
        $almanac = new Almanac($input);

        $seeds = $almanac->getSeedInformationPartOne();
        $lowestLocation = PHP_INT_MAX;
        foreach ($seeds as $seed) {
            if ($seed->location >= $lowestLocation) {
                continue;
            }
            $lowestLocation = $seed->location;
        }

        return (string) $lowestLocation;
    }

    #[\Override] public function solvePartTwo(array $input): string
    {
        // I don't have a clue as of yet
        return "0";
    }
}