<?php

declare(strict_types=1);

namespace App\Puzzles\Year2024\Days;

use App\Contracts\Day;

readonly class Day01 extends Day
{
    public function solvePartOne(array $input, bool $test = false): string
    {
        $leftList = [];
        $rightList = [];
        foreach ($input as $key => $value) {
            $splitValue = explode('   ', $value);
            $leftList[] = (int)$splitValue[0];
            $rightList[] = (int)$splitValue[1];
        }

        sort($leftList);
        sort($rightList);

        $totalDistance = 0;
        for ($i = 0; $i < count($leftList); $i++) {
            $totalDistance += abs($leftList[$i] - $rightList[$i]);
        }

        return (string)$totalDistance;

    }

    public function solvePartTwo(array $input, bool $test = false): string
    {
        $leftList = [];
        $rightList = [];
        foreach ($input as $key => $value) {
            $splitValue = explode('   ', $value);
            $leftList[] = (int)$splitValue[0];

            $rightKey = (int)$splitValue[1];
            if (!array_key_exists($rightKey, $rightList)) {
                $rightList[$rightKey] = 0;
            }

            $rightList[$rightKey]++;
        }

        $sum = 0;
        foreach ($leftList as $key => $value) {
            $count = 0;
            if (array_key_exists($value, $rightList)) {
                $count = $rightList[$value];
            }

            $sum += ($value * $count);
        }

        return (string)$sum;
    }
}
