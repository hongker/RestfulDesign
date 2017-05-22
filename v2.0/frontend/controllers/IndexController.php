<?php
namespace Frontend\Controllers;

class IndexController extends BaseController {
  public function indexAction()
  {
    echo 'public,index,v2';
  }

  /**
   * 验证
   * @return [type] [description]
   */
  public function login()
  {
    echo 'login';
  }

  /**
   * 注销
   * @return [type] [description]
   */
  public function logout()
  {
    echo 'logout';
  }
}
