<?php

declare(strict_types=1);

namespace App\Entities;

class SequenceSolver
{
    public function __construct(protected array $input) {}

    public function solve(bool $secondPart = false): string
    {
        $totalSequence = [];
        foreach ($this->input as $line) {
            $totalSequence[] = $this->findNextInSequence($line, $secondPart);
        }

        return (string) array_sum($totalSequence);
    }

    protected function findNextInSequence(string $line, bool $secondPart): int
    {
        $sequence = explode(' ', $line);
        $reversedSequence = array_reverse($sequence);
        $reversedSequence = array_map('intval', $reversedSequence);
        $newSequence = $reversedSequence;
        $createdSequences = [];
        while (!$this->allEqual($newSequence)) {
            $createdSequences[] = $newSequence;
            $tempSequence = [];
            for ($i = 0; $i < (count($newSequence) - 1); ++$i) {
                $tempSequence[] = $newSequence[$i] - $newSequence[$i + 1];
            }
            $newSequence = $tempSequence;
        }

        if (!$secondPart) {
            $addage = reset($newSequence);
        } else {
            $addage = end($newSequence);
        }

        $createdSequences = array_reverse($createdSequences);
        foreach ($createdSequences as $sequence) {
            if ($secondPart) {
                $addage = end($sequence) - $addage;
            } else {
                $addage += reset($sequence);
            }
        }

        return $addage;
    }

    protected function allEqual(array $sequence): bool
    {
        $allEqual = true;
        $first = $sequence[0];
        foreach ($sequence as $number) {
            if ($number !== $first) {
                $allEqual = false;
            }
        }

        return $allEqual;
    }
}
