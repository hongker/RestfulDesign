<?php
/**
 * 用户操作类
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

use Phalcon\Http\Request;
use Phalcon\Security;
/**
 * User Operation Class
 *
 * PHP version 7
 *
 * @category Util
 * @package  Core
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
class UserOperation extends BaseOperation
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

        $this->setModel("Users");
    }

    /**
     * 验证用户合法性
     *
     * @param string $username 用户名
     * @param string $password 密码
     *
     * @return array
     */
    public function auth($username,$password)
    {
        $return['errorNo'] = 0;

        if (empty($username)) {
            $return['errorNo'] = 1001;
            return $return;
        }

        if (empty($password)) {
            $return['errorNo'] = 1002;
            return $return;
        }

        $user = $this->findFirst("username = '$username'");
        if (!$user) {
            $return['errorNo'] = 1007;
            return $return;
        }

        $security = $this->getSecurity();

        //验证密码是否正确
        if (!$security->checkHash($password, $user->password)) {
            $return['errorNo'] = 1008;
            return $return;
        }

        $return['data'] = [
          'id' => $user->id,
          'role_id' => $user->role_id
        ];

        return $return;
    }

    /**
     * 注册账号
     *
     * @param string $userData 用户信息
     *
     * @return array
     */
    public function register($userData)
    {
      if (empty($userData['username'])) {
          $return['errorNo'] = 1001;
          return $return;
      }

      if (empty($userData['password'])) {
          $return['errorNo'] = 1002;
          return $return;
      }

        $userData['role_id'] = isset($userData['role_id'])?$userData['role_id']:0;

        $user = $this->findFirst("username = '{$userData['username']}'");
        if ($user) {
            $return['errorNo'] = 1003;
            return $return;
        }

        $return = $this->_addUser($userData);

        return $return;
    }

    /**
     * 添加普通用户
     *
     * @param array $userData 用户数据
     *
     * @return array
     */
    private function _addUser(array $userData)
    {
        $security = $this->getSecurity();
        $userData['password'] = $security->hash($userData['password']);

        $return = $this->add($userData);

        // 其他操作...

        return $return;
    }

    /**
     * 根据用户姓名进行分页模糊查询
     */
    public function getUserInfobyName($name,$page){

        $data = array(
            'conditions' => "is_delete=0 and username like '%{$name}%'",
            'columns' => array('id', 'phone','name','username', 'last_ip','type','created_at'),
        );
        $info = $this->listData($data, $page);
        return $info;
    }

    /**
     * 添加users表信息
     */
    public function addUser($username,$phone,$pass,$type=1) {
        $securty = new Security();
        $request = new Request();

        $data['username'] = $username;
        $data['phone'] = $phone;
        $data['name'] = "操作员";
        $data['password'] = $securty->hash($pass);
        $data['type'] = $type;
        $data['last_ip']   = $request->getClientAddress();
        $return = $this->add($data);

        return $return;
    }

    /**
     * 更改密码
     *
     * @param string $phone
     * @param string $pass
     * @return number
     */
    public function changePass($username, $pass)
    {
        //验证用户是否存在
        $user = $this->findFirst("username = '$username' and is_delete=0");
        if(!$user) {
            $return['errorNo'] = 1007;
            return $return;
        }

        $security = $this->getSecurity();
        $data['password'] = $security->hash($pass);

        $return = $this->update($user->id, $data);
        return $return;
    }

    /**
     * 根据身份证获得年龄
     */
    public function getAgeByID($id_card){

        if(empty($id_card)) return '';
        $date=strtotime(substr($id_card,6,8));
        //获得出生年月日的时间戳
        $today=strtotime('today');
        //获得今日的时间戳
        $diff=floor(($today-$date)/86400/365);
        //得到两个日期相差的大体年数

        //strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比
        $age=strtotime(substr($id_card,6,8).' +'.$diff.'years')>$today?($diff+1):$diff;

        return $age;
    }

    /**
     * 根据用户id获取个人信息
     * @param int $user_id
     */
    public function getInfo($user_id)
    {
        $operation = new UsersinfoOperation();
        return $operation->findFirst("is_delete=0 and user_id = {$user_id}");
    }
}
