<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Infrastructure\Simple;

use Stratadox\Proxy\ProxyLoader;
use Stratadox\Proxy\Test\Domain\Simple\SimpleEntity;

final class SuperSimpleLoader implements ProxyLoader
{
    public function loadTheInstance(array $data): object
    {
        return SimpleEntity::withIdAndAttribute('foo', 'bar');
    }
}
