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

namespace startphp\Container;
use ReflectionClass;
class Container
{
    protected static $instance;

    protected $vars = [];

    public function bind ($key, $value): bool
    {
        $this->vars[$key] = $value;
        return isset($this->vars[$key]);
    }


    public function get ($key)
    {
        return $this->vars[$key] ?? false;
    }

    public function isset ($name,$value = "",$returnValue = false)
    {
        if(is_bool ($name) && $name && !empty($value)){
            if ($returnValue){
                return !is_bool (array_search ($value, $this->vars)) ? array_search ($value, $this->vars) : false;
            }else {
                return !is_bool (array_search ($value, $this->vars));
            }
        }
        elseif(!empty($name) && !is_bool ($name) && empty($value)){
            if ($returnValue) {
                return $this->vars[$name] ?? false;
            }else{
                return isset($this->vars[$name]);
            }
        }elseif(!empty($name) && !is_bool ($name) && !empty($value)) {
            if ($returnValue) {
                return isset($this->vars[$name]) && $this->vars[$name] == $value ? $this->vars[$name] : false;
            }else{
                return isset($this->vars[$name]) && $this->vars[$name] == $value;
            }
        }else{
            \ThrowError::throw(__FILE__,__LINE__,"EC100016","Name: ".$name." Value: ".$value." returnValue: ".$returnValue);
        }
    }

    public static function getInstance ()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        if (static::$instance instanceof Closure) {
            return (static::$instance)();
        }

        return static::$instance;
    }

    public function invokeClass ($class,$args = [])
    {
        try {
            $reflect = new ReflectionClass($class);
        } catch (ReflectionException $e) {
            \ThrowError::throw(__FILE__,__LINE__,"EC100017",$class);
        }
        if ($reflect->hasMethod('__make')) {
            $method = $reflect->getMethod('__make');
            if ($method->isPublic() && $method->isStatic()) {
                return $method->invokeArgs(null, $args);
            }
        }
        $constructor = $reflect->getConstructor();
        $args = $constructor ? $args : [];
        return $reflect->newInstanceArgs($args);
    }
}