<?php

namespace Stratadox\Proxy;

interface ReferenceUpdater
{
    public function schedule(Update $update): void;
}
