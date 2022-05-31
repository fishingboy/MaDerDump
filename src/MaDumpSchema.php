<?php

namespace Fishingboy\MaDump;

/**
 * Magento var_dump tool
 */
class MaDumpSchema
{
    const VAR_TYPE_BOOLEAN = "boolean";

    /**
     * dump data
     * @param $data
     * @param false $return_value
     * @param int $deep
     * @return string|void
     */
    public static function getSchema($data)
    {
        $deep = 0;
        $data_schema = [];
        $data_schema['type'] = gettype($data);

        $attributes = [];
        if (is_object($data)) {
            $data_schema['class'] = get_class($data);
            foreach ($data as $key => $value) {
                if (is_object($value)) {
                    $attributes[$key] = [
                        "type" => "object",
                        "class" => get_class($value)
                    ];
                } else if (is_array($value)) {
                    if (self::isNormalArray($value)) {
                        $attributes[$key] = [
                            "type" => "array",
                            "value" => "Array",
                        ];
                    } else {
                        $attributes[$key] = [
                            "type" => "array",
                            "value" => "Key Value Array",
                        ];
                    }
                } else {
                    $attributes[$key] = [
                        "type" => "value",
                        "value" => $value
                    ];
                }
            }
            $data_schema['attributes'] = $attributes;

            $class_methods = get_class_methods($data);
            if (count($class_methods)) {
                $methods = [];
                foreach ($class_methods as $method) {
                    $value = null;
                    $method_params = self::getMethodParams($data, $method);
                    if (preg_match("/^get[A-Z]+/", $method)) {
                        try {
                            if (self::isNoParamMethod($data, $method)) {
                                $method_return = $data->$method();
                                if (is_object($method_return)) {
                                    $value = get_class($method_return);
                                } elseif (is_array($method_return)) {
                                    if (self::isNormalArray($method_return)) {
                                        $value = "array";
                                    } else {
                                        $value = "key value array";
                                    }
                                } else {
                                    $value = self::dumpValue($method_return);
                                }
                            }
                        } catch (\Exception $e) {
                        } catch (\ArgumentCountError $e) {
                        }
                    }

                    $methods[$method] = [
                        "method" => $method,
                        "params" => $method_params,
                        "value" => $value,
                    ];
                }
                $data_schema['methods'] = $methods;
            }
        } else if (is_array($data)) {
            $attributes = [];
            foreach ($data as $key => $value) {
                $attribute_type = "";
                if (is_object($value)) {
                    $attribute_type = "object";
                } else if (is_array($value)) {
                    $attribute_type = "array";
                } else {
                    $attribute_type = "value";
                }
                $attributes[] = [
                    "type" => $attribute_type,
                    "value" => $value
                ];
            }
            $data_schema['attributes'] = $attributes;
        } else {
            $data_schema['type'] = "value";
            $data_schema['value'] = $data;
        }

        sort($attributes);
        return $data_schema;
    }

    private static function dumpValue($value)
    {
        $type = gettype($value);
        $value_output = $value;
        if ($type == self::VAR_TYPE_BOOLEAN) {
            $value_output = ($value) ? "true" : "false";
        }

        return $value_output;
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

    private static function isNoParamMethod($class, $method)
    {
        $method_info = new \ReflectionMethod($class, $method);
        $params = $method_info->getParameters();
        return (count($params) == 0);
    }

    private static function getMethodParams($data, string $method)
    {
        $method_info = new \ReflectionMethod($data, $method);
        $params = $method_info->getParameters();
        $output_params = [];
        foreach ($params as $param) {
            if ($param->hasType()) {
                $output_params[] = [
                    "type" => $param->getType()->getName(),
                    "name" => $param->getName(),
                ];
            } else {
                $output_params[] = [
                    "type" => "",
                    "name" => $param->getName(),
                ];
            }
        }
        return $output_params;
    }
}