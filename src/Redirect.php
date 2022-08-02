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

class Redirect
{
    public function redirect ($targetUrl, $remember = false)
    {
        ob_end_clean ();
        if ($remember) {
            global $url;
            setcookie ("lastRedirectUrl", $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        }
        header ("Location: " . $targetUrl);
    }

    public function backoff ($remember = false)
    {
        $this->redirect ($_COOKIE['lastRedirectUrl'], $remember);
    }

    public static function setFacade ()
    {
        return "startphp\Redirect\Redirect";
    }
}