<?php
/**
 * 项目操作类
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
 * Project Operation Class
 *
 * PHP version 7
 *
 * @category Util
 * @package  Core
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
class ProjectOperation extends BaseOperation
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
        
        $this->setModel('Projects');
    }
    
}