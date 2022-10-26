<?php

declare(strict_types=1);

namespace SmartAssert\ArrayInspector\Tests\Model;

class Model
{
    public function __construct(
        public readonly string $title,
        public readonly int $index,
    ) {
    }
}
