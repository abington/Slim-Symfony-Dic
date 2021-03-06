# chippyash/Slim-Symfony-Dic

## Quality Assurance

![PHP 5.6](https://img.shields.io/badge/PHP-5.6-blue.svg)
![PHP 7.1](https://img.shields.io/badge/PHP-7.1-blue.svg)
[![Build Status](https://travis-ci.org/chippyash/Slim-Symfony-Dic.svg?branch=master)](https://travis-ci.org/chippyash/Slim-Symfony-Dic)
[![Code Climate](https://codeclimate.com/github/chippyash/Slim-Symfony-Dic/badges/gpa.svg)](https://codeclimate.com/github/chippyash/Slim-Symfony-Dic)
[![Test Coverage](https://codeclimate.com/github/chippyash/Slim-Symfony-Dic/badges/coverage.svg)](https://codeclimate.com/github/chippyash/Slim-Symfony-Dic/coverage)

The above badges represent the current development branch.  As a rule, I don't push
 to GitHub unless tests, coverage and usability are acceptable.  This may not be
 true for short periods of time; on holiday, need code for some other downstream
 project etc.  If you need stable code, use a tagged version. Read 'Installation'.

See the tests and the [Test Contract](https://github.com/chippyash/Slim-Symfony-Dic/blob/master/docs/Test-Contract.md) for additional information.

Please note that developer support for PHP5.5 was withdrawn at version 3.0.0 of this library.
If you need support for PHP 5.5, please use a version `>=2,<3`

## What?

Provides a [Symfony Dependency Injection Container V2](https://symfony.com/doc/2.8/service_container.html)
or [Symfony Dependency Injection Container V4](https://symfony.com/doc/current/service_container.html)
for a [Slim Application V3](http://www.slimframework.com/).  The DI container depends on the 
version of PHP you are using.  < 7, then V2, >=7.1 then V4

## Why?

The Slim framework is great for lightweight sites and in version V3 adopts the interop
interfaces for dependency injection containers. Slim V3 uses the Pimple DI by default.
Symfony DI does not yet support the interop interface definition.

This small library supports the integration of the easy to use, yet powerful
Symfony version of a DI container with the lightweight Slim Framework, giving 
you the ability to create great, maintainable and configurable web sites quickly.

The Builder supports XML DI definition.  XML is the most powerful and complete form 
of Symfony DI configuration.  The Builder also supports Yaml DI definition.  Many
developers prefer to put the parameters into a Yaml file and service definitions into
an XML file.  The supplied minimal example files demonstrate this usage.

## How?

To create and return a Slim\App object with a Symfony DIC:

<pre>
use Chippyash\Type\String\StringType;
use Slimdic\Dic\Builder;
use Slim\App;

$xmlDiFileLocation = '/mysite/cfg/dic.production.xml';

/**
 * @var Slim\App
 */
$app = new App(Builder::buildDic(new StringType($xmlDiFileLocation)));
</pre>

Please see the examples/dic.slim.v2.xml, examples/dic.slim.v3.xml and examples/dic.slim.yml 
files for the minimum that you need to build the DIC with to support Slim.  You are 
recommended to put the files in with the rest of your DI configs and use the `<imports>` 
directive in your main config to pull it in.

You can add to the compilation process by utilising the pre and post compile functions.
This is often useful for setting up synthetic services or initialising parameters in
the DI container.

### Register a PreCompile function

The PreCompile function is called just before the container is compiled.

<pre>
use Slimdic\Dic\ServiceContainer;
use Symfony\Component\DependencyInjection\Definition;

Builder::registerPreCompileFunction(function($dic) {
    //set a parameter
    $dic->setParameter('foo', 'bar');
    //set up a synthetic
    $dic->setDefinition('bar', (new Definition())->setSynthetic(true));
});

$app = new App(Builder::buildDic(new StringType($xmlDiFileLocation)));
</pre>

### Register a PostCompile function

The PostCompile function is called just  after compiling the container.

The post compile function only really makes sense to set a synthetic definition as
after compilation the rest of the DI Container is frozen and cannot be changed.

<pre>
use Slimdic\Dic\ServiceContainer;

Builder::registerPreCompileFunction(function($dic) {
    $dic->setDefinition('foo', (new Definition())->setSynthetic(true));
});

Builder::registerPostCompileFunction(function($dic, $stage) {
    $dic->set('foo', $myFooService);
});
</pre>

## Changing the library

1.  fork it
2.  write the test
3.  amend it
4.  do a pull request

Found a bug you can't figure out?

1.  fork it
2.  write the test
3.  do a pull request

or raise an issue ticket

NB. Make sure you rebase to HEAD before your pull request

## Where?

The library is hosted at [Github](https://github.com/chippyash/Slim-Symfony-Dic). It is
available at [Packagist.org](https://packagist.org/packages/chippyash/slim-symfony-dic)

Check out [ZF4 Packages](http://zf4.biz/packages?utm_source=github&utm_medium=web&utm_campaign=blinks&utm_content=slimsymfonydic) for more packages

See [My blog](http://zf4.biz) for ramblings on coding and curries

### Installation

Install [Composer](https://getcomposer.org/)

#### For production

<pre>
    "chippyash/slim-symfony-dic": ">=3,<4"
</pre>

to your composer.json "requires" section

#### For development

Clone this repo, and then run Composer in local repo root to pull in dependencies

<pre>
    git clone git@github.com:chippyash/Slim-Symfony-Dic.git Slimdic
    cd Slimdic
    composer install --dev
</pre>

To run the tests:

<pre>
    cd Slimdic
    vendor/bin/phpunit -c test/phpunit.xml test/
</pre>

## License

This software library is released under the [BSD 3 Clause license](https://opensource.org/licenses/BSD-3-Clause)

This software library is Copyright (c) 2016-2018, Ashley Kitson, UK

## History

V1.0.0 Initial Release

V1.1.0 Update dependencies

V1.1.1 Add link to packages

V1.1.2 Verify PHP 7 compatibilty

V1.1.3 Update Slim dependency to 3.* 

V1.1.4 Update dependencies

V1.1.5 Update build script

V2.0.0 PHP 7.0 support withdrawn, updated to use 7.1, primarily because of underlaying 
libraries that don't support 7.0

V2.0.2 Fix unit tests to run under PHP 7.1

V3.0.0 BC Break.  Withdraw support for PHP <5.6

V3.1.0 Change of license from GPL V3 to BSD 3 Clause 

V3.1.1 dependency update