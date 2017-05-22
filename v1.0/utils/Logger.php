<?php
namespace Core\Utils;

use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Logger\Formatter\Line as LineFormatter;
use Phalcon\Logger as PhalconLogger;

/**
 * 日志记录类
 * 
 * Usage:
 *  Logger::info($string)
 *  Logger::error($string)
 * 
 * @author hongker
 * @version 1.0
 */
class Logger {
    
    /**
     * @var FileLogger
     */
    private static $logger;
    
    
    /**
     * 初始化，设定日志文件，格式：common.log
     * 
     * @param string $logFile
     */
    public function __construct() {
        throw \Exception("Error:Class can not be instantiation");
    }
    
    /**
     * 初始化
     * @param string $logFile
     */
    private static function init($logFile) {
        self::$logger = new FileLogger(LOG_DIR.$logFile);
        
        $lineFormatter = new LineFormatter();
        $lineFormatter->setDateFormat('Y-m-d H:i:s');
        self::$logger->setFormatter($lineFormatter);
    }
    
    /**
     * 记录普通日志
     * @param string $string
     */
    public static function info($string, $logFile='common.log') {
        self::init($logFile);
        self::$logger->log ( $string, PhalconLogger::INFO);
    }
    
    /**
     * 记录错误日志
     * @param unknown $string
     */
    public static function error($string, $logFile='common.log') {
        self::init($logFile);
        self::$logger->log ( $string, PhalconLogger::INFO);
    }
}