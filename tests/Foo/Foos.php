<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test\Foo;

use Stratadox\Collection\Alterable;
use Stratadox\ImmutableCollection\Altering;
use Stratadox\ImmutableCollection\ImmutableCollection;

class Foos extends ImmutableCollection implements Alterable
{
    use Altering;

    public function __construct(Foo ...$foos)
    {
        parent::__construct(...$foos);
    }
}
