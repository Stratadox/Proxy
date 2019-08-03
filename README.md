# Proxy

[![Build Status](https://travis-ci.org/Stratadox/Proxy.svg?branch=master)](https://travis-ci.org/Stratadox/Proxy)
[![Coverage Status](https://coveralls.io/repos/github/Stratadox/Proxy/badge.svg?branch=master)](https://coveralls.io/github/Stratadox/Proxy?branch=master)
[![Infection Minimum](https://img.shields.io/badge/msi-100-brightgreen.svg)](https://travis-ci.org/Stratadox/Proxy)
[![PhpStan level](https://img.shields.io/badge/phpstan-7-brightgreen.svg)](https://travis-ci.org/Stratadox/Proxy)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Stratadox/Proxy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Stratadox/Proxy/?branch=master)
[![Maintainability](https://api.codeclimate.com/v1/badges/fee3121902411ce994da/maintainability)](https://codeclimate.com/github/Stratadox/Proxy/maintainability)
[![Latest Stable Version](https://poser.pugx.org/stratadox/proxy/v/stable)](https://packagist.org/packages/stratadox/proxy)
[![License](https://poser.pugx.org/stratadox/proxy/license)](https://packagist.org/packages/stratadox/proxy)

[![Implements](https://img.shields.io/badge/interfaces-github-blue.svg)](https://github.com/Stratadox/ProxyContracts)
[![Latest Stable Version](https://poser.pugx.org/stratadox/proxy-contracts/v/stable)](https://packagist.org/packages/stratadox/proxy-contracts)
[![License](https://poser.pugx.org/stratadox/proxy-contracts/license)](https://packagist.org/packages/stratadox/proxy-contracts)

Virtual proxies, fine-tuned for use in lazy loading.

## Installation

Install using composer:

`composer require stratadox/proxy`

## What is this?

An implementation of the [Virtual Proxy pattern](https://en.wikipedia.org/wiki/Proxy_pattern#Virtual_proxy).
Virtual proxies can take the place of "real" objects. 
They serve as placeholders for objects that are expensive to load.

The proxied objects may have to be retrieved from a database or remote web server.
They may just require loads of memory, or require plenty of other such objects.
When requests need only **some** of these objects, it can cause terrible performance 
problems to load **all** of them.

## Why use this?

Using this package, you can provide your objects with proxies.
These surrogates do not require database queries, and require only little memory.
They satisfy the dependency demands of your class, without the overhead of the
"actual" objects.

## When to use this?

Virtual proxies like these are great for lazily loading the relationships of the
entities in the domain model.

Let's say that you have a Shop. We all hope for the shop to have a lot of Customers.
And for the Customers to place a lot of Orders. The more the better!

However... **loading** *all* those Customers, with *all* their orders, requires a 
lot of memory. Retrieving, organizing and sending the data may take a very long time.

In order to provide the Shop access to any customer, without loading all the 
customers, we can use CustomerProxy objects.

## How does it work?

The [proxies](https://github.com/Stratadox/Proxy#proxies) are subclasses of the 
real entities.
That way, they satisfy all type checks.
Proxies overwrite all public methods of the base class.

When one of these methods is called, the proxy gets loaded.
This triggers the construction of the "expensive" object.
Once loaded, the method that was called on the proxy is now called on the [real object](https://github.com/Stratadox/Proxy#real-object).
All future calls upon the proxy get redirected immediately, without loading.

## How to use?

### Creating a proxy loader
Proxy loaders implement the ProxyLoader interface:
```php
<?php
use Stratadox\Proxy\ProxyLoader;

class MyLoader implements ProxyLoader
{
    private $repository;

    public function __construct(MyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function loadTheInstance(array $data): object
    {
        return $this->repository->byId($data['id']);
    }
}
```

### Making a proxy factory
Producing a basic factory is as simple as this:
```php
<?php
use Stratadox\Proxy\BasicProxyFactory;

$proxyFactory = BasicProxyFactory::for(MyProxy::class, new MyLoader());
```

### Creating a proxy
The proxy should be given the information needed by the [loader](#creating-a-proxy-loader):
```php
<?php
/** @var \Stratadox\Proxy\ProxyFactory $proxyFactory */
$proxyFactory->create(['id' => 1]);
```

### Collections with items of differing concrete type
When the concrete type of the proxy class depends on the known data, one can use:
```php
<?php
use Stratadox\Proxy\BasicProxyFactory;
use Stratadox\Proxy\CompositeProxyFactory;

// making the factory:
$proxyFactory = CompositeProxyFactory::decidingBy('type', [
    'car' => BasicProxyFactory::for(CarProxy::class, $loader),
    'painting' => BasicProxyFactory::for(PaintingProxy::class, $loader),
]);

// creating the proxies:
$carProxy = $proxyFactory->create(['type' => 'car', 'id' => 1]);
$paintingProxy = $proxyFactory->create(['type' => 'painting', 'id' => 5]);
```

## Just proxying

This package only contains the behaviour for the virtual proxies.
Proxy classes themselves are project-specific, and therefore not included.
The proxy implementations simply use the Proxying trait and redirect calls.
Classes for the proxies can be hand-crafted during development or, preferably, 
generated during deployment.

The module is no database, nor is it a data access tool. Client code is supposed 
to provide the mechanism through which the proxied entities are loaded.

## Limitations

In order to be able to make a proxy for a class, the class must:
- Not be declared `final`
- Not have a `constructor` that is declared `final`
- Not access private properties of other objects*
- Not be compared by reference**

*for example, although normally valid, this would **not** work with proxies:
```php
<?php
class Foo {
    private $foo;
    public function __construct(string $foo) {
        $this->foo = $foo;
    }
    public function isEqual(Foo $other): bool {
        return $this->foo === $other->foo;
    }
}
```
**for example, although this would otherwise work, **not** so with proxies:
```php
<?php
class Foo {
    private $foo;
    public function __construct(string $foo) {
        $this->foo = $foo;
    }
    public function isEqual(Foo $other): bool {
        return $this == $other;
    }
}
```

Instead, compare other (potentially proxied) instances through their public 
interface:
```php
<?php
class Foo {
    private $foo;
    public function __construct(string $foo) {
        $this->foo = $foo;
    }
    public function foo(): string {
        return $this->foo;
    }
    public function isEqual(Foo $other): bool {
        return $this->foo() === $other->foo();
    }
}
```

## Glossary

### Proxies
The placeholder or surrogate for the "real" object.

### Real object
The expensive-to-load object that might eventually take the place of the proxy.

## Class Diagram

[![Class Diagram](https://upload.wikimedia.org/wikipedia/commons/thumb/7/75/Proxy_pattern_diagram.svg/439px-Proxy_pattern_diagram.svg.png)](https://en.wikipedia.org/wiki/Proxy_pattern#Structure)
