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

namespace startphp\format;

use startphp\Response;

class Json extends Response
{
    protected $vars = ['json_handler' => JSON_UNESCAPED_UNICODE];

    public function __construct ($content = "",$code = 200) {
        $this->init($content,$code);
    }

    public function print ($content)
    {
        return json_encode ($content,$this->vars['json_handler']);
    }
}