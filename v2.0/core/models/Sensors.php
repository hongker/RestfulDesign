<?php
/**
 * 终端设备模型
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
 * Sensors Class
 *
 * PHP version 7
 *
 * @category Model
 * @package  Core
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
class Sensors extends BaseModel
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
        return 'sensors';
    }

}
