<?php

declare(strict_types=1);

namespace App\Entities\NodeList;

class NodeList
{
    protected array $directions;

    /**
     * @var Node[]
     */
    protected array $nodes;

    /**
     * @var Node[]
     */
    protected array $startNodes;

    public function __construct(array $input, protected bool $secondPart = false, protected bool $testInput = false)
    {
        $this->nodes = [];
        $this->parseInput($input);
    }

    protected function parseInput(array $input): void
    {
        $this->directions = str_split(array_shift($input));
        // Remove empty line
        array_shift($input);
        $nodePattern = '/(?<nodeName>.{3}) = \((?<left>.{3}), (?<right>.{3})\)/';
        foreach ($input as $nodeInput) {
            preg_match($nodePattern, $nodeInput, $matches);
            $node = new Node([
                'name' => $matches['nodeName'],
                'left' => $matches['left'],
                'right' => $matches['right'],
            ]);
            $this->nodes[$node->name] = $node;

            if ($this->secondPart && str_ends_with($matches['nodeName'], 'A')) {
                $this->startNodes[$node->name] = $node;
            }
            if (!$this->secondPart && $node->name === 'AAA') {
                $this->startNodes[$node->name] = $node;
            }
        }
    }

    public function traverseTree(): int
    {
        $totalSteps = [];
        foreach ($this->startNodes as $node) {
            $steps = 0;
            $directionCopy = $this->directions;
            $targetNode = $node;
            while (!str_ends_with($targetNode->name, 'Z')) {
                ++$steps;
                $direction = array_shift($directionCopy);
                if ($direction === 'L') {
                    $targetNode = $this->nodes[$targetNode->leftChildNode];
                } elseif ($direction === 'R') {
                    $targetNode = $this->nodes[$targetNode->rightChildNode];
                }
                $directionCopy[] = $direction;
            }
            $totalSteps[] = $steps;
        }

        $result = [];
        if (count($totalSteps) === 2) {
            $result = (int) gmp_lcm($totalSteps[0], $totalSteps[1]);
        } else {
            for ($i = 0; $i < count($totalSteps) - 1; $i += 2) {
                $result[] = (int) gmp_lcm($totalSteps[$i], $totalSteps[$i + 1]);
            }
            if (count($totalSteps) % 2 === 1) {
                $result[] = $totalSteps[count($totalSteps) - 1];
            }
        }
        if (is_array($result) && count($result) === 3) {
            $result = (int) gmp_lcm($result[0], gmp_lcm($result[1], $result[2]));
        }

        if (is_array($result) && count($result) === 1) {
            return (int) $result[0];
        }

        return (int) $result;
    }
}
