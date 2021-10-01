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
                echo $this->getPadding($deep) . "[+]$key\n";
            }
        } else if (is_array($data)) {
            echo "Array => \n";
            foreach ($data as $key => $value) {
                echo $this->getPadding($deep) . "[+]$key\n";
            }
        }
        return true;
    }

    public function getPadding($deep)
    {
        return str_pad(" ", ($deep + 1) * 4);
    }
}

