<?php

namespace Illuminate\Container;

use ArrayAccess;
use Closure;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container as ContainerContract;
use LogicException;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

class Container implements ArrayAccess, ContainerContract
{
    /**
     * The current globally available container (if any).
     *
     * @var static
     */
    protected static $instance;

    /**
     * An array of the types that have been resolved.
     *
     * @var bool[]
     */
    protected $resolved = [];

    /**
     * The container's bindings.
     *
     * @var array[]
     */
    protected $bindings = [];

    /**
     * The container's method bindings.
     *
     * @var \Closure[]
     */
    protected $methodBindings = [];

    /**
     * The container's shared instances.
     *
     * @var object[]
     */
    protected $instances = [];

    /**
     * The registered type aliases.
     *
     * @var string[]
     */
    protected $aliases = [];

    /**
     * The registered aliases keyed by the abstract name.
     *
     * @var array[]
     */
    protected $abstractAliases = [];

    /**
     * The extension closures for services.
     *
     * @var array[]
     */
    protected $extenders = [];

    /**
     * All of the registered tags.
     *
     * @var array[]
     */
    protected $tags = [];

    /**
     * The stack of concretions currently being built.
     *
     * @var array[]
     */
    protected $buildStack = [];

    /**
     * The parameter override stack.
     *
     * @var array[]
     */
    protected $with = [];

    /**
     * The contextual binding map.
     *
     * @var array[]
     */
    public $contextual = [];

    /**
     * All of the registered rebound callbacks.
     *
     * @var array[]
     */
    protected $reboundCallbacks = [];

    /**
     * All of the global resolving callbacks.
     *
     * @var \Closure[]
     */
    protected $globalResolvingCallbacks = [];

    /**
     * All of the global after resolving callbacks.
     *
     * @var \Closure[]
     */
    protected $globalAfterResolvingCallbacks = [];

    /**
     * All of the resolving callbacks by class type.
     *
     * @var array[]
     */
    protected $resolvingCallbacks = [];

    /**
     * All of the after resolving callbacks by class type.
     *
     * @var array[]
     */
    protected $afterResolvingCallbacks = [];

    public function when($concrete)
    {
        // todo
    }

    public function bound($abstract)
    {
        // todo
    }

    public function has($id)
    {
        // todo
    }

    public function resolved($abstract)
    {
        // todo
    }

    public function isShared($abstract)
    {
        // todo
    }

    public function isAlias($name)
    {
        // todo
    }

    public function bind($abstract, $concrete = null, $shared = false)
    {
        // todo
    }

    public function getClosure($abstract, $concrete)
    {
        // todo
    }

    public function hasMethodBinding($method)
    {
        // todo
    }

    public function bindMethod($method, $callback)
    {
        // todo
    }

    protected function parseBindMethod($method)
    {
        // todo
    }

    public function callMethodBinding($method, $instance)
    {
        // todo
    }

    public function addContextualBinding($concrete, $abstract, $implementation)
    {
        // TODO: Implement addContextualBinding() method.
    }

    public function bindIf($abstract, $concrete = null, $shared = false)
    {
        // TODO: Implement bindIf() method.
    }

    public function singleton($abstract, $concrete = null)
    {
        // TODO: Implement singleton() method.
    }

    public function singleTonIf($abstract, $concrete = null)
    {
        // TODO: Implement singleTonIf() method.
    }

    public function extend($abstract, Closure $closure)
    {
        // TODO: Implement extend() method.
    }

    public function instance($abstract, $instance)
    {
        // TODO: Implement instance() method.
    }

    protected function removeAbstractAlias($searched)
    {
        // todo
    }

    public function tag($abstracts, $tags)
    {
        // TODO: Implement tag() method.
    }

    public function tagged($tag)
    {
        // TODO: Implement tagged() method.
    }

    public function alias($abstract, $alias)
    {
        // TODO: Implement alias() method.
    }

    public function rebinding($abstract, Closure $callback)
    {
        // todo
    }

    public function refresh($abstract, $target, $method)
    {
        // todo
    }

    protected function rebound($abstract)
    {
        // todo
    }

    protected function getReboundCallbacks($abstract)
    {
        // todo
    }

    public function wrap(Closure $callback, array $parameters = [])
    {
        // todo
    }

    public function call($callback, array $parameters = [], $defaultMethod = null)
    {
        // TODO: Implement call() method.
    }

    public function factory($abstract)
    {
        // TODO: Implement factory() method.
    }

    public function makeWith($abstract, array $parameters = [])
    {
        // todo
    }

    public function make($abstract, array $parameters = [])
    {
        // TODO: Implement make() method.
    }

    public function get($id)
    {
        // TODO: Implement get() method.
    }

    protected function resolve($abstract, $parameters = [], $raiseEvents = true)
    {
        // todo
    }

    protected function getConcrete($abstract)
    {
        // todo
    }

    protected function getContextualConcrete($abstract)
    {
        // todo
    }

    protected function findInContextualBindings($abstract)
    {
        // todo
    }

    protected function isBuildable($concrete, $abstract)
    {
        // todo
    }

    public function build($concrete)
    {
        // todo
    }

    protected function resolveDependencies(array $dependencies)
    {
        // todo
    }

    protected function hasParameterOverride($dependency)
    {
        // todo
    }

    protected function getParameterOverride($dependency)
    {
        // todo
    }

    protected function getLastParameterOverride()
    {
        // todo
    }

    protected function resolvePrimitive(ReflectionParameter $parameter)
    {
        // todo
    }

    protected function resolveClass(ReflectionParameter $parameter)
    {
        // todo
    }

    protected function notInstantiable($concrete)
    {
        // todo
    }

    protected function unresolvablePrimitive(ReflectionParameter $parameter)
    {
        // todo
    }

    public function resolving($abstract, Closure $callback = null)
    {
        // TODO: Implement resolving() method.
    }

    public function afterResolving($abstract, Closure $callback = null)
    {
        // TODO: Implement afterResolving() method.
    }

    protected function fireResolvingCallbacks($abstract, $object)
    {
        // todo
    }

    protected function fireAfterResolvingCallbacks($abstract, $object)
    {
        // todo
    }

    protected function getCallbacksForType($abstract, $object, array $callbacksPerType)
    {
        // todo
    }

    protected function fireCallbackArray($object, array $callbacks)
    {
        // todo
    }

    public function getBindings()
    {
        // todo
    }

    public function getAlias($abstract)
    {
        // todo
    }

    protected function getExtenders($abstract)
    {
        // todo
    }

    public function forgetExtenders($abstract)
    {
        // todo
    }

    protected function dropStaleInstances($abstract)
    {
        // todo
    }

    public function forgetInstance($abstract)
    {
        // todo
    }

    public function forgetInstances()
    {
        $this->instances = [];
    }

    public function flush()
    {
        // TODO: Implement flush() method.
    }

    public static function getInstance()
    {
        // todo
    }

    public static function setInstance(ContainerContract $container = null)
    {
        // todo
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
    }
}
