<?php
namespace Core\Utils;

/**
 * Redis工具类
 *
 * Usage :
 *   $redis = new Redis();
 *
 * @author hongker
 * @version 0.1
 */
class Redis extends \Redis{
	/**
	 * 服务器地址
	 */
	protected $server;
	/**
	 * 服务器端口号
	 */
	protected $port;

	/**
	 * 初始化连接
	 */
	public function __construct() {
		$this->connect();
	}

	/**
	 * 连接服务器
	 */
	public function connect() {
		$this->server = getenv("REDIS_PORT_6379_TCP_ADDR");
		$this->port = getenv("REDIS_PORT_6379_TCP_PORT");
		$this->pconnect($this->server, $this->port);
		//$this->auth('ace2016');
	}
}
