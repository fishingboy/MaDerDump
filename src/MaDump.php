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
        $data_schema = MaDumpSchema::getSchema($data);
        $output = MaDumpOutput::text($data_schema);

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
        $output = [];
        foreach ($params as $param) {
            if ($param->hasType()) {
                $output[] = "{$param->getType()} \${$param->getName()}";
            } else {
                $output[] = "\${$param->getName()}";
            }
        }
        return implode(", ", $output);
    }
}