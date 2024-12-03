<?php

declare(strict_types=1);

namespace App\Puzzles\Year2023\Days;

use App\Contracts\Day;
use App\Entities\ScratchCard;

readonly class Day04 extends Day
{
    #[\Override]
    public function solvePartOne(array $input): string
    {
        $scratchCardValues = [];
        foreach ($input as $card) {
            $scatchCard = new ScratchCard($card);
            $scatchCard->scratch();

            $scratchCardValues[] = $scatchCard->getPoints();
        }

        return (string) array_sum($scratchCardValues);
    }

    #[\Override]
    public function solvePartTwo(array $input): string
    {
        $scratchCards = [];
        foreach ($input as $key => $card) {
            $scatchCard = new ScratchCard($card);
            $scatchCard->scratch();

            $scratchCards[$key + 1] = $scatchCard;
        }

        $totalCards = [];

        // Run through every card and add it to the pile.
        // If it is a winner also add the subsequent cards to the pile in the amount of the current winning card
        // i.e. there are 2 cards at index 2. Then count the winning cards twice aswell and so on
        foreach ($scratchCards as $key => $scratchCard) {
            if (!array_key_exists($key, $totalCards)) {
                $totalCards[$key] = 0;
            }

            ++$totalCards[$key];

            if ($scratchCard->getWinningAmount() === 0) {
                continue;
            }

            for ($i = 0; $i < $scratchCard->getWinningAmount(); ++$i) {
                $newKey = $key + $i + 1;
                if (!array_key_exists($newKey, $totalCards)) {
                    $totalCards[$newKey] = 0;
                }

                $totalCards[$newKey] += $totalCards[$key];
            }
        }

        return (string) array_sum($totalCards);
    }
}
