<?php

namespace App\Entities;

class Game
{
    protected int $blueCubes = 0;
    protected int $redCubes = 0;
    protected int $greenCubes = 0;

    protected int $maxGreenCubes = 0;
    protected int $maxBlueCubes = 0;
    protected int $maxRedCubes = 0;
    protected int $id;

    protected bool $possible = true;

    public function add(string $color, int $amount): void
    {
        $this->{$color . 'Cubes'} = $amount;
        if ($this->{$color.'Cubes'} > $this->{'max' . ucfirst($color) . 'Cubes'}) {
            $this->{'max' . ucfirst($color) . 'Cubes'} = $amount;
        }
    }

    public function getPower(): int
    {
        return $this->maxRedCubes * $this->maxGreenCubes * $this->maxBlueCubes;
    }

    public function isPossible(int $maxAmountRed, int $maxAmountGreen, int $maxAmountBlue): bool
    {
        return $this->redCubes <= $maxAmountRed
            && $this->greenCubes <= $maxAmountGreen
            && $this->blueCubes <= $maxAmountBlue;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function reset(): void
    {
        $this->redCubes = 0;
        $this->greenCubes = 0;
        $this->blueCubes = 0;
    }

    public function setPossible(bool $possible): void
    {
        $this->possible = $possible;
    }

    public function getPossible(): bool
    {
        return $this->possible;
    }
}