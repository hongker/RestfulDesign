<?php
/**
 * 入口文件
 *
 * PHP version 7
 *
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link https://github.com/hongker
 */
header ( "Content-type: text/html; charset=utf-8" );
date_default_timezone_set('Asia/Shanghai');
error_reporting(E_ALL); //显示错误级别

define('DEBUG', true); //定义是否调试模式
define('ROOT', __DIR__); //定义根目录

try {
    /**
     * 引入系统常量
     */
    require_once ROOT . "/configs/constant.php";

    /**
     * 引入配置文件
     */
    require_once ROOT . "/configs/config.php";

    /**
     * 引入系统服务
     */
    require_once ROOT . "/configs/services.php";

	// 创建应用
	$application = new \Phalcon\Mvc\Application ( $di );

	// 注册模块
	$application->registerModules ( array (
	       'frontend' => array (
	            'className' => 'Frontend\Module',
	           'path' => ROOT . '/frontend/Module.php'
	         ),

	       'admin' => array (
	           'className' => 'Admin\Module',
	           'path' => ROOT . '/admin/Module.php'
	       ),
	) );
	// 处理请求
	echo $application->handle ()->getContent ();

} catch ( \Exception $e ) {
    if(DEBUG) {
        echo $e->getMessage ();
    }else {
        //提示404
        echo 'your request is not found..';
    }
}
