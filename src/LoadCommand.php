<?php declare(strict_types=1);

namespace Stratadox\Proxy;

class LoadCommand
{
    private $loader;
    private $data;

    public function __construct(ProxyLoader $loader, array $data)
    {
        $this->loader = $loader;
        $this->data = $data;
    }

    public function execute(): object
    {
        return $this->loader->loadTheInstance($this->data);
    }
}
