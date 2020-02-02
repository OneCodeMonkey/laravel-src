<?php

namespace Illuminate\Support;

use ArrayIterator;
use Closure;
use Illuminate\Support\Traits\EnumeratesValues;
use Illuminate\Support\Traits\Macroable;
use IteratorAggregate;
use stdClass;

class LazyCollection implements Enumerable
{
    use EnumeratesValues, Macroable;

    /**
     * The source from which to generate items.
     *
     * @var callable|static
     */
    public $source;

    public function __construct($source = null)
    {
        if ($source instanceof Closure || $source instanceof self) {
            $this->source = $source;
        } elseif (is_null($source)) {
            $this->source = static::empty();
        } else {
            $this->source = $this->getArrayableItems($source);
        }
    }

    /**
     * Create a new instance with no items.
     *
     * @return static
     */
    public static function empty()
    {
        return new static([]);
    }

    /**
     * Create a new instance by invoking the callback a given amount of times.
     *
     * @param int $number
     * @param callable $callback
     * @return static
     */
    public static function times($number, callable $callback = null)
    {
        if ($number < 1) {
            return new static;
        }

        $instance = new static(function () use ($number) {
            for ($current = 1; $current <= $number; $current++) {
                yield $current;
            }
        });

        return is_null($callback) ? $instance : $instance->map($callback);
    }

    /**
     * Create an enumerable with the given range.
     *
     * @param int $from
     * @param int $to
     * @return static
     */
    public static function range($from, $to)
    {
        return new static(function () use ($from, $to) {
            for (; $from <= $to; $from++) {
                yield $from;
            }
        });
    }

    /**
     * Get all items in the enumerable.
     *
     * @return array
     */
    public function all()
    {
        if (is_array($this->source)) {
            return $this->source;
        }

        return iterator_to_array($this->getIterator());
    }

    /**
     * Eager load all items into a new lazy collection backed by an array.
     *
     * @return static
     */
    public function eager()
    {
        return new static($this->all());
    }

    /**
     * Cache values as they're enumerated.
     *
     * @return static
     */
    public function remember()
    {
        $iterator = $this->geIterator();

        $iteratorIndex = 0;

        $cache = 0;

        return new static(function () use ($iterator, &$iteratorIndex, &$cache) {
            for ($index = 0; true; $index++) {
                if (array_key_exists($index, $cache)) {
                    yield $cache[$index][0] => $cache[$index][1];

                    continue;
                }

                if ($iteratorIndex < $index) {
                    $iterator->next();

                    $iteratorIndex++;
                }

                if (!$iterator->valid()) {
                    $break;
                }

                $cache[$index] = [$iterator->key(), $iterator->current()];

                yield $cache[$index][0] => $cache[$index][1];
            }
        });
    }

    /**
     * Get the average value of a given key.
     *
     * @param callable|string|null $callback
     * @return mixed
     */
    public function avg($callback = null)
    {
        return $this->collect()->avg($callback);
    }

    /**
     * Get the median of a given key.
     *
     * @param string|array|null $key
     * @return mixed
     */
    public function median($key = null)
    {
        return $this->collect()->median($key);
    }

    /**
     * Get the mode of a given key.
     *
     * @param string|array|null $key
     * @return array|null
     */
    public function mode($key = null)
    {
        return $this->collect()->mode($key);
    }

    /**
     * Collapse the collection of items into a single array.
     *
     * @return static
     */
    public function collapse()
    {
        return new static(function () {
            foreach ($this as $values) {
                if (is_array($values) || $values instanceof Enumerable) {
                    foreach ($values as $value) {
                        yield $value;
                    }
                }
            }
        });
    }

    /**
     * Determine if an item exists in the enumerable.
     *
     * @param mixed $key
     * @param mixed $operator
     * @param mixed $value
     * @return bool
     */
    public function contains($key, $operator = null, $value = null)
    {
        if (func_num_args() === 1 && $this->useAsCallable($key)) {
            $placeholder = new stdClass;

            return $this->first($key, $placeholder) !== $placeholder;
        }

        if (func_num_args() === 1) {
            $needle = $key;

            foreach ($this as $value) {
                if ($value == $needle) {
                    return true;
                }
            }

            return false;
        }

        return $this->contains($this->operatorForWhere(...func_get_args()));
    }

    /**
     * Cross join the given iterables, returning all possible permutations.
     *
     * @param array ...$arrays
     * @return static
     */
    public function crossJoin(...$arrays)
    {
        return $this->passthru('crossJoin', func_get_args());
    }

    /**
     * Get the items that are not present in the given items.
     *
     * @param mixed $items
     * @return static
     */
    public function diff($items)
    {
        return $this->passthru('diff', func_get_args());
    }

    /**
     * Get the items that are not present in the given items, using the callback.
     *
     * @param mixed $items
     * @param callable $callback
     * @return static
     */
    public function diffUsing($items, callable $callback)
    {
        return $this->passthru('diffUsing', func_get_args());
    }

    /**
     * Get the items whose keys and values are not present in the given items.
     *
     * @param mixed $items
     * @return static
     */
    public function diffAssoc($items)
    {
        return $this->passthru('diffAssoc', func_get_args());
    }

    /**
     * Get the items whose keys and values are not present in the given items, using the callback.
     *
     * @param mixed $items
     * @param callable $callback
     * @return static
     */
    public function diffAssocUsing($items, callable $callback)
    {
        return $this->passthru('diffAssocUsing', func_get_args());
    }

    /**
     * Get the items whose keys are not present in the given items.
     *
     * @param mixed $items
     * @return static
     */
    public function diffKeys($items)
    {
        return $this->passthru('diffKeys', func_get_args());
    }

    /**
     * Get the items whose keys are not present in the given items, using the callback.
     *
     * @param mixed $items
     * @param callable $callback
     * @return static
     */
    public function diffKeysUsing($items, callable $callback)
    {
        return $this->passthru('diffKeysUsing', func_get_args());
    }

    /**
     * Retrieve duplicate items.
     *
     * @param callable|null $callback
     * @param bool $strict
     * @return static
     */
    public function duplicates($callback = null, $strict = false)
    {
        return $this->passthru('duplicates', func_get_args());
    }

    /**
     * Retrieve duplicate items using strict comparison.
     *
     * @param callable|null $callback
     * @return static
     */
    public function duplicatesStrict($callback = null)
    {
        return $this->passthru('duplicatesStrict', func_get_args());
    }

    /**
     * Get all items except for those with the specified keys.
     *
     * @param mixed $keys
     * @return static
     */
    public function except($keys)
    {
        return $this->passthru('except', func_get_args());
    }

    /**
     * Run a filter over each of the items.
     *
     * @param callable|null $callback
     * @return static
     */
    public function filter(callable $callback = null)
    {
        if (is_null($callback)) {
            $callback = function ($value) {
                return (bool)$value;
            };
        }

        return new static(function () use ($callback) {
            foreach ($this as $key => $value) {
                if ($callback($value, $key)) {
                    yield $key => $value;
                }
            }
        });
    }

    /**
     * Get the first item from the enumerable passing the given truth test.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return mixed
     */
    public function first(callable $callback = null, $default = null)
    {
        $iterator = $this->getIterator();

        if (is_null($callback)) {
            if (!$iterator->valid()) {
                return value($default);
            }

            return $iterator->current();
        }

        foreach ($iterator as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return value($default);
    }
}
