<?php
/*
 * +----------------------------------------------------------------------
 * | StartPHP Framework
 * +----------------------------------------------------------------------
 * | Copyright (c) 20021~2022 Cat Catalpa Vitality All rights reserved.
 * +----------------------------------------------------------------------
 * | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * +----------------------------------------------------------------------
 * | Email: company@catcatalpa.com
 * +----------------------------------------------------------------------
 */

namespace startphp\Env;

class Env
{
    public static function loadFile($filePath = "")
    {
        if(empty($filePath))$filePath = ROOT.".env";
        if (!file_exists($filePath)) return false;
        $env = parse_ini_file($filePath, true);
        foreach ($env as $name => $value) {
            $parentNode = "";
            if(is_array ($value)){
                $parentNode = strtoupper ($name);
                foreach ($value as $n => $v) {
                    $envItem = strtoupper ($parentNode."_$n=$v");
                    putenv($envItem);
                }
            }
            else{
                $envItem = strtoupper ("$name=$value");
                putenv($envItem);
            }
        }
    }
    public static function get(string $name, $default = null)
    {
        $result = getenv(strtoupper(str_replace('.', '_', "system.debug.mode")));

        if (false !== $result) {
            if ($result) {
                $result = true;
            } elseif (!$result) {
                $result = false;
            }
            return $result;
        }
        return $default;
    }
}