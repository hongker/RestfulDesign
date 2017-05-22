<?php
/**
 * Token操作类
 *
 * PHP version 7
 *
 * @category Util
 * @package  Core
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
namespace Core\Operations;
/**
 * Token Operation Class
 *
 * PHP version 7
 *
 * @category Util
 * @package  Core
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
class TokenOperation extends BaseOperation
{
    /**
     * 初始化
     *
     * @see \Core\Operations\BaseOperation::initialize()
     *
     * @return null
     */
    public function initialize()
    {
        parent::initialize();

        $this->setModel('Tokens');
    }

    /**
     * 获取
     * @param  [type]  $user_id [description]
     * @param  integer $expire  [description]
     * @return [type]           [description]
     */
    public function obtain($user_id,$role_id,$expire=7200)
    {
      session_start();
      session_regenerate_id();
      $sessionId = session_id();

      $roleOperation = new RoleOperation();
      $role = $roleOperation->get($role_id);

      $data = [
        'expire'=> $expire,
        'token' => $sessionId,
        'user_id' => $user_id,
        'auth' => $role->name
      ];

      $return = $this->add($data);
      $return['data'] = $data;

      return $return;
    }

    /**
     * 注销
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function logout($token)
    {
      $result = $this->findFirst("is_delete=0 and token='" . $token . "'");


      if($result) {
        var_dump($result);exit;
        if(!empty($result->logout_at)) {
          return false;
        }
        return $this->delete($result->id);
      }
      return false;
    }


}
