<?php declare(strict_types=1);

namespace Stratadox\Proxy;

trait Proxying
{
    /** @var null|static */
    private $instance;
    private $loadCommand;

    public function __construct(LoadCommand $command)
    {
        $this->loadCommand = $command;
    }

    /** @return static */
    private function _load()
    {
        if (null === $this->instance) {
            /** @var Proxying|Proxy $this */
            $this->instance = $this->loadCommand->execute();
        }
        return $this->instance;
    }
}
