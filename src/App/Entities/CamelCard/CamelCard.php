<?php

declare(strict_types=1);

namespace App\Entities\CamelCard;

class CamelCard
{
    /**
     * @var Hand[]
     */
    protected array $hands = [];

    public function __construct(array $input)
    {
        $this->parseInput($input);
    }

    protected function parseInput(array $input): void
    {
        foreach ($input as $value) {
            $this->parseLine($value);
        }

    }

    protected function parseLine(string $value)
    {
        $hand = explode(' ', $value);
        $this->hands[] = new Hand($hand);
    }

    public function getSolutionPartOne(): string
    {
        $hands = [];
        foreach ($this->hands as $hand) {
            $handType = $hand->getHandType();
            if (!array_key_exists($handType, $hands)) {
                $hands[$handType] = [];
            }

            $hands[$handType][] = $hand;
        }

        ksort($hands);
        $hands = array_values($hands);

        $rank = 0;
        $winnings = 0;
        foreach ($hands as $hand) {
            if (count($hand) === 1) {
                ++$rank;
                //                var_dump(sprintf('Rank %d * Bid %d', $rank, $hand[0]->getBid()));
                $winnings += $hand[0]->getBid() * $rank;

                continue;
            }
            [$roundWinnings, $rank] = $this->getWinnings($hand, $rank);
            $winnings += $roundWinnings;
        }

        return (string) $winnings;
    }

    protected function getWinnings(array $hands, int $rank): array
    {

        $winnings = 0;
        $cardsChecked = 0;
        $handRanking = [];
        while ($cardsChecked < 4) {
            $lowestCard = 15;
            foreach ($hands as $hand) {
                $card = $hand->getCard($cardsChecked);
                if ($card->getSuit()->value < $lowestCard) {
                    $lowestCard = $card->getSuit()->value;
                }
            }
        }

        return [$winnings, $rank];
    }
}
