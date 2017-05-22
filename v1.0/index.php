<?php
header ( "Content-type: text/html; charset=utf-8" );
date_default_timezone_set('Asia/Shanghai');
error_reporting(E_ALL); //显示错误级别

define('DEBUG', true); //定义是否调试模式
define('ROOT', dirname(__DIR__)); //定义根目录


/**
 * Class index
 * @author Edvard
 * @time 2015.12.14 12:13
 */
use Phalcon\Config\Adapter\Ini as ConfigIni;
use Phalcon\Mvc\Micro;
use Phalcon\Loader;
use Phalcon\Mvc\Micro\Collection as MicroCollection;
try {
    /**
     * 加载配置文件，db，memcache，debug，charset
     */
     /**
      * 引入系统常量
      */

     require_once __DIR__ . "/configs/constant.php";

     /**
      * 引入配置文件
      */
     require_once __DIR__ . "/configs/config.php";

     /**
      * 引入系统服务
      */
     require_once __DIR__ . "/configs/services.php";


    // 注册模块
    $loader = new Loader();
    $loader->registerDirs(
        array(
            __DIR__ . $config->application->modelsDir,
            __DIR__ . $config->application->behaviorsDir,
            __DIR__ . $config->application->validatorsDir,
            __DIR__ . $config->application->controllersDir
        )
    )->register();
    // 方便使用自定义组件
    $loader->registerNamespaces(array(
            "Public" => __DIR__ . "/controllers/public/",
            "Custom\\Models"  => __DIR__ . $config->application->modelsDir,
            "Custom\\Models\\Behaviors"  => __DIR__ . $config->application->behaviorsDir,
            "Custom\\Models\\Valiadtors"  => __DIR__ . $config->application->validatorsDir,
            "Custom\\Controllers"  => __DIR__ . $config->application->controllersDir
        )
    );


    $app = new Micro($di);


    /**
     * 路由配置
     */
    require_once __DIR__ . "/configs/routes.php";
    /**
     * 配置access control list
     */
    //include __DIR__ . "/config/acl_plugin.php";
    $app->handle();
} catch (Exception $e) {
    if (true == $config->debug) {
        echo var_dump($e);
    } else {
        echo "Exception: ", $e->getMessage();
    }
}
