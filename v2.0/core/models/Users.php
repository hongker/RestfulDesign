<?php
/**
 * 用户模型
 *
 * PHP version 7
 *
 * @category Model
 * @package  Core
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
namespace Core\Models;
/**
 * Users Class
 *
 * PHP version 7
 *
 * @category Model
 * @package  Core
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
class Users extends BaseModel
{
    /**
     * 初始化
     *
     * @return null
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * 映射表格
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

    /**
     * 生产token
     *
     * @return string
     */
    private function _createToken()
    {
        return substr(md5(uniqid(rand())), 8, 16);
    }

    /**
     * 插入前的操作
     *
     * @return null
     */
    public function beforeCreate()
    {
        parent::beforeCreate();

        $this->token = $this->_createToken();
    }

}
