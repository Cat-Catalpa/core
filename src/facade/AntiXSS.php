<?php
// +----------------------------------------------------------------------
// | StartPHP
// +----------------------------------------------------------------------
// | Copyright (c) 20021~2022 Cat Catalpa Vitality All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: company@catcatalpa.com
// +----------------------------------------------------------------------
//请求执行时实现反XSS注入

namespace startphp\Facade;

use startphp\Facade;

class AntiXSS extends Facade
{
    public static function setFacade () {
        return "\startphp\AntiXSS";
    }
}