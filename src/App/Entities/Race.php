<?php

namespace App\Entities;

class Race
{

    public int $waysToSolve = 0;

    public array $timePerRace;
    public array $recordPerRace;

    public function __construct(array $input)
    {
        $this->parseInput($input);
    }

    protected function parseInput(array $input): void
    {
        if (count($input) !== 2) {
            throw new \Exception('Invalid input');
        }
        $this->parseTimeAvailable(reset($input));
        $this->parseRecords(end($input));
    }

    protected function parseTimeAvailable(string $timeSheet): void
    {
        $pattern = '/Time:\s+/';
        $timeSheet = preg_replace($pattern, '', $timeSheet);
        $multipleSpaces = '/\s{2,}/';
        $timeSheet = preg_replace($multipleSpaces, ' ', $timeSheet);
        $timeSheet = explode(' ', $timeSheet);
        $timeSheet = array_map(fn($value) => (int) $value, $timeSheet);

        $this->timePerRace = $timeSheet;
    }

    protected function parseRecords(string $recordSheet): void
    {
        $pattern = '/Distance:\s+/';
        $recordSheet = preg_replace($pattern, '', $recordSheet);
        $multipleSpaces = '/\s{2,}/';
        $recordSheet = preg_replace($multipleSpaces, ' ', $recordSheet);
        $recordSheet = explode(' ', $recordSheet);
        $recordSheet = array_map(fn($value) => (int) $value, $recordSheet);
        $this->recordPerRace = $recordSheet;
    }

    public function solve(): string
    {
        $waysToSolve = 1;
        foreach ($this->timePerRace as $key => $time) {
            $recordToBeat = $this->recordPerRace[$key];
            $waysToSolve *= $this->runLap($time, $recordToBeat);

        }

        return (string) $waysToSolve;
    }

    public function solveRealRace()
    {
        $timeForRace = (int) implode('', $this->timePerRace);
        $recordForRace = (int) implode('', $this->recordPerRace);

        return $this->runLap($timeForRace, $recordForRace);
    }

    protected function runLap(mixed $time, mixed $recordToBeat): int
    {
        $lapWins = 0;
        for($i = 1; $i <= floor($time/2); $i++) {
            $factorA = $i;
            $factorB = $time - $i;
            $lapTime = $factorA * $factorB;
            if ($lapTime <= $recordToBeat) {
                continue;
            }
            $lapWins++;
            if ($factorA !== $factorB) {
                $lapWins++;
            }
        }

        return $lapWins;
    }
}