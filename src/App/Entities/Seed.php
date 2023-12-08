<?php

declare(strict_types=1);

namespace App\Entities;

class Seed
{
    public function __construct(public int $seed, public int $soil, public int $fertilizer, public int $water, public int $light, public int $temperature, public int $humidity, public int $location) {}
}
