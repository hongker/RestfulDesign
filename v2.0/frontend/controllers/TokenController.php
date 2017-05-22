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
use Core\Operations\TokenOperation;
use Core\Operations\UserOperation;

class TokenController extends BaseController {

  /**
   * 初始化
   * @return [type] [description]
   */
  public function initialize()
  {
    parent::initialize();
    $this->operation = new TokenOperation();
  }

  /**
   * 验证
   * @return [type] [description]
   */
  public function loginAction()
  {
    $userOperation = new UserOperation();
    $userResult = $userOperation->auth($this->postData['username'],$this->postData['password']);

    if($userResult['errorNo']!=0) {
      $userResult['errorMsg'] = $this->getErrorMessage($userResult['errorNo']);
      $this->success($userResult);
    }


    $tokenResult = $this->obtainToken($userResult['data']['id'], $userResult['data']['role_id']);

    $tokenResult['errorMsg'] = $this->getErrorMessage($tokenResult['errorNo']);
    $this->success($tokenResult);

  }

  /**
   * 注销
   * @return [type] [description]
   */
  public function logoutAction()
  {
      $token = $this->session->get('token');
        if (false == $token) {
          parent::tokenError();
        }


        if (!empty($token['logout_at']))
            parent::tokenError();

        if($this->operation->logout($token['token']))
          parent::tokenError();

        $this->session->set('token',null); // 设置token为null
  }
}
