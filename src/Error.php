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

namespace startphp;

class Error
{

    protected $throwError;

    public static function runError ($errno = 2, $errstr = 'Undefined Error', $errfile = 'Undefined Error', $errline = 0)
    {
        $throwError = \ThrowError::throw($errfile, $errline, $errorcode = "System Error", "", $errstr, $errno = 2);
        return true;
    }

    public static function runException ($e)
    {
        $errstr = $e->getMessage ();
        $errfile = $e->getFile ();
        $errline = $e->getLine ();
        $errno = $e->getCode ();
        $errTrace = $e->getTrace ();
        $throwError = \ThrowError::throw($errfile, $errline, $errorcode = "System Exception", "", $errstr, $errno = 2);
        return true;
    }

    public static function appShutdown ()
    {
        if (!is_null ($error = error_get_last ()) && self::isFatal ($error['type'])) {
            self::runError ($error['type'], $error['message'], $error['file'], $error['line']);
        }
    }

    protected static function isFatal ($type)
    {
        return in_array ($type, [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE]);
    }

    public static function init ()
    {
        error_reporting (E_ALL);
        set_error_handler ([__CLASS__, "runError"]);
        set_exception_handler ([__CLASS__, "runException"]);
        register_shutdown_function ([__CLASS__, "appShutdown"]);
    }
}