<?php

namespace Fishingboy\MaDump;

/**
 * Magento var_dump tool
 */
class MaDump
{
    const VAR_TYPE_BOOLEAN = "boolean";

    /**
     * dump data
     * @param $data
     * @param false $return_value
     * @param int $deep
     * @return string|void
     */
    public static function dump($data, bool $return_value = false, int $deep = 0)
    {
        $output = "<pre>";
        $attributes = [];
        if (is_object($data)) {
            $output .= get_class($data) . "\n";
            foreach ($data as $key => $value) {
                if (is_object($value)) {
                    $class = get_class($value);
                    $attributes[] = self::getPadding($deep) . "[$key] ($class)";
                } else if (is_array($value)) {
                    if (self::isNormalArray($value)) {
                        $attributes[] = self::getPadding($deep) . "[$key] (Array)";
                    } else {
                        $attributes[] = self::getPadding($deep) . "[$key] (Key Value Array)";
                    }
                } else {
                    $attributes[] = self::getPadding($deep) . "[$key] => " . self::dumpValue($value);
                }
            }

            $methods = get_class_methods($data);
            if (count($methods)) {
                foreach ($methods as $method) {
                    $attribute_output = self::getPadding($deep) . "->$method()";
                    if (preg_match("/^[a-z]+[A-Z]+/", $method)) {
                        $method_return = $data->$method();
                        if (is_object($method_return)) {
                            $attribute_output .= " : " . get_class($method_return);
                        } elseif (is_array($method_return)) {
                            if (self::isNormalArray($method_return)) {
                                $attribute_output .= " : array";
                            } else {
                                $attribute_output .= " : key value array";
                            }
                        } else {
                            $attribute_output .= " : " . self::dumpValue($method_return);
                        }
                    }
                    $attributes[] = $attribute_output;
                }
            }
        } else if (is_array($data)) {
            $count = count($data);
            $output .= "Array($count) => \n";
            $attributes = [];
            foreach ($data as $key => $value) {
                if (is_object($value)) {
                    $value_output = "=> (" . get_class($value) . ")";
                } else if (is_array($value)) {
                    $value_output = "=> (Array)";
                } else {
                    $value_output = "=> " . self::dumpValue($value);
                }
                $attributes[] = self::getPadding($deep) . "[{$key}] $value_output";
            }
        } else {
            $output .= self::dumpValue($data);
        }

        sort($attributes);
        $output .= implode("\n", $attributes);
        $output .= "</pre>";

        if ($return_value) {
            return $output;
        } else {
            echo $output;
        }
    }

    private static function dumpValue($value)
    {
        $type = gettype($value);
        $value_output = $value;
        if ($type == self::VAR_TYPE_BOOLEAN) {
            $value_output = ($value) ? "true" : "false";
        }

        return "$value_output ($type)";
    }

    private static function getPadding($deep): string
    {
        return str_pad(" ", ($deep + 1) * 4);
    }

    private static function isNormalArray($array): bool
    {
        foreach ($array as $key => $value) {
            if ($key != (string) intval($key)) {
                return false;
            }
        }
        return true;
    }
}