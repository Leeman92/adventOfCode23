<?php

namespace App\Entities;

use JetBrains\PhpStorm\NoReturn;

class Almanac
{
    protected array $initialSeeds = [];
    protected string $currentMap = '';
    /**
     * @var Map[]
     */
    protected array $maps = [];

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

    #[NoReturn] protected function parseLine(string $value): void
    {
        if ($value === '') {
            $this->currentMap = '';
            return;
        }

        if (str_contains($value, 'seeds')) {
            $this->parseSeeds($value);
            return;
        }
        if (str_contains($value, ' map:')) {
            $map = str_replace(' map:', '', $value);
            $map = explode('-', $map);
            $this->currentMap = end($map);
            return;
        }

        $this->parseMap($value);
    }

    #[NoReturn] protected function parseSeeds(string $seedLine): void
    {
        $seedPattern = '/^seeds:\s+/';
        $seedLine = preg_replace($seedPattern, '', $seedLine);
        $seedLine = explode(' ', $seedLine);
        $seedLine = array_map(fn($seed) => (int) $seed, $seedLine);
        $this->initialSeeds = $seedLine;
    }

    protected function parseMap(string $value): void
    {
        if ($this->currentMap === '') {
            throw new \Exception('No map defined');
        }

        if (!array_key_exists($this->currentMap, $this->maps)) {
            $this->maps[$this->currentMap] = new Map();
        }

        $map = $this->maps[$this->currentMap];
        $map->addDefinition($value);
    }

    public function getSeedInformationPartOne(): array
    {
        $seeds = [];
        foreach ($this->initialSeeds as $seed) {
            $seeds[] = new Seed($seed, ...$this->getSeedInfo($seed));
        }

        return $seeds;
    }

    public function getSeedInformationPartTwo(): int
    {
        return 0;
    }

    protected function getSeedInfo(int $seed): array
    {
        $soil = $this->maps['soil']->lookup($seed);
        $fertilizer = $this->maps['fertilizer']->lookup($soil);
        $water = $this->maps['water']->lookup($fertilizer);
        $Light = $this->maps['light']->lookup($water);
        $temperature = $this->maps['temperature']->lookup($Light);
        $humidity = $this->maps['humidity']->lookup($temperature);
        $location = $this->maps['location']->lookup($humidity);

        return [$soil, $fertilizer, $water, $Light, $temperature, $humidity, $location];
    }
}