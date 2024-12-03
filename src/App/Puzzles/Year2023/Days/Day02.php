<?php

declare(strict_types=1);

namespace App\Puzzles\Year2023\Days;

use App\Contracts\Day;
use App\Entities\Game;

readonly class Day02 extends Day
{
    public function solvePartOne(array $input): string
    {
        $limits = [12, 13, 14];
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

    public function solvePartTwo(array $input): string
    {
        $limits = [12, 13, 14];
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
     * The structure of the string is Game {id} and then a mixture of colors and amounts.
     *
     * @param mixed $game
     *
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
            'colors' => explode('; ', $game[1]),
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
