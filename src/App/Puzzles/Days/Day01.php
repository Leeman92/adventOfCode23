<?php

declare(strict_types=1);

namespace App\Puzzles\Days;

use App\Contracts\Day;

readonly class Day01 extends Day
{
    public function partOne(): string
    {
        $filteredInput = $this->filterPartOneInput($this->puzzleInput);
        return (string) array_sum($filteredInput);
    }

    public function partTwo(): string
    {
        $filteredInput = $this->filterPartTwoInput($this->puzzleInput);
        return (string) array_sum($filteredInput);
    }

    public function testOne(): string
    {
        $filteredInput = $this->filterPartOneInput($this->testInput);
        return (string) array_sum($filteredInput);
    }

    public function testTwo(): string
    {
        $filteredInput = $this->filterPartTwoInput($this->testInput);
        return (string) array_sum($filteredInput);
    }

    protected function filterPartOneInput(array $input): array
    {
        $filteredInput[] = '';
        foreach ($input as $key => $line) {
            $line = str_split($line);
            foreach ($line as $char) {
                if (!is_numeric($char)) {
                    continue;
                }
                if (!array_key_exists($key, $filteredInput)) {
                    $filteredInput[$key] = '';
                }
                $filteredInput[$key] .= $char;
            }
        }
        unset($key, $line, $char);

        foreach ($filteredInput as $key => $value) {
            if (strlen($value) === 2) {
                continue;
            }

            if (strlen($value) === 1) {
                $filteredInput[$key] = $value . $value;
                continue;
            }

            $splitValue = str_split($value);
            $filteredInput[$key] = reset($splitValue) . end($splitValue);
        }

        return $filteredInput;
    }

    protected function filterPartTwoInput(array $input): array
    {
        $filteredInput[] = '';

        /*
         *  Reason for this sort of replacement is, that the letters can be merged
         * eightwo is 82 .. however if I just replace two then I have eigh2 and thus
         * eight no longer matches. So I replace it with first and last letter aswell
         */
        $numericValues = [
            'one' => "o1e",
            'two' => "t2o",
            'three' => "t3e",
            'four' => "f4r",
            'five' => "f5e",
            'six' => "s6x",
            'seven' => "s7n",
            'eight' => "e8t",
            'nine' => "n9e",
            'zero' => "z0o",
        ];

        foreach ($input as $key => $line) {
            foreach ($numericValues as $numericValue => $value) {
                $line = str_replace($numericValue, $value, $line);
            }

            $filteredInput[$key] = $line;
        }

        return $this->filterPartOneInput($filteredInput);
    }
}
