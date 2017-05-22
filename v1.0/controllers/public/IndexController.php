<?php
namespace Public;

class IndexController extends BaseController {
  public function index()
  {
    echo 'public,index';
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
