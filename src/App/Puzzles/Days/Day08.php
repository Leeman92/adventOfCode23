<?php

declare(strict_types=1);

namespace App\Puzzles\Days;

use App\Contracts\Day;
use App\Entities\NodeList\NodeList;

readonly class Day08 extends Day
{
    #[\Override]
    public function solvePartOne(array $input): string
    {
        $nodeList = new NodeList($input);

        return (string) $nodeList->traverseTree();
    }

    #[\Override]
    public function solvePartTwo(array $input): string
    {
        $test = false;
        if ($this->testInput === $input) {
            $test = true;
            $input = [
                'LR',
                '',
                '11A = (11B, XXX)',
                '11B = (XXX, 11Z)',
                '11Z = (11B, XXX)',
                '22A = (22B, XXX)',
                '22B = (22C, 22C)',
                '22C = (22Z, 22Z)',
                '22Z = (22B, 22B)',
                'XXX = (XXX, XXX)',
            ];
        }

        $nodeList = new NodeList($input, true, $test);
        $steps = $nodeList->traverseTree();

        return (string) $steps;
    }
}
