<?php
namespace Public\Controllers;
/**
 * 基础控制器
 *
 * PHP version 7
 *
 * @category Controller
 * @package  Frontend
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */


/**
 * Base Controller Class
 *
 * PHP version 7
 *
 * @category Controller
 * @package  Frontend
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
class BaseController extends \Phalcon\Mvc\Controller
{
    protected $operation;

    /**
     * 初始化
     *
     * @return null
     */
    protected function initialize()
    {

        parent::initialize();

    }

    /**
  	 * 输出json数据
  	 * @param array $array
  	 */
  	public function jsonReturn(Array $array) {
  	    $array['responseTime'] = time();
  		  echo json_encode($array);exit;
  	}


}
