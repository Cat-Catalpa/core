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

namespace startphp\format\Jsonp;

use startphp\Response\Response;

class Jsonp extends Response
{
    protected $vars = [
        'json_handler' => JSON_UNESCAPED_UNICODE,
        'var_jsonp_handler'     => 'callback',
        'default_jsonp_handler' => 'jsonpReturn',
    ];

    public function __construct ($content = "",$code = 200) {
        $this->init($content,$code);
    }

    public function print ($content): string
    {
        $jsonpHandler = $this->vars['var_jsonp_handler'];
        $handler = !empty($jsonpHandler) ? $jsonpHandler : $this->vars['default_jsonp_handler'];
        $data = json_encode($content, $this->vars['json_handler']);
        return $handler . '(' . $data . ');';
    }
}