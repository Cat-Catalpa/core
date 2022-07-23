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

namespace startphp\format\AntiXSS;
class AntiXSS
{
    public function antiXss ($str)
    {
        //php防注入和XSS攻击通用过滤
        $_GET && $this->SafeFilter ($_GET);
        $_POST && $this->SafeFilter ($_POST);
        $_COOKIE && $this->SafeFilter ($_COOKIE);
        return $this->SafeFilter ($str);
    }

    function SafeFilter (&$arr)
    {
        $ra = ['/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '/script/', '/javascript/', '/vbscript/', '/expression/', '/applet/'
            , '/meta/', '/xml/', '/blink/', '/link/', '/style/', '/embed/', '/object/', '/frame/', '/layer/', '/title/', '/bgsound/'
            , '/base/', '/onload/', '/onunload/', '/onchange/', '/onsubmit/', '/onreset/', '/onselect/', '/onblur/', '/onfocus/',
            '/onabort/', '/onkeydown/', '/onkeypress/', '/onkeyup/', '/onclick/', '/ondblclick/', '/onmousedown/', '/onmousemove/'
            , '/onmouseout/', '/onmouseover/', '/onmouseup/', '/onunload/'];
        if (is_array ($arr)) {
            foreach ($arr as $key => $value) {
                if (!is_array ($value)) {
                    if (!get_magic_quotes_gpc ()) {
                        $value = addslashes ($value);
                    }

                    $arr[$key] = htmlentities (strip_tags ($value));
                } else {
                    $this->SafeFilter ($arr[$key]);
                }
            }
        }
        else{
            $arr = preg_replace ($ra, '', $arr);
        }
        return $arr;
    }
}