<?php

declare(strict_types=1);

namespace App\Puzzles\Year2024\Days;

use App\Contracts\Day;

readonly class Day02 extends Day
{
    public function solvePartOne(array $input, bool $test = false): string
    {
        $counter = 0;
        foreach ($input as $key => $value) {
            if ($this->isListSafe($value)) {
                $counter++;
            }
        }

        return (string) $counter;
    }

    public function solvePartTwo(array $input, bool $test = false): string
    {

        $counter = 0;
        foreach ($input as $key => $value) {
            if ($this->isListSafe($value, true, false)) {
                $counter++;
            }
        }

        return (string) $counter;
    }

    protected function isListSafe(string|array $list, bool $dampenerActive = false, bool $debug = false): bool
    {
        if (is_string($list)) {
            $report = explode(" ", $list);
        } else {
            $report = $list;
        }

        if ($debug) {
            dump("Report -- ", $report);
        }


        $isDecreasing = false;
        if ($report[0] > $report[1]) {
            $isDecreasing = true;
        }

        if ($debug) {
            dump("isDecreasing -- ", $isDecreasing);
        }

        for($i = 0; $i < count($report)-1; $i++) {
            $difference = (int)$report[$i] - (int)$report[$i + 1];
            if (!$isDecreasing) {
                $difference *= -1;
            }
            if ($difference > 0 && $difference <= 3) {
                continue;
            }

            if ($dampenerActive) {
                $clonedReportOne = $report;
                $clonedReportTwo = $report;
                $clonedReportThree = $report;

                unset($clonedReportOne[$i - 1]);
                unset($clonedReportTwo[$i]);
                unset($clonedReportThree[$i + 1]);

                $clonedReportOne = array_values($clonedReportOne);
                $clonedReportTwo = array_values($clonedReportTwo);
                $clonedReportThree = array_values($clonedReportThree);

                return (
                    $this->isListSafe($clonedReportOne, false, $debug) ||
                    $this->isListSafe($clonedReportTwo, false, $debug) ||
                    $this->isListSafe($clonedReportThree, false, $debug)
                );

            }
            return false;
        }
        return true;
    }
}
