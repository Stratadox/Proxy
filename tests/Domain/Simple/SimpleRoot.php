<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Domain\Simple;

class SimpleRoot
{
    private $id;
    private $entity;

    public function __construct(string $id, SimpleEntity $entity)
    {
        $this->id = $id;
        $this->entity = $entity;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function value(): SimpleValue
    {
        return $this->entity->attribute();
    }
}
