<?php
namespace Core\Controllers;
use Phalcon\Tag;

/**
 * 公共控制器
 * @author hongker
 * @version 1.0
 */
class Controller extends \Phalcon\Mvc\Controller {
	/**
	 * 模块名称
	 * @var string
	 * @acccess protected
	 */
	protected $module;

	/**
	 * 控制器名称
	 * @access protected
	 */
	protected $controller;

	/**
	 * 方法名称
	 * @access protected
	 */
	protected $action;

	/**
	 * 操作类名称
	 * @access protected
	 */
	protected $operation ;

	protected $errors;

	protected $url;

	/**
	 * 初始化
	 */
	protected function initialize() {
		$this->view->setVar('action',$this->action);
		$this->view->setVar('controller',$this->controller);
		$this->view->setVar('module',$this->module);

		/**
		 * 引入错误提示信息
		 */
		$this->errors = require_once ROOT . "/configs/error.php";


		$this->url = '/'.$this->module.'/'.$this->controller.'/'.$this->action;

		$this->view->setVar('url',$this->url);
	}

	/**
	 * @param unknown $dispatcher
	 */
	public function beforeExecuteRoute($dispatcher) {
		$this->module = $dispatcher->getModuleName();
		$this->controller = $dispatcher->getControllerName();
		$this->action = $dispatcher->getActionName();

	}

	/**
	 * 输出json数据
	 * @param array $array
	 */
	public function jsonReturn(Array $array) {
	    $array['responseTime'] = time();
		  echo json_encode($array);exit;
	}

	/**
	 * 获取GET数据
	 * @param string $param
	 * @param string $type
	 */
	protected function getQuery($param,$type='string') {
		return $this->request->getQuery($param,$type);
	}

	/**
	 * 获取POST数据
	 * @param string $param
	 * @param string $type
	 */
	protected function getPost($param=null,$type='string') {
		if($type==false) {
			return $this->request->getPost($param);
		}else {
			return $this->request->getPost($param,$type);
		}
	}

	/**
	 * 判断是否上GET请求
	 */
	protected function isGet() {
		return $this->request->isGet();
	}

	/**
	 * 判断是否上POST请求
	 */
	protected function isPost() {
		return $this->request->isPost();
	}

	/**
	 * 跳转到404页面
	 */
	public function show404() {
		$this->response->redirect('404.html');
		$this->response->send();
	}

	/**
	 * 根据错误编号获取错误信息
	 * @param int $no
	 * @return string
	 */
	protected function getErrorMessage($no) {
	    if(isset($this->errors[$no]))
		  return $this->errors[$no];
	    else
	     return $this->errors[-1];
	}

	/**
     * 设置前置标题
     *
     * @param string $title 标题名称
     *
     * @return null
     */
    public function prependTitle($title)
    {
        Tag::prependTitle($title);
    }

    /**
     * 设置后置标题
     *
     * @param string $title 标题名称
     *
     * @return null
     */
    public function appendTitle($title)
    {
        Tag::appendTitle($title);
    }

    /**
     * 加密
     *
     * @param string $content
     *
     * @return string
     */
    public function encrypt($content)
    {
        $crypt = new \Phalcon\Crypt();
        return $crypt->encryptBase64($content, $this->key);
    }

    /**
     * 解密
     *
     * @param string $encrypted
     *
     * @return string
     */
    public function decrypt($encrypted)
    {
        $crypt = new \Phalcon\Crypt();
        return $crypt->decryptBase64($encrypted, $this->key);
    }

    /**
     * 跳转
     *
     * @param string $url
     */
    public function redirect($url) {
        header("Location: $url");
    }

		/**
		 * 获取参数
		 * @param  [type] $param [description]
		 * @return [type]        [description]
		 */
		protected function getParam($param) {
      return $this->dispatcher->getParam($param);
    }


}
