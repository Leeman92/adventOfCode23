<?php

declare(strict_types=1);

namespace App\Entities\CamelCard;

class Hand
{
    /**
     * @var Card[]
     */
    protected array $cards = [];

    protected int $bid;

    public function __construct(array $hand)
    {
        if (count($hand) !== 2) {
            throw new \InvalidArgumentException('A hand must have 2 inputs');
        }

        $cards = reset($hand);
        $this->bid = (int) end($hand);

        if (strlen($cards) !== 5) {
            throw new \InvalidArgumentException('A hand must have 5 cards');
        }

        $cards = str_split($cards);
        foreach ($cards as $card) {
            $this->cards[] = new Card($card);
        }
    }

    public function getHandType(): int|string
    {
        $handType = HandType::HighCard;
        $cards = $this->cards;
        $suits = [];
        foreach ($cards as $card) {
            if (!array_key_exists($card->getSuit()->value, $suits)) {
                $suits[$card->getSuit()->value] = 0;
            }
            ++$suits[$card->getSuit()->value];
        }

        arsort($suits);

        $keys = array_keys($suits);
        if (count($suits) === 1) {
            $handType = HandType::FiveOfKind;
        } elseif (count($suits) === 2) {
            if ($suits[$keys[0]] === 4) {
                $handType = HandType::FourOfKind;
            } elseif ($suits[$keys[0]] === 3) {
                $handType = HandType::FullHouse;
            }
        } elseif (count($suits) === 3) {
            if ($suits[$keys[0]] === 3) {
                $handType = HandType::ThreeOfKind;
            } elseif ($suits[$keys[0]] === 2) {
                $handType = HandType::TwoPair;
            }
        } elseif (count($suits) === 4) {
            if ($suits[$keys[0]] === 2 && $suits[$keys[1]] === 2) {
                $handType = HandType::TwoPair;
            } else {
                $handType = HandType::OnePair;
            }
        }

        return $handType->value;
    }

    public function getBid(): int
    {
        return $this->bid;
    }

    public function getCards(): array
    {
        return $this->cards;
    }
}
