# Getting started

## Comments

I placed some comments in important places, let's find it in whole project by keyword `@see`.

## Project architecture and structure

Here we have DDD-like layered architecture - [read more](https://vaadin.com/learn/tutorials/ddd/strategic_domain_driven_design).

Patterns were used:
* [Shared kernel](https://vaadin.com/learn/tutorials/ddd/strategic_domain_driven_design#_shared_kernel)
* [Bounded Context](https://3-info.ru/post/10154)
* [Repository](https://github.com/dddinphp/repository-examples)
* [Service](https://lostechies.com/jimmybogard/2008/08/21/services-in-domain-driven-design/)
* [CQRS](https://martinfowler.com/bliki/CQRS.html)

```
.
`-- src/
    |-- <Bounded context/feature name>
    |   |-- Application  <--- CQRS, events, related tp Domain layer
    |   |-- Config  <--- Config for services inside bounded context
    |   |-- Controller  <--- Console and HTTP-controllers, related to Application layer by CQRS
    |   |-- Domain  <--- Domain logic (business), cleared and not related to realization
    |   |-- Infrastructure  <--- implementation of interfaces for Domain, http-clients, database integration and others
    |   `-- Test <-- Your divine tests are here
    `-- Shared  <--- Shared kernel. Common code for all contexts: interfaces, helper classes
        |-- Application  <---  CQRS realization
        |-- Config  <--- Configuration
        |-- Controller  <--- Basic controllers, exceptions
        |-- Domain  <--- Models, primitive ValueObjects, exceptions, aggregates
        |-- Infrastructure  <--- low-level implementation
        `-- Test <-- Everything for testing
```

## Interesting packages

**Important:** Here I deliberately did not use the FOSRest bundle to show how convenient it is to make API without it.
Feel free to tell me to use it again. I thought that he would be superfluous. The Simplest event subscribers are much better.

* `symfony/messenger` for CQRS
* `dama/doctrine-test-bundle` - transactional rollback for every test
* `lchrusciel/api-test-case` - convenient testing for API

## What and how to test?

### What?

**Unit tests** only for `src/<Bounded context>/Domain` folder with Domain logic. 
We should test services like factories, managers and others.
No need to test Entity with getters and setters.

**Functional tests** for every API method and every request/response cases.
We should test all chain from Controller to Infrastructure and back.
`HTTP-request` -> `Invokable controller` -> `DTO` (command or query) -> `CQRS` -> `Application` -> `Domain service` -> `Infrastructure`

Here we have two commands for two different testsuites - unit and functional. See more in `phpunit.xml.dist`.

### How to run

`docker-compose build`

`docker-compose up -d`

`docker-compose exec -u www-data php-fpm bash`

`composer test-unit` for unit tests

`composer test-func` for functional tests