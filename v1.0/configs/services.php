<?php
/**
 * 系统服务配置
 *
 * PHP version 7
 *
 * @category Config
 * @package  Configs
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */

use Phalcon\DI\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Security;


$di = new FactoryDefault();

/*
// 自定义路由
$di->set(
    'router',
    function () {
        $router = include ROOT."/apps/configs/routes.php";

        return $router;
    }
);

*/

/**
 * 保存配置到DI
 */
$di->set('config',$config);

// 建立flash服务
$di->set(
    'flash',
    function () {
        return new FlashDirect();
    }
);

/**
 * 设置数据库连接
 */
$di->set(
    'db',
    function () use ($config) {
        $connection = new DbAdapter(
            array(
                "host" => $config->database->host,
                "username" => $config->database->username,
                "password" => $config->database->password,
                "dbname" => $config->database->dbname,
                "charset" => $config->database->charset
            )
        );
        return $connection;
    }
);

$di->setShared(
    'session',
    function () {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    }
);

$di->set(
    'security',
    function () {
        $security = new Security();

        // Set the password hashing factor to 12 rounds
        $security->setWorkFactor(12);

        return $security;
    },
    true
);
