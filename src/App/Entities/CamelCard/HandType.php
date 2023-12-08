<?php

declare(strict_types=1);

namespace App\Entities\CamelCard;

enum HandType: int
{
    case FiveOfKind = 7;
    case FourOfKind = 6;

    case FullHouse = 5;

    case ThreeOfKind = 4;

    case TwoPair = 3;

    case OnePair = 2;

    case HighCard = 1;
}
