<?php

namespace Jandanielcz\Positive;

class Configuration
{
    protected array $values = [];
    public function __construct(
        protected array $configs,
    ){
        foreach ($this->configs as $config) {
            $newValues = json5_decode(
                file_get_contents($config),
                true
            );
            $this->values = array_replace_recursive($this->values, (array)$newValues);
        }
    }

    public function get(string $key)
    {
        $keys = explode('::', $key);
        $current = $this->values;
        while (($nextKey = array_shift($keys))) {
            if (!isset($current[$nextKey])) {
                return null;
            }
            $current = $current[$nextKey];
        }
        return $current;
    }
}