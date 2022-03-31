<?php

namespace Fishingboy\MaDump;

/**
 * Magento var_dump tool
 */
class MaDumpOutput
{
    const VAR_TYPE_BOOLEAN = "boolean";

    public static function text($data_schema)
    {
        $deep = 0;
        $output = "<pre>";
        $attributes = [];
        if ($data_schema['type'] == "object") {
            $output .= $data_schema['class'] . "\n";
            foreach ($data_schema['attributes'] as $key => $attribute) {
                if ($attribute['type'] == "object") {
//                    $class = get_class($value);
//                    $attributes[] = self::getPadding($deep) . "[$key] ($class)";
                } else if ($attribute['type'] == "array") {
//                    if (self::isNormalArray($value)) {
//                        $attributes[] = self::getPadding($deep) . "[$key] (Array)";
//                    } else {
//                        $attributes[] = self::getPadding($deep) . "[$key] (Key Value Array)";
//                    }
                } else {
                    $attributes[] = self::getPadding($deep) . "[$key] => " . self::dumpValue($attribute['value']);
                }
            }

//            $methods = get_class_methods($data);
//            if (count($methods)) {
//                foreach ($methods as $method) {
//                    $method_params = self::getMethodParams($data, $method);
//                    $attribute_output = self::getPadding($deep) . "->$method({$method_params})";
//                    if (preg_match("/^get[A-Z]+/", $method)) {
//                        try {
//                            if (self::isNoParamMethod($data, $method)) {
//                                $method_return = $data->$method();
//                                if (is_object($method_return)) {
//                                    $attribute_output .= " : " . get_class($method_return);
//                                } elseif (is_array($method_return)) {
//                                    if (self::isNormalArray($method_return)) {
//                                        $attribute_output .= " : array";
//                                    } else {
//                                        $attribute_output .= " : key value array";
//                                    }
//                                } else {
//                                    $attribute_output .= " : " . self::dumpValue($method_return);
//                                }
//                            }
//                        } catch (\Exception $e) {
//                        } catch (\ArgumentCountError $e) {
//                        }
//                    }
//                    $attributes[] = $attribute_output;
//                }
//            }
        } else if ($data_schema['type'] == "array") {
            $count = count($data_schema['attributes']);
            $output .= "Array($count) => \n";
            $attributes = [];
            foreach ($data_schema['attributes'] as $key => $attribute) {
                if ($attribute['type'] == "object") {
//                    $value_output = "=> (" . get_class($value) . ")";
                } else if ($attribute['type'] == "array") {
//                    $value_output = "=> (Array)";
                } else {
                    $value_output = "=> " . self::dumpValue($attribute['value']);
                }
                $attributes[] = self::getPadding($deep) . "[{$key}] $value_output";
            }
        } else {
            $output .= self::dumpValue($data_schema['value']);
        }

        sort($attributes);
        $output .= implode("\n", $attributes);
        $output .= "</pre>";

        return $output;
    }

    public static function html($data_schema)
    {

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
}