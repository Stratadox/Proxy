<?php declare(strict_types=1);

namespace Stratadox\Proxy;

use Stratadox\Specification\Contract\Satisfiable;

/**
 * Maybe. Indicates that this proxy factory is a maybe, it depends on the
 * constraint being satisfied with the known data.
 *
 * @author Stratadox
 */
final class Maybe implements Choice
{
    /** @var ProxyFactory */
    private $factory;
    /** @var Satisfiable */
    private $constraint;

    private function __construct(ProxyFactory $factory, Satisfiable $constraint)
    {
        $this->factory = $factory;
        $this->constraint = $constraint;
    }

    /**
     * Creates a new maybe situation for the proxy factory.
     *
     * @param ProxyFactory $factory    The factory to maybe use.
     * @param Satisfiable  $constraint The constraint that has to be met.
     * @return Choice                  The new maybe factory.
     */
    public static function the(
        ProxyFactory $factory,
        Satisfiable $constraint
    ): Choice {
        return new self($factory, $constraint);
    }

    /** @inheritdoc */
    public function shouldUseFor(array $data): bool
    {
        return $this->constraint->isSatisfiedBy($data);
    }

    /** @inheritdoc */
    public function create(array $knownData = []): Proxy
    {
        return $this->factory->create($knownData);
    }
}
