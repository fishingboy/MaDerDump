<?php

namespace Fishingboy\MaDump;

/**
 * Magento var_dump tool
 */
class MaDump
{
    public function dump($data, $deep = 0)
    {
        if (is_object($data)) {
            echo get_class($data) . "\n";
            foreach ($data as $key => $value) {
                if (is_object($value)) {
                    $class = get_class($value);
                    echo $this->getPadding($deep) . ".$key + ($class) \n";
                } else if (is_array($value)) {
                    if ($this->isNormalArray($value)) {
                        echo $this->getPadding($deep) . ".$key (Array) \n";
                    } else {
                        echo $this->getPadding($deep) . ".$key + (Array) \n";
                    }
                } else {
                    echo $this->getPadding($deep) . ".$key = {$value} \n";
                }
            }

            $methods = get_class_methods($data);
            if (count($methods)) {
                foreach ($methods as $method) {
                    echo $this->getPadding($deep) . "->$method()\n";
                }
            }
        } else if (is_array($data)) {
            echo "Array => \n";
            foreach ($data as $key => $value) {
                echo $this->getPadding($deep) . ".$key\n";
            }
        }
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

