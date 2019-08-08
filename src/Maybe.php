<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use Stratadox\Specification\Contract\Satisfiable;

/**
 * Maybe.
 *
 * @author Stratadox
 */
final class Maybe implements Choice
{
    private $factory;
    private $constraint;

    private function __construct(ProxyFactory $factory, Satisfiable $constraint)
    {
        $this->factory = $factory;
        $this->constraint = $constraint;
    }

    public static function the(
        ProxyFactory $factory,
        Satisfiable $constraint
    ): Choice {
        return new self($factory, $constraint);
    }

    public function shouldUseFor(array $data): bool
    {
        return $this->constraint->isSatisfiedBy($data);
    }

    public function create(array $knownData = []): Proxy
    {
        return $this->factory->create($knownData);
    }
}
