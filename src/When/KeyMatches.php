<?php declare(strict_types=1);

namespace Stratadox\Proxy\When;

use Stratadox\Specification\Contract\Satisfiable;

/**
 * When\KeyMatches.
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

    public static function with(string $key, $value): Satisfiable
    {
        return new self($key, $value);
    }

    public function isSatisfiedBy($knownData): bool
    {
        return ($knownData[$this->key] ?? null) === $this->value;
    }
}
