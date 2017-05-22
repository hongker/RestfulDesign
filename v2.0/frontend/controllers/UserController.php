<?php
/**
 * Token控制器
 *
 * PHP version 7
 *
 * @category Module
 * @package  Frontend
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link https://github.com/hongker
 */
namespace Frontend\Controllers;
use Core\Operations\UserOperation;
class UserController extends BaseController {
  public function initialize()
  {
    parent::initialize();
    $this->operation= new UserOperation();


  }
  public function indexAction()
  {
    if(!$this->verifyToken($this->request->getHeader('token'))) {
      parent::tokenError();
    }
    echo 'user,list';
  }

  public function updateAction()
  {
    echo 'user,update,v2';
  }

  public function getAction()
  {

  }

  public function registerAction()
  {
    $return = $this->operation->register($this->postData);

    $return['errorMsg'] = $this->getErrorMessage($return['errorNo']);
    $this->success($return);
  }
}
