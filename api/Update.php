<?php

namespace Stratadox\Proxy;

interface Update
{
    /** @throws UpdateFailure */
    public function with(object $instance, array $data): void;
}
