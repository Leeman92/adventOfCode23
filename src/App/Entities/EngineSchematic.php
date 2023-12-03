<?php

declare(strict_types=1);

namespace App\Entities;

class EngineSchematic
{
    protected array $mappedSchematic = [];
    protected array $symbolCoordinates = [];
    protected array $alreadyChecked = [];

    public function __construct(array $schema)
    {
        $this->parseSchematic($schema);
    }

    protected function parseSchematic(array $schema): void
    {
        foreach ($schema as $line => $row) {
            $row = str_split($row);
            foreach ($row as $column => $symbol) {
                if ($symbol === '.') {
                    continue;
                }
                if (preg_match('/[0-9]/i', $symbol)) {
                    $this->mappedSchematic[$line][$column] = $symbol;
                } else {
                    $this->symbolCoordinates[$line][$column] = $symbol;
                }
            }
        }
    }

    public function getNeighbouringNumbers(): array
    {
        $neighbouringNumbers = [];
        foreach ($this->symbolCoordinates as $line => $row) {
            foreach ($row as $column => $symbol) {
                $neighbouringNumbers[] = $this->getNeighbouringNumber($line, $column);
            }
        }

        return $neighbouringNumbers;
    }

    protected function getNeighbouringNumber(int|string $line, int|string $column, bool $separate = false): array|int
    {

        $spread = [];
        $sum = 0;
        // Check top-left
        if ($this->hasNumber($line - 1, $column - 1)) {
            $number = $this->getNumber($line - 1, $column - 1);
            if ($separate) {
                $spread[] = $number;
            } else {
                $sum += $number;
            }
        }
        // check top
        if ($this->hasNumber($line - 1, $column)) {
            $number = $this->getNumber($line - 1, $column);
            if ($separate) {
                $spread[] = $number;
            } else {
                $sum += $number;
            }
        }
        // check top-right
        if ($this->hasNumber($line - 1, $column + 1)) {
            $number = $this->getNumber($line - 1, $column + 1);
            if ($separate) {
                $spread[] = $number;
            } else {
                $sum += $number;
            }
        }
        // check right
        if ($this->hasNumber($line, $column + 1)) {
            $number = $this->getNumber($line, $column + 1);
            if ($separate) {
                $spread[] = $number;
            } else {
                $sum += $number;
            }
        }
        // check bottom-right
        if ($this->hasNumber($line + 1, $column + 1)) {
            $number = $this->getNumber($line + 1, $column + 1);
            if ($separate) {
                $spread[] = $number;
            } else {
                $sum += $number;
            }
        }
        // check bottom
        if ($this->hasNumber($line + 1, $column)) {
            $number = $this->getNumber($line + 1, $column);
            if ($separate) {
                $spread[] = $number;
            } else {
                $sum += $number;
            }
        }
        // check bottom-left
        if ($this->hasNumber($line + 1, $column - 1)) {
            $number = $this->getNumber($line + 1, $column - 1);
            if ($separate) {
                $spread[] = $number;
            } else {
                $sum += $number;
            }
        }
        // check left
        if ($this->hasNumber($line, $column - 1)) {
            $number = $this->getNumber($line, $column - 1);
            if ($separate) {
                $spread[] = $number;
            } else {
                $sum += $number;
            }
        }

        if ($separate) {
            return $spread;
        }

        return $sum;
    }

    protected function getNumber(int $line, int $row): int
    {
        // Check all the numbers to the left and right
        $number = [];
        $needleLeft = $row;
        $needleRight = $row;
        while ($this->hasNumber($line, $needleLeft - 1)) {
            --$needleLeft;
            $number[$needleLeft] = $this->mappedSchematic[$line][$needleLeft];
        }

        while ($this->hasNumber($line, $needleRight + 1)) {
            ++$needleRight;
            $number[$needleRight] = $this->mappedSchematic[$line][$needleRight];
        }

        $number[$row] = $this->mappedSchematic[$line][$row];

        ksort($number);
        $result = implode('', $number);

        return (int) $result;
    }

    protected function hasNumber(int $line, int $row): bool
    {
        if (isset($this->alreadyChecked[$line][$row])) {
            // This is to prevent checking the same number twice
            return false;
        }

        if (!isset($this->alreadyChecked[$line])) {
            $this->alreadyChecked[$line] = [];
        }

        $this->alreadyChecked[$line][$row] = true;

        return isset($this->mappedSchematic[$line][$row]);
    }

    public function getGearRatio(): int
    {
        $gears = [];
        foreach ($this->symbolCoordinates as $line => $row) {
            foreach ($row as $column => $symbol) {
                $gears[$line.'|'.$column] = $this->getNeighbouringNumber($line, $column, true);
            }
        }

        $gearRatio = 0;
        foreach ($gears as $ratios) {
            if (count($ratios) !== 2) {
                continue;
            }

            $innerGearRatio = 1;
            foreach ($ratios as $ratio) {
                $innerGearRatio *= $ratio;
            }

            $gearRatio += $innerGearRatio;
        }

        return $gearRatio;
    }
}
