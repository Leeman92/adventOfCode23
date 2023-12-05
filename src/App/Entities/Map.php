<?php

namespace App\Entities;

class Map
{
    protected array $destination;
    public function __construct()
    {
        $this->destination = [];
    }

    public function addDefinition(string $definition): void
    {
        $definitionArray = explode(' ', $definition);
        $definitionArray = array_map(fn($value) => (int) $value, $definitionArray);
        if (count($definitionArray) !== 3) {
            throw new \Exception('Invalid definition');
        }

        $this->destination[] = [
            'range' => $definitionArray[2],
            'startValue' => $definitionArray[0],
            'startLookup' => $definitionArray[1],
            'endLookup' => $definitionArray[1] + $definitionArray[2] - 1,
        ];
    }

    public function lookup(int $lookup): int
    {
        foreach ($this->destination as $map) {
            if ($lookup >= $map['startLookup'] && $lookup <= $map['endLookup']) {
                return $map['startValue'] + ($lookup - $map['startLookup']);
            }
        }

        return $lookup;
    }
}