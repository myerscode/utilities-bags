<?php

namespace Myerscode\Utilities\Bags;

class DotUtility extends Utility
{
    public function __construct($bag)
    {
        $bag = $this->normalizeArray($this->transformToBag($bag));

        parent::__construct($bag);
    }

    /**
     * {@inheritdoc}
     */
    public function get($index, $default = null): mixed
    {
        $array = $this->toArray();

        if (! str_contains($index, '.') || $this->exists($index)) {
            return parent::get($index, $default);
        }

        foreach (explode('.', $index) as $segment) {
            if (isset($array[$segment])) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function merge($bag): Utility
    {
        if (is_array($bag)) {
            return parent::merge($this->normalizeArray($bag));
        } elseif ($bag instanceof parent) {
            return parent::merge($bag->toArray());
        }

        return parent::merge(new static($bag));
    }

    /**
     * {@inheritdoc}
     */
    public function mergeRecursively($bag): Utility
    {
        if (is_array($bag)) {
            return parent::mergeRecursively($this->normalizeArray($bag));
        } elseif ($bag instanceof parent) {
            return parent::mergeRecursively($bag->toArray());
        }

        return parent::mergeRecursively(new static($bag));
    }

    /**
     * {@inheritdoc}
     */
    public function set($index, $value): Utility
    {
        $array = &$this->bag;

        $keys = explode('.', $index);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (! isset($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        $newBag = $this->bag;

        return new self($newBag);
    }

    /**
     * Destruct an array that has dot notation
     */
    protected function normalizeArray(array $items, string $delimiter = '.'): array
    {
        $new = [];

        foreach ($items as $key => $value) {
            if (! str_contains($key, $delimiter)) {
                $new[$key] = is_array($value) ? $this->normalizeArray($value, $delimiter) : $value;

                continue;
            }

            $segments = explode($delimiter, $key);

            $last = &$new[$segments[0]];

            foreach ($segments as $k => $segment) {
                if ($k != 0) {
                    $last = &$last[$segment];
                }
            }

            $last = is_array($value) ? $this->normalizeArray($value, $delimiter) : $value;
        }

        return $new;
    }
}
