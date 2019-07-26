<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Infrastructure\Simple;

use Stratadox\Proxy\ProxyLoader;

final class InMemorySimpleEntityLoader implements ProxyLoader
{
    private $entityById;

    public function __construct(array $entityById = [])
    {
        $this->entityById = $entityById;
    }

    public function loadTheInstance(array $data): object
    {
        return $this->entityById[$data['id']];
    }
}
