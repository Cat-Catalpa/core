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

return[
    //系统报错警告语句
    'EC100001'                             =>                              '路由解析错误：无法获取Url信息',
    'EC100002'                             =>                              '自动加载错误：要引入的文件不存在',
    'EC100003'                             =>                              '数据库错误：数据库连接错误',
    'EC100004'                             =>                              '数据库错误：指定的主键字段不存在',
    'EC100005'                             =>                              '数据库错误：指定的数据表不存在',
    'EC100006'                             =>                              '路由解析错误：文件名后缀冗杂',
    'EC100007'                             =>                              '参数错误：提供的参数量过少',
    'EC100008'                             =>                              '系统错误：fopen()函数执行失败',
    'EC100009'                             =>                              '控制器错误：控制器返回值不能为空',
    'EC100010'                             =>                              '视图模板错误：方法不存在',
    'EC100011'                             =>                              '视图模板错误：视图对象不存在',
    'EC100012'                             =>                              '视图模板错误：视图名不能为空',
    'EC100013'                             =>                              '自动加载错误：未匹配到有效顶级命名空间',
    'EC100014'                             =>                              '自动加载错误：未定义的顶级命名空间',
    'EC100015'                             =>                              '请求错误：在路由解析被引入前无法解析url信息',
    'EC100016'                             =>                              '容器错误：has()函数传入的参数格式错误',
    'EC100017'                             =>                              '容器错误：指定的Class不存在',
    'EC100018'                             =>                              '助手函数错误：指定的全局变量不存在',
    'EC100019'                             =>                              '视图模板错误：指定的模板引擎不存在',
    'EC100020'                             =>                              '路由解析错误：指定的控制器文件或函数不存在',
    'EC100021'                             =>                              '助手函数错误：指定的函数不存在',
    'EC100022'                             =>                              '模板引擎错误：if条件标签语法错误',

    //开发模式信息提示
    'system_operation'                     =>                              '系统运行情况',
    'system'                               =>                              '系统',
    'running_time'                         =>                              '运行时间',
    'throughput'                           =>                              '吞吐率',
    'require_info'                         =>                              '请求信息',
    'server_info'                          =>                              '服务器信息',
    'framework_version'                    =>                              '框架版本',
    'php_version'                          =>                              'PHP版本',
    'zend_version'                         =>                              'Zend版本',
    'client_version'                       =>                              '客户端信息',
    'interface_type'                       =>                              '接口类型',
    'process_id'                           =>                              '进程ID',
    'index_node'                           =>                              '进程节点',
    'memory'                               =>                              '内存',
    'initial_memory'                       =>                              '内存',
    'current_state'                        =>                              '当前状态',
    'total_consumption'                    =>                              '共计消耗',
    'peak_occupancy'                       =>                              '峰值占用',
    'cpu_state'                            =>                              'CPU状态',
    'has_been_run'                         =>                              '框架运行状态',
    'something_wrong'                      =>                              '嗯...似乎有什么地方出错了...',
    'ru_oublock'                           =>                              '块输出操作',
    'ru_inblock'                           =>                              '块输入操作',
    'ru_msgsnd'                            =>                              '发送的message',
    'ru_msgrcv'                            =>                              '收到的message',
    'ru_maxrss'                            =>                              '最大驻留集大小',
    'ru_ixrss'                             =>                              '全部共享内存大小',
    'ru_idrss'                             =>                              '全部非共享内存大小',
    'ru_minflt'                            =>                              '页回收',
    'ru_majflt'                            =>                              '页失效',
    'ru_nsignals'                          =>                              '收到的信号',
    'ru_nvcsw'                             =>                              '主动上下文切换',
    'ru_nivcsw'                            =>                              '被动上下文切换',
    'ru_nswap'                             =>                              '交换区',
    'ru_utime.tv_usec'                     =>                              '用户态时间',
    'ru_utime.tv_sec'                      =>                              '用户态时间',
    'ru_stime.tv_usec'                     =>                              '系统内核时间',
    'ru_stime.tv_sec'                      =>                              '系统内核时间',

    //命令行信息提示
    'cache_clear_start'                    =>                              '正在清理框架缓存...',
    'cache_clear_successful'               =>                              '缓存清理成功',
    'has_been_cleared_files_prefix'        =>                              '本次共清理了',
    'has_been_cleared_files_suffix'        =>                              '个文件/文件夹：',

    //其他提示
    'unable_get_file_content'              =>                              '未知错误：无法获取到该文件内容'
    ];