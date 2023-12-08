<?php

declare(strict_types=1);

namespace App\Entities\CamelCard;

class Card
{
    protected Suit $suit;

    public function __construct(string $card)
    {
        if (preg_match('/[2-9]/', $card)) {
            $this->suit = Suit::tryFrom((int) $card);
        } else {
            switch ($card) {
                case 'T':
                    $card = 10;

                    break;
                case 'J':
                    $card = 11;

                    break;
                case 'Q':
                    $card = 12;

                    break;
                case 'K':
                    $card = 13;

                    break;
                case 'A':
                    $card = 14;

                    break;
            }
            $this->suit = Suit::tryFrom($card);
        }
    }

    public function getSuit(): Suit
    {
        return $this->suit;
    }
}
