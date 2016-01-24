<?php
/**
 * Slim-Symfony-Dic
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2016, UK
 * @license GPL V3+ See LICENSE.md
 */

namespace Slimdic\Test\Dic;

use chippyash\Type\BoolType;
use chippyash\Type\String\StringType;
use org\bovigo\vfs\vfsStream;
use Slimdic\Dic\Builder;
use Slimdic\Dic\ServiceContainer;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Test the example DIC definition file
 */
class ExampleFileTest extends \PHPUnit_Framework_TestCase
{

    public function testCachedExampleFileContainerBehavesProperly()
    {
        $exampleFile = realpath(__DIR__ . '/../../../../examples/dic.slim.xml');

        //this should get the cached version
        $dic = Builder::getApp(
            new StringType($exampleFile),
            new StringType(__DIR__ . '/Stubs')
        )->getContainer();

        $this->assertInstanceOf('Slimdic\Dic\ServiceContainer', $dic);
        $this->assertInstanceOf($dic->getParameter('slim.config.classname.environment'), $dic->get('environment'));
        $this->assertInstanceOf($dic->getParameter('slim.config.classname.request'), $dic->get('request'));
        $this->assertInstanceOf($dic->getParameter('slim.config.classname.response'), $dic->get('response'));
        $this->assertInstanceOf($dic->getParameter('slim.config.classname.router'), $dic->get('router'));
        $this->assertInstanceOf($dic->getParameter('slim.config.classname.foundHandler'), $dic->get('foundHandler'));
        $this->assertInstanceOf($dic->getParameter('slim.config.classname.errorHandler'), $dic->get('errorHandler'));
        $this->assertInstanceOf($dic->getParameter('slim.config.classname.notAllowedHandler'), $dic->get('notAllowedHandler'));
        $this->assertInstanceOf($dic->getParameter('slim.config.classname.callableResolver'), $dic->get('callableResolver'));
    }
}