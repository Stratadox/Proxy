<?php declare(strict_types=1);

namespace Stratadox\Proxy\When;

use Stratadox\Specification\Contract\Satisfiable;

/**
 * When\KeysMatch. Constraint to check if the known data matches with any set of
 * key/value pairs in a list of such sets.
 *
 * @author Stratadox
 */
final class KeysMatch implements Satisfiable
{
    private $canMatchWith;

    private function __construct(array ...$canMatchWith)
    {
        $this->canMatchWith = $canMatchWith;
    }

    /**
     * Produces a constraint that is satisfied with data that contains all the
     * key/value pairs in one of the given key/value pair sets.
     *
     * @param array $canMatchWith The key/value pair sets.
     * @return Satisfiable        The constraint.
     */
    public static function withEitherOf(array ...$canMatchWith): Satisfiable
    {
        return new self(...$canMatchWith);
    }

    /** @inheritdoc */
    public function isSatisfiedBy($knownData): bool
    {
        foreach ($this->canMatchWith as $set) {
            if ($this->matches($knownData, $set)) {
                return true;
            }
        }
        return false;
    }

    private function matches(array $knownData, array $set): bool
    {
        foreach ($set as $key => $value) {
            if (($knownData[$key] ?? null) !== $value) {
                return false;
            }
        }
        return true;
    }
}
