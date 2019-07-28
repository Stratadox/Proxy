<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use Stratadox\Specification\Contract\Satisfiable;

final class Only implements Satisfiable
{
    private $expectedData;

    private function __construct(array $expectedData)
    {
        $this->expectedData = $expectedData;
    }

    public static function when(array $expectedData): self
    {
        return new self($expectedData);
    }

    public function isSatisfiedBy($input): bool
    {
        return $input === $this->expectedData;
    }
}
