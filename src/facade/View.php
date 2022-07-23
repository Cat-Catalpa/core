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

namespace startphp\Facade\View;

use startphp\Facade\Facade;

class View extends Facade
{
    public static function setFacade () {
        return "\startphp\View\View";
    }
}