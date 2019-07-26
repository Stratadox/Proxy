<?php

namespace Stratadox\Proxy;

interface ReferenceUpdater
{
    public function schedule(PropertyUpdate $update): void;
}
