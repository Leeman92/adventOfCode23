<?php

declare(strict_types=1);

namespace App\Entities\NodeList;

readonly class Node
{
    public string $name;
    public string $leftChildNode;
    public string $rightChildNode;

    public function __construct(array $nodeInput)
    {
        $this->parseNodeInput($nodeInput);
    }

    protected function parseNodeInput(array $nodeInput): void
    {
        $this->name = $nodeInput['name'];
        $this->leftChildNode = $nodeInput['left'];
        $this->rightChildNode = $nodeInput['right'];
    }
}
