<?php

declare(strict_types=1);

namespace Stratadox\Proxy\Test\Bar;

class Bar
{
    private $madeBy;
    private $inProperty;

    public function __construct($madeBy, string $inProperty)
    {
        $this->madeBy = $madeBy;
        $this->inProperty = $inProperty;
    }

    public function madeBy()
    {
        return $this->madeBy;
    }

    public function inProperty() : string
    {
        return $this->inProperty;
    }
}
