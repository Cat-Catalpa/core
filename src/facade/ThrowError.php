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

namespace startphp\Facade\Error;
use startphp\Facade\Facade;

class ThrowError extends Facade
{
    public static function setFacade () {
        return "\startphp\Error\ThrowError";
    }
}