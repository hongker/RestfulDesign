<?php
/**
 * 基本操作类
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
 * Base Operation Class
 *
 * PHP version 7
 *
 * @category Util
 * @package  Core
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
abstract class BaseOperation
{
    
    private $_model;
    
    private $_methods = [];
    
    private $_conditons = [];
    
    /**
     * 构建方法
     * 
     * @return null
     */
    public function __construct()
    {
        $this->initialize();
        
    }
    
    /**
     * 设定model
     * 
     * @param string $model 模型名称
     * 
     * @return null
     */
    public function setModel($model)
    {
        /* You are not expected to understand this */
        $modelName = "Core\\Models\\$model";
        $this->_model = new $modelName();
    }
    
    /**
     * 获取模型
     * 
     * @return Model
     */
    public function getModel()
    {
        return $this->_model;
    }
    
    /**
     * 初始化
     * 
     * @return null
     */
    public function initialize()
    {
        
    }
    
    /**
     * 根据ID获取一条数据
     * 
     * @param int $id ID号
     * 
     * @return Object
     */
    public function get($id)
    {
        $model = $this->getModel();
        
        return $model::findFirst($id);
    }
    
    /**
     * 添加数据
     * 
     * @param array $data 数据
     * 
     * @return number
     */
    public function add(array $data)
    {
        $model = $this->getModel();
        
        $object = new $model();
        
        foreach ($data as $key=>$value) {
            $object->$key = $value;
        }
        if ($object->save()==true) {
            $return['errorNo'] = 0;
            $return['data']['id'] = $object->id;
        } else {
            foreach ($object->getMessages() as $message) {
                $return['errorNo'] = $message->getMessage();
            }
        }
        
        return $return;
    }
    
    /**
     * 删除数据
     * 
     * @param int $id ID号
     * 
     * @return boolean
     */
    public function delete($id)
    {
        $object = $this->get($id);
        
        if ($object != false) {
            if ($object->delete() != false) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * 更新数据
     * 
     * @param int   $id   ID号
     * @param array $data 数据
     * 
     * @return array
     */
    public function update($id, array $data)
    {
        $object = $this->get($id);

        if ($object) {
            foreach ($data as $key=>$value) {
                $object->$key = $value;
            }
            if ($object->update()==true) {
                $return['errorNo'] = 0;
            } else {
                $return['errorNo'] = 104;
            }
        } else {
            $return['errorNo'] = 101;
        }
        
        return $return;
    }
    
    /**
     * 获取分页数据
     * 
     * @param array  $data 数据项
     * @param number $page 当前页
     * @param number $row  每页行数
     * 
     * @return Object
     */
    private function _getPaginate($data, $page=1, $row=10)
    {
        $paginator = new \Phalcon\Paginator\Adapter\NativeArray(
            array(
                "data"  => $data,
                "limit" => $row,
                "page"  => $page
            )
        );
        
        $paginate = $paginator->getPaginate();
        
        return $paginate;
    }
    
    /**
     * 查询数据
     * 
     * @param array $conditions 查询条件
     * 
     * 数组下标参数说明：
     *  conditions 查询条件,默认查询所有 
     *      ex: "conditions" => "id=1"
     *  columns 指定返回字段名称,默认返回所有字段 
     *      ex: "columns" => array('id','name')
     *  limits 查询条数,默认返回所有数据 
     *      ex : "limits" => 5, //或者array(3,5)表示从第３条开始，获取５条数据
     *  
     *  @return Object
     */
    public function find(array $conditions = null)
    {
        $model = $this->getModel();
        
        return $model::find($conditions);
    }
    
    /**
     * 查找一条数据
     * 
     * @param id｜string $condition 给id或者string
     * 
     * ex:  findFist(1) 查询id为1数据
     *      findFirst("name='hongker'") 查询用户名为hongker的数据
     *      
     * @return Object
     */
    public function findFirst($condition)
    {
        $model = $this->getModel();
        
        return $model::findFirst($condition);
    }
    
    
    /**
     * 列表查询
     * 
     * @param array  $conditions  查询条件
     * @param number $currentPage 当前页数
     * @param number $row         行数
     * 
     * @return Object
     */
    public function listData(array $conditions=null, $currentPage = 1, $row = 10 )
    {
        $data = $this->find($conditions);
        if ($data) {
            $data = $data->toArray();
        }
    
        $paginate = $this->_getPaginate($data, $currentPage, $row);
    
        return $paginate;
    }
    
    /**
     * 根据查询条件获取数量
     * 
     * @param array $conditions 查询条件
     * 
     * @return int
     */
    public function count(array $conditions)
    {
        $model = $this->getModel();
        $count = $model::count($conditions);
        
        return $count;
    }
    
    /**
     * 获取安全类
     * 
     * @return Phalcon\Security
     */
    public function getSecurity()
    {
        $security = new \Phalcon\Security();
        
        // Set the password hashing factor to 12 rounds
        $security->setWorkFactor(12);
        
        return $security;
    }
    
    /**
     * 获取施工单位信息
     *
     * @param int $id
     */
    public function getTeam($id)
    {
        $operation = new TeamOperation();
    
        return $operation->get($id);
    }
    
    /**
     * 获取项目信息
     *
     * @param int $id
     */
    public function getProject($id)
    {
        $operation = new ProjectOperation();
    
        return $operation->get($id);
    }
    
    /**
     * 获取合同信息
     *
     * @param int $id
     */
    public function getContract($id)
    {
        $operation = new ContractOperation();
    
        return $operation->get($id);
    }
    
    /**
     * 获取工程信息
     * @param unknown $id
     */
    public function getConstruction($id)
    {
        $operation = new ConstructionOperation();
        
        return $operation->get($id);
    }
    
    /**
     * 根据region_code 返回名字
     */
    public function getRegoin($code){
        
        $operation = new RegoinOperation();
        
        return $operation->get($code);
    }
    
    /**
     * 根据id获得材料入库单价
     */
    public function MaterialgetPriceByid($id){
        
        $operation = new MaterialOperation();
        return $operation->get($id);
        
    }
    
    /**
     * 初始化查询条件
     * 
     * @return void
     */
    public function initializeConditions()
    {
        $this->_conditons = [
            "conditions" => "is_delete=0 "
        ];
    }
    
    /**
     * 添加等于查询条件
     * @param array $conditions
     * 
     * @return void
     */
    public function addEqualConditions(array $conditions)
    {
        foreach ($conditions as $key => $item) {
            $this->_conditons['conditions'] .= "and {$key} = '{$item}' ";
        }
    }
    
    public function setColumns(array $columns)
    {
        $this->_conditons['columns'] = $columns;
    }
}