# Proxy

[![Build Status](https://travis-ci.org/Stratadox/Proxy.svg?branch=master)](https://travis-ci.org/Stratadox/Proxy)
[![Coverage Status](https://coveralls.io/repos/github/Stratadox/Proxy/badge.svg?branch=master)](https://coveralls.io/github/Stratadox/Proxy?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Stratadox/Proxy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Stratadox/Proxy/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/stratadox/proxy/v/stable)](https://packagist.org/packages/stratadox/proxy)
[![License](https://poser.pugx.org/stratadox/proxy/license)](https://packagist.org/packages/stratadox/proxy)

Virtual proxies, fine-tuned for use in lazy loading.

## Installation

Install using composer:

`composer require stratadox/proxy`

## What is this?

An implementation of the [Virtual Proxy pattern](https://en.wikipedia.org/wiki/Proxy_pattern#Virtual_Proxy).
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

And yet, we want the Shop to have **access** to *all* the Customers, and the
Consumers to *all* their Orders.

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

## There's more, isn't there?

Upon loading, the [owner](https://github.com/Stratadox/Proxy#owner) of the proxy 
is altered. When the owner calls the proxy, the reference to the proxy is changed 
into a reference to the newly loaded entity.
This is done silently, and with a touch of magic. The entity that held the reference
doesn't even need to know that the object ever was a proxy.

If the proxy is placed in an array, the position in the array is updated.
When proxies are contained by [ImmutableCollections](https://github.com/Stratadox/ImmutableCollection),
the reference of the owner to the collection is changed into a reference to a copy
of the container, with the loaded entity in place of the proxy.

Other collection classes can be used as well: any container with ArrayAccess can
be used out-of-the-box. Collection classes that can or will not support array-style
write operations can also be used, but require a custom [updater](https://github.com/Stratadox/ProxyContracts/blob/master/src/UpdatesTheProxyOwner.php)
and [factory](https://github.com/Stratadox/ProxyContracts/blob/master/src/ProducesOwnerUpdaters.php).

## What this is *not*

This package only contains the behaviour for the virtual proxies.
Proxy classes themselves are project-specific, and therefore not included.
The proxy implementations simply use the Proxying trait and redirect calls.
Classes for the proxies can be hand-crafted during development or, preferably, 
generated during deployment.

The module is no database, nor is it a data access tool. Although an abstract Loader 
class is provided, client code is supposed to provide the ProxyFactory with an 
implementation that [loads proxied objects](https://github.com/Stratadox/ProxyContracts/blob/master/src/LoadsProxiedObjects.php)
and a factory that [produces proxy loaders](https://github.com/Stratadox/ProxyContracts/blob/master/src/ProducesProxyLoaders.php).

## Glossary

### Proxies
The placeholder or surrogate for the "real" object.

### Owner
The object that has a reference to the proxy.

### Real object
The expensive-to-load object that might eventually take the place of the proxy.
