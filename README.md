# chippyash/Slim-Symfony-Dic

## Quality Assurance

[![Build Status](https://travis-ci.org/chippyash/Slim-Symfony-Dic.svg?branch=master)](https://travis-ci.org/chippyash/Slim-Symfony-Dic)
[![Code Climate](https://codeclimate.com/github/chippyash/Slim-Symfony-Dic/badges/gpa.svg)](https://codeclimate.com/github/chippyash/Slim-Symfony-Dic)
[![Test Coverage](https://codeclimate.com/github/chippyash/Slim-Symfony-Dic/badges/coverage.svg)](https://codeclimate.com/github/chippyash/Slim-Symfony-Dic/coverage)

Certified for PHP 5.5+

The above badges represent the current development branch.  As a rule, I don't push
 to GitHub unless tests, coverage and usability are acceptable.  This may not be
 true for short periods of time; on holiday, need code for some other downstream
 project etc.  If you need stable code, use a tagged version. Read 'Installation'.

See the tests and the [Test Contract](https://github.com/chippyash/Slim-Symfony-Dic/blob/master/docs/Test-Contract.md) for additional information.

## What?

Provides [Symfony Dependency Injection](http://symfony.com/doc/current/components/dependency_injection/introduction.html) 
for a [Slim Application](http://www.slimframework.com/) V3

For an example application that uses this library, please see [Slim-DIC Example](https://github.com/the-matrix/Slim-Dic-Example)


## Why?

The Slim framework is great for lightweight sites and in version V3 adopts the interop
interfaces for dependency injection containers. Slim V3 uses the Pimple DI by default.
Symfony DI does not yet support the interop interface definition.

This small library supports the integration of the easy to use, yet powerful
Symfony version of a DI container with the lightweight Slim Framework, giving 
you the ability to create great, maintainable and configurable web sites quickly.

The Builder supports XML DI definition.  XML is the most powerful and complete form 
of Symfony DI configuration.

## How?

To create and return a Slim\App object with a Symfony DIC:

<pre>
use chippyash\Type\BoolType;
use chippyash\Type\String\StringType;
use chippyash\Type\BoolType;
use Slimdic\Dic\Builder;

$xmlDiFileLocation = '/mysite/cfg/dic.production.xml';

/**
 * @var Slim\App
 */
$app = Builder::getApp(
    new StringType($xmlDiFileLocation)
);
</pre>

Please see the examples/dic.slim.xml for the minimum that you need to build the DIC
with to support Slim.  You are recommended to put the file in with the rest of your
DI configs and use the `<imports>` directive in your main config to pull it in.

You can optionally have the builder write and read a cached version of the DIC by
supplying the path to directory in which to store (commonly called a spool directory)
as a second argument to getApp().

<pre>
$spoolDir = '/mysite/spool';

/**
 * @var Slim\App
 */
$app = Builder::getApp(
    new StringType($xmlDiFileLocation),
    new StringType($spoolDir)
);
</pre>

This of course makes great sense in a production environment.

As an aid to debugging your DI Container, the cached PHP container can also be augmented
by dumping an XML definition generated by the Symfony compiler.  Add a third parameter
to getApp() to do this.

<pre>
$app = Builder::getApp(
    new StringType($xmlDiFileLocation),
    new StringType($spoolDir),
    new BoolType(true)
);
</pre>

The resultant XML definition will be dumped in your spoolDir.  You can often learn how
to tune your DI config by looking at the XML definition thus generated.

The Builder supports a second static function, `buildDic()`, that takes the same parameters
as getApp().  You can use the function if you need some fine grained control on it
before passing it into Slim\App. Please note whilst `buildDic` will save a cached version
of the DI container, it will not retrieve one if already stored.  That's the job of
`getApp`.

You can add to the compilation process by utilising the pre and post compile functions.
This is often useful for setting up synthetic services or initialising parameters in
the DI container.

### Register a PreCompile function

The PreCompile function is called just before the container is compiled. If you are caching
then it important to note that it will only be called once, i.e. when the container
is first compiled.

<pre>
use Slimdic\Dic\ServiceContainer;
use Symfony\Component\DependencyInjection\Definition;

Builder::registerPreCompileFunction(function(ServiceContainer $dic) {
    //set a parameter
    $dic->setParameter('foo', 'bar');
    //set up a synthetic
    $dic->setDefinition('bar', (new Definition())->setSynthetic(true));
});
$app = Builder::getApp(
    new StringType($xmlDiFileLocation)
);
</pre>

### Register a PostCompile function

Unlike PreCompile which is called only once, the PostCompile function is called just 
after compiling the container, and just before returning the App to you via `getApp`.
You can specify what to run by inspecting the $stage parameter that will be passed
into your function.

The post compile function only really makes sense to set a synthetic definition as
after compilation the rest of the DI Container is frozen and cannot be changed.

<pre>
use Slimdic\Dic\ServiceContainer;

Builder::registerPreCompileFunction(function(ServiceContainer $dic) {
    $dic->setDefinition('foo', (new Definition())->setSynthetic(true));
});

Builder::registerPostCompileFunction(function(ServiceContainer $dic, $stage) {
    if($stage == Builder::COMPILE_STAGE_APP) {
        $dic->set('foo', 'bar');
    }
    if($stage == Builder::COMPILE_STAGE_BUILD) {
        $dic->set('foo', 'bop');
    }
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

See [The (PHP) Matrix](http://the-matrix.github.io/packages/) for more PHP packages from
this author.

See [My blog](http://zf4.biz) for ramblings on coding and curries

### Installation

Install [Composer](https://getcomposer.org/)

#### For production

#####Not ready for production yet - please wait for first version

add

<pre>
    "chippyash/slim-symfony-dic": "~1.0"
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

This software library is released under the [GNU GPL V3 or later license](http://www.gnu.org/copyleft/gpl.html)

This software library is Copyright (c) 2016, Ashley Kitson, UK

A commercial license is available for this software library, please contact the author. 
It is normally free to deserving causes, but gets you around the limitation of the GPL
license, which does not allow unrestricted inclusion of this code in commercial works.

## History


