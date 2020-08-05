<?php

namespace Pantheion\Utils;

use Exception;

class Arr
{
    public function accessible($var)
    {
        return $var instanceof \ArrayAccess || is_array($var);
    }

    public function add(array $array, string $key, $value)
    {
        $array[$key] = $value;

        return $array;
    }

    public function collapse(array $arrayOfArrays)
    {
        if(!$this->isMulti($arrayOfArrays)) {
            throw new \Exception("Not a multidimensional array");
        }

        $result = [];
        
        foreach($arrayOfArrays as $array)
        {
            $result = array_merge($result, $array);
        }

        return $result;
    }

    public function divide(array $array)
    {
        return [array_keys($array), array_values($array)];
    }

    public function except(array $array, string $except)
    {
        return array_filter($array, function($key) use ($except) {
            return $key !== $except;
        }, ARRAY_FILTER_USE_KEY);
    }

    public function empty(array $array)
    {
        if(is_null($array)) {
            throw new \Exception("The array is not initialized");
        }

        return !boolval(count($array));
    }

    public function first(array $array, \Closure $callback = null, $default = null)
    {
        if($this->empty($array)) {
            throw new \Exception("Array is empty");
        }

        if(!is_null($callback)) {
            $result = array_values(
                array_filter($array, $callback, ARRAY_FILTER_USE_BOTH)
            );

            return count($result) >= 1 ? $result[0] : $default;
        }

        return array_values($array)[0];
    }

    public function forget(array &$array, string $key)
    {
        if ($this->empty($array)) throw new \Exception("Array is empty");
        if (!$this->has($array, $key)) throw new \Exception("Key doesn't exist in array");

        unset($array[$key]);
    }

    public function get(array $array, string $key)
    {
        if ($this->empty($array)) throw new \Exception("Array is empty");
        if (!$this->has($array, $key)) throw new \Exception("Key doesn't exist in array");

        return $array[$key];
    }

    public function has(array $array, string $key)
    {
        return array_key_exists($key, $array);
    }

    public function hasAll(array $array, array $keys) 
    {
        foreach($keys as $key) {
            if(!$this->has($array, $key)) {
                return false;
            }
        }

        return true;
    }

    public function hasAny(array $array, array $keys)
    {
        foreach ($keys as $key) {
            if ($this->has($array, $key)) {
                return true;
            }
        }

        return false;
    }

    public function isAssoc(array $array)
    {
        if (array() === $array) return false;
        return array_keys($array) !== range(0, count($array) - 1);
    }

    public function isMulti(array $arrayOfArrays)
    {
        foreach ($arrayOfArrays as $array) {
            if (!is_array($array)) return false;
        }

        return true;
    }

    public function merge(array ...$arrays)
    {
        $result = [];

        foreach($arrays as $array)
        {
            $result = array_merge($result, $array);
        }

        return $result;
    }

    public function last(array $array, \Closure $callback = null, $default = null)
    {
        if ($this->empty($array)) {
            throw new \Exception("Array is empty");
        }

        if (!is_null($callback)) {
            $result = array_values(
                array_filter($array, $callback, ARRAY_FILTER_USE_BOTH)
            );

            return count($result) >= 1 ? $result[count($result) - 1] : $default;
        }

        return array_values($array)[count($array) - 1];
    }

    public function only(array $array, array $keys)
    {
        $result = [];
        
        foreach($keys as $key) {
            if(!in_array($key, array_keys($array))) {
                throw new \Exception("Key {$key} is not present in the array");
            }

            $result[$key] = $array[$key];
        }

        return $result;
    }

    public function prepend(array $array, $value, string $key = null)
    {
        if($key) {
            return [$key => $value] + $array;
        }

        array_unshift($array, $value);
        return $array;
    }

    public function pull(array &$array, string $key) 
    {
        $result = $this->get($array, $key);
        $this->forget($array, $key);

        return $result;
    }

    public function random(array $array, int $times = null)
    {
        if(is_null($times) || $times < 1) {
            return $array[mt_rand(0, count($array) - 1)];
        }

        $indexes = [];
        for($i = 0; $i < $times; $i++) {
            do {
                $randomIndex = mt_rand(0, count($array) - 1);
            } while (in_array($randomIndex, $indexes));

            $indexes[] = $randomIndex;
        }

        $result = [];
        foreach($indexes as $index) {
            $result[] = $array[$index];
        }

        return $result;
    }

    public function set(array $array, string $key, $value)
    {
        if ($this->empty($array)) throw new \Exception("Array is empty");
        if (!$this->has($array, $key)) throw new \Exception("Key doesn't exist in array");

        $array[$key] = $value;
        return $array;
    }

    public function shuffle(array &$array)
    {
        if(!$this->isAssoc($array)) {
            shuffle($array);
            return $array;
        }

        $keys = array_keys($array);
        shuffle($keys);

        foreach ($keys as $key) {
            $new[$key] = $array[$key];
        }

        $array = $new;
        return $array;
    }

    public function slice(array $array, int $start, int $length)
    {
        return array_slice($array, $start, $length);
    }

    public function sort(array &$array, $key = null) 
    {
        if(!$key) {
            sort($array);
            return $array;
        }

        if(!$this->isMulti($array)) {
            throw new \Exception("Not possible not being a multi level array");
        }

        $compareFunction = function($a, $b) use ($key) {
            if ($a[$key] == $b[$key]) {
                return 0;
            }

            return ($a[$key] < $b[$key]) ? -1 : 1;
        };
        
        usort($array, $compareFunction);
        return $array;
    }

    public function where(array $array, \Closure $where) 
    {
        return array_filter($array, $where, ARRAY_FILTER_USE_BOTH);
    }
}
