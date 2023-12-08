<?php

declare(strict_types=1);

namespace App\Entities;

class ScratchCard
{
    protected array $winningNumbers;
    protected array $scratchedNumbers;
    protected int $amountOfWinningNumbers;

    public function __construct(string $cardInfo)
    {
        $this->parseCardInfo($cardInfo);
        $this->amountOfWinningNumbers = 0;
    }

    public function getPoints(): int
    {
        if ($this->amountOfWinningNumbers === 0) {
            return 0;
        }

        return 2 ** ($this->amountOfWinningNumbers - 1);
    }

    public function scratch(): void
    {
        foreach ($this->winningNumbers as $winningNumber) {
            foreach ($this->scratchedNumbers as $scratchedNumber) {
                if ($winningNumber !== $scratchedNumber) {
                    continue;
                }

                ++$this->amountOfWinningNumbers;

                break;
            }
        }
    }

    protected function parseCardInfo(string $cardInfo): void
    {
        $cardInfo = preg_replace('/Card\s+\d+: /', '', $cardInfo);
        /* @var array $numbers */
        $numbers = explode(' | ', $cardInfo);

        foreach ($numbers as $key => $number) {
            $numbers[$key] = explode(' ', $number);
            $numbers[$key] = array_filter($numbers[$key]);
            $numbers[$key] = array_values($numbers[$key]);
            $numbers[$key] = array_map('intval', $numbers[$key]);
        }

        $this->winningNumbers = reset($numbers);
        $this->scratchedNumbers = end($numbers);
    }

    public function getWinningAmount(): int
    {
        return $this->amountOfWinningNumbers;
    }
}
