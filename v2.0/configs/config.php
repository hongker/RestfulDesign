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
        "host"     => "localhost",
        "username" => "root",
        "password" => "hongker",
        "dbname"   => "restful",
        "charset"  => "utf8",
    ),
    'debug' => true,
    'version' => '2.0'

);

$config = new Config($settings);
