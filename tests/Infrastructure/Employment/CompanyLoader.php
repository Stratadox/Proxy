<?php declare(strict_types=1);

namespace Stratadox\Proxy\Test\Infrastructure\Employment;

use Stratadox\Proxy\ProxyLoader;
use Stratadox\Proxy\Test\Domain\Employment\Company;

final class CompanyLoader implements ProxyLoader
{
    public function loadTheInstance(array $data): object
    {
        return new Company('ABC', 'Company Name');
    }
}
