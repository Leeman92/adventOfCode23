<?php

declare(strict_types=1);

namespace App\Puzzles\Days;

use App\Contracts\Day;
use App\Entities\Game;

readonly class Day02 extends Day
{

    public function partOne(): string
    {
        return $this->solvePartOne($this->puzzleInput, [12, 13, 14]);
    }

    public function partTwo(): string
    {
        return $this->solvePartTwo($this->puzzleInput, [12, 13, 14]);
    }

    public function testOne(): string
    {
        $solution = $this->solvePartOne($this->testInput, [12, 13, 14]);
        assert($solution === '8', sprintf('Expected %s to equal %s', $solution, "8"));
        return $solution;
    }

    public function testTwo(): string
    {
        $solution = $this->solvePartTwo($this->testInput, [12, 13, 14]);
        assert($solution === '2286', sprintf('Expected %s to equal %s', $solution, "2286"));
        return $solution;
    }

    /**
     * @param array $input
     * @param array $limits - array of limits in order red, green, blue
     * @return string
     */
    protected function solvePartOne(array $input, array $limits): string
    {
        $games = [];
        foreach ($input as $game) {
            $games[] = $this->parseGame($game, $limits);
        }

        $result = 0;

        foreach ($games as $game) {
            if (!$game->getPossible()) {
                continue;
            }
            $result += $game->getId();
        }
        return (string) $result;
    }

    protected function solvePartTwo(array $input, array $limits): string
    {
        $games = [];
        foreach ($input as $game) {
            $games[] = $this->parseGame($game, $limits);
        }

        $result = 0;

        foreach ($games as $game) {
            $result += $game->getPower();
        }
        return (string) $result;
    }

    /**
     * The structure of the string is Game {id} and then a mixture of colors and amounts
     * @param mixed $game
     * @param array $limits
     * @return ?Game
     */
    protected function parseGame(string $game, array $limits): ?Game
    {
        // Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green -> should be new Game(); game->setId(1);
        // $game->add('blue', 3); $game->add('red', 4); $game->add('red', 1); $game->add('green', 2); $game->add('blue', 6); $game->add('green', 2);
        $game = str_replace('Game ', '', $game);
        $game = explode(': ', $game);
        $game = [
            'id' => $game[0],
            'colors' => explode('; ', $game[1])
        ];
        $gameEntity = new Game();
        $gameEntity->setId((int) $game['id']);
        foreach ($game['colors'] as $round) {
            $color = explode(', ', $round);
            foreach ($color as $key => $value) {
                $colorCubes = explode(' ', $value);
                $gameEntity->add($colorCubes[1], (int) $colorCubes[0]);
            }
            if ($gameEntity->getPossible() && !$gameEntity->isPossible(...$limits)) {
                $gameEntity->setPossible(false);

            }
            $gameEntity->reset();
        }
        return $gameEntity;
    }
}