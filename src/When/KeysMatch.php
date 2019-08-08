<?php declare(strict_types=1);

namespace Stratadox\Proxy\When;

use Stratadox\Specification\Contract\Satisfiable;

/**
 * When\KeysMatch.
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

    public static function withEitherOf(array ...$canMatchWith): Satisfiable
    {
        return new self(...$canMatchWith);
    }

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
