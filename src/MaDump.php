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
            echo get_class($data) . " ==>\n";
            foreach ($data as $key => $value) {
                if (is_object($value)) {

                } else if (is_array($value)) {

                } else {

                }
                echo $this->getPadding($deep) . ".$key\n";
            }

            $methods = get_class_methods($data);
            if (count($methods)) {
                foreach ($methods as $method) {
                    echo $this->getPadding($deep) . "->$method()\n";
                }
            }
            echo "<pre>methods = " . print_r($methods, true) . "</pre>\n";


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

    public function isNormalArray($array)
    {
        foreach ($array as $key => $value) {
            var_dump($key);
            var_dump(intval($key));
            if ($key !=  (string) intval($key)) {
                return false;
            }
        }
        return true;
    }
}

