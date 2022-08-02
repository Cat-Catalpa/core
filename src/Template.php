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

class Template
{
    public function getTemplateContent ($fileName, $returnContent = true)
    {
        $path = TEMPLATES . $fileName . config('template_suffix');
        if ($returnContent) return file_get_contents ($path);
        else {
            return file_get_contents ($path);
        }
    }
}