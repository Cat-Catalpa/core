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
class Run
{
    function __construct ()
    {

        //记录所有输出，以便在错误捕获后清空页面所有已渲染元素
        ob_start ();

        //定义全局变量
        global $hasBeenRun, $memoryAnalysis, $viewQueue,$url;

        //记录系统运行状态
        $hasBeenRun['init'] = " - System_Init";

        //引入必要配置文件
        require_once dirname (__DIR__) . '/./config/Config.php';

        //初始化路由解析机制
        parseGlobalUrl (true);

        //渲染页面
        global $pageContent;
        $content = $viewQueue->getMainView ()->render ();

        //系统启动完成
        $hasBeenRun['end'] = " - System_Init_End";
        hook_getClassName ("appDestroy")->transfer ([$memoryAnalysis]);
        if (env('system.debug.mode',false)) {
            $memoryAnalysis->output ();
        }
    }
}