<?php
/**
 * 数据库配置
 *
 * PHP version 7
 *
 * @category Config
 * @package  Configs
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
use Phalcon\Config;

$settings = array(
    "database" => array(
        "adapter"  => "Mysql",
        "host"     => getenv("DB_PORT_3306_TCP_ADDR"),
        "username" => "root",
        "password" => getenv("DB_ENV_MYSQL_ROOT_PASSWORD"),
        "dbname"   => getenv("DB_ENV_MYSQL_DATABASE"),
        "charset"  => "utf8",
    ),
    'debug' => true,
    'application' => array(
        'controllersDir' => '/controllers',
        'modelsDir' => '/models',
        'behaviorsDir'   => '/models/behaviors',
        'validatorsDir'  => '/models/validators'
    ),

);

$config = new Config($settings);
