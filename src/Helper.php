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

if (!function_exists ("session_get")) {
    function session_get ($sessionName,$sessionValue = "")
    {
        return Session::get($sessionName,$sessionValue);
    }
}

if (!function_exists ("session_set")) {
    function session_set ($sessionName,$sessionValue)
    {
        return Session::set($sessionName,$sessionValue);
    }
}

if (!function_exists ("session_unset")) {
    function session_unset ($sessionName)
    {
        return Session::unset($sessionName);
    }
}

if (!function_exists ("session_des")) {
    function session_des ($sessionName)
    {
        return Session::des($sessionName);
    }
}

if (!function_exists ("session_isset")) {
    function session_isset ($sessionName,$sessionValue = "")
    {
        return Session::isset($sessionName,$sessionValue);
    }
}

if (!function_exists ("session_empty")) {
    function session_empty ($sessionName)
    {
        return Session::empty($sessionName);
    }
}

if (!function_exists ("cookie_get")) {
    function cookie_get ($sessionName,$sessionValue = "")
    {
        return Cookie::get($sessionName,$sessionValue);
    }
}

if (!function_exists ("cookie_set")) {
    function cookie_set ($cookieName, $cookieValue, $expire = 0, $path = "", $domain = "",$secure = false,$httponly = false)
    {
        return Cookie::set($cookieName,$cookieValue,$expire,$path,$domain,$secure,$httponly);
    }
}

if (!function_exists ("cookie_des")) {
    function cookie_des ($cookieName)
    {
        return Cookie::des($cookieName);
    }
}

if (!function_exists ("cookie_isset")) {
    function cookie_isset ($cookieName,$cookieValue = "")
    {
        return Cookie::isset($cookieName,$cookieValue);
    }
}

if (!function_exists ("cookie_empty")) {
    function cookie_empty ($cookieName)
    {
        return Cookie::empty($cookieName);
    }
}

if (!function_exists ("redirect")) {
    function Redirect ($url = "", $remember = false)
    {
        return Redirect::redirect ($url, $remember);
    }
}

if (!function_exists ("redirect_backoff")) {
    function redirect_backoff ($remember = false)
    {
        return Redirect::backoff ($remember);
    }
}

if (!function_exists ("container_get")) {
    function container_get ($key)
    {
        global $container;
        return $container->get ($key);
    }
}

if (!function_exists ("container_bind")) {
    function container_bind ($key, $value)
    {
        global $container;
        return $container->bind ($key, $value);
    }
}

if (!function_exists ("container_get")) {
    function container_get ($key)
    {
        global $container;
        return $container->get ($key);
    }
}

if (!function_exists ("container_isValueSet")) {
    function container_isValueSet ($value)
    {
        global $container;
        return $container->isValueSet ($value);
    }
}

if (!function_exists ("hook_transfer")) {
    function hook_transfer ($className = "", $functionName = "", $args = "")
    {
        require_once DIR."Hook.php";
        $hook = new startphp\Hook;
        return $hook->transfer ($className, $functionName, $args);
    }
}

if (!function_exists ("hook_getClassName")) {
    function hook_getClassName ($hookName, $returnString = false)
    {
        require_once DIR."Hook.php";
        $hook = new startphp\Hook\Hook();
        return $hook->getClassName ($hookName, $returnString);
    }
}

if (!function_exists ("hook_bind")) {
    function hook_bind ($hookName, $className)
    {
        global $hookClass;
        return $hookClass->bind ($hookName, $className);
    }
}

if (!function_exists ("getMainView")) {
    function getMainView ()
    {
        global $viewQueue;
        return $viewQueue->getMainView();
    }
}

if (!function_exists ("global")) {
    function globals ($vars)
    {
        if (isset($GLOBALS[$vars])) return $GLOBALS[$vars];
        else {
            $backtrace = debug_backtrace();
            $backtrace = array_shift($backtrace);
            new \ThrowError($backtrace['file'],$backtrace['line'],"EC100018");
        }

    }
}

if (!function_exists ("env")) {
    function env ($name,$default = "")
    {
        return \Env::get($name,$default);
    }
}

if (!function_exists ("config")) {
    function config ($name,$default = "")
    {
        global $config;
        return $config[$name] ?? $default;
    }
}

if (!function_exists ("model")) {
    function model ($modelClass)
    {
        return \Model::model($modelClass);
    }
}

if (!function_exists ("appPath")) {
    function appPath ()
    {
        return APP.globals("url")["app"].DS;
    }
}

if (!function_exists ("appClass")) {
    function appClass ()
    {
        return "app\\".globals("url")["app"];
    }
}

if (!function_exists ("parseGlobalUrl")) {
    function parseGlobalUrl ($saveInGlobal = false)
    {

        $parser = config('url_parser','startphp\urlParser\Start\Start');
        $parser = new $parser;
        if($saveInGlobal) global $url;
        $url = $parser->init();
        $url = $parser->parse($url);
        $parser->set($url);
        if($saveInGlobal) return $url;
        else return is_array ($url);
    }
}

if (!function_exists ("parseUrl")) {
    function parseUrl ($url)
    {
        $parser = config('url_parser','startphp\urlParser\Start\Start');
        $parser = new $parser;
        $url = $parser->parse($url);
        return $url;
    }
}

if (!function_exists ("lockPage")) {
    function lockPage ($content)
    {
        globals ('viewQueue')->getMainView ()->setContent ($content)->setProtect ();
    }
}