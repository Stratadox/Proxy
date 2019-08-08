<?php declare(strict_types=1);

namespace Stratadox\Proxy\When;

use Stratadox\Specification\Contract\Satisfiable;

/**
 * When\KeyMatches. Constraint to check if the known data contains a particular
 * key/value pair.
 *
 * @author Stratadox
 */
final class KeyMatches implements Satisfiable
{
    private $key;
    private $value;

    private function __construct(string $key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Produces a constraint that is satisfied with data that contains this
     * particular key/value pair.
     *
     * @param string $key   The key to look for.
     * @param mixed  $value The value that is expected.
     * @return Satisfiable  The constraint.
     */
    public static function with(string $key, $value): Satisfiable
    {
        return new self($key, $value);
    }

    /** @inheritdoc */
    public function isSatisfiedBy($knownData): bool
    {
        return ($knownData[$this->key] ?? null) === $this->value;
    }
}
