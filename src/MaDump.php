<?php

namespace Fishingboy\MaDump;

/**
 * Magento var_dump tool
 */
class MaDump
{
    public function dump($data, $deep = 0)
    {
        echo "<pre>";
        $attributes = [];
        if (is_object($data)) {
            echo get_class($data) . "\n";
            foreach ($data as $key => $value) {
                if (is_object($value)) {
                    $class = get_class($value);
                    $attributes[] = $this->getPadding($deep) . ".$key + ($class)";
                } else if (is_array($value)) {
                    if ($this->isNormalArray($value)) {
                        $attributes[] = $this->getPadding($deep) . ".$key (Array)";
                    } else {
                        $attributes[] = $this->getPadding($deep) . ".$key + (Array)";
                    }
                } else {
                    $attributes[] = $this->getPadding($deep) . ".$key = {$value}";
                }
            }

            $methods = get_class_methods($data);
            if (count($methods)) {
                foreach ($methods as $method) {
                    $attributes[] = $this->getPadding($deep) . "->$method()";
                }
            }
        } else if (is_array($data)) {
            $count = count($data);
            echo "Array($count) => \n";
            $attributes = [];
            foreach ($data as $key => $value) {
                if (is_object($value)) {
                    $value_output = "=> (" . get_class($value) . ")";
                } else if (is_array($value)) {
                    $value_output = "=> (Array)";
                } else {
                    $value_output = "=> $value";
                }
                $key_output = is_numeric($key) ? "[$key]" : ".$key";
                $attributes[] = $this->getPadding($deep) . "$key_output $value_output";
            }
        }

        sort($attributes);
        echo implode("\n", $attributes);
        echo "</pre>";

        return true;
    }

    public function getPadding($deep): string
    {
        return str_pad(" ", ($deep + 1) * 4);
    }

    public function isNormalArray($array): bool
    {
        foreach ($array as $key => $value) {
            if ($key != (string) intval($key)) {
                return false;
            }
        }
        return true;
    }
}

