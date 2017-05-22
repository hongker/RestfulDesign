<?php
/**
 * 基础控制器
 *
 * PHP version 7
 *
 * @category Controller
 * @package  Frontend
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
 namespace Frontend\Controllers;
 use Core\Controllers\Controller;
 use Core\Operations\TokenOperation;

/**
 * Base Controller Class
 *
 * PHP version 7
 *
 * @category Controller
 * @package  Frontend
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
class BaseController extends Controller
{
    protected $operation;
    protected $postData;

    private $_statuses = array(
        200 => 'OK',
        201 => 'CREATED',
        202 => 'ACCEPTED',
        204 => 'NO CONTENT',
        400 => 'INVALID REQUEST',
        401 => 'UNAUTHORIZED',
        403 => 'FORBIDDEN',
        404 => 'NOT FOUND',
        406 => 'NOT ACCEPTABLE',
        410 => 'GONE',
        422 => 'UNPROCESABLE ENTITY',
        500 => 'INTERNAL SERVER ERROR',
    );



    /**
     * 初始化
     *
     * @return null
     */
    protected function initialize()
    {

        parent::initialize();

        //获取移动端post提交的json并转换成数组

        $postString = file_get_contents('php://input');

        $this->postData = json_decode($postString, true);


    }

    /**
     * @param array $data
     * @param int $status
     * @return Response
     */
    public function response($data = array(), $status = 200)
    {

        $response = $this->response;
        $response->setStatusCode($status);
        $response->setContent(!empty($this->_statuses[$status]) ? $this->_statuses[$status] : null);
        $response->setHeader('Content-type', 'application/json');
        $response->setHeader('version', $this->config->version);

        $response->setJsonContent($data, JSON_PRETTY_PRINT);
        return $response->send();
    }

    /**
     * response以及返回错误信息
     * @param array $data
     * @param int $status
     */
    public function error($data = array(), $status = 406)
    {
        //$resData['errors'] = self::messagesToArray($data);
        self::response($data, $status);exit;
    }

    /**
     * @param array $data
     * @param int $status
     * @return Response
     */
    public function success($data = array(), $status = 200)
    {

        $this->response($data, $status);exit;
    }

    /**
     * 验证token
     * @param  [type]  $user_id [description]
     * @param  [type]  $role_id [description]
     * @param  integer $expire  [description]
     * @return [type]           [description]
     */
    public function obtainToken($user_id,$role_id,$expire=7200)
    {

      $operation = new TokenOperation();
      $return = $operation->obtain($user_id,$role_id,$expire);

      if($return['errorNo']==0) {
        // 存入session
        $this->session->set($return['data']['auth'], $return['data']);
      }
      return $return;

    }

    /**
     * 验证 token
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function verifyToken($token)
    {

      if (!empty($token)) {

            session_id($token);

            $cacheToken = $this->session->get('token'); //从session中取得token


            if (null == $cacheToken) {
                $operation = new TokenOperation();
                $cacheToken = $operation->findFirst("is_delete=0 and token='" . $token . "'");


                if (false == $cacheToken)
                    return false;
                else {
                    $cacheToken = $cacheToken->toArray();
                    $this->session->set('token', $cacheToken);  // 再次存进session中去
                }
            }

            $offset = time() - intval($cacheToken['expire']+$cacheToken['created_at']);

            if ($offset > 0) { // 过期
                $this->session->set('token', null);
                return false;
            }
            if (!empty($cacheToken['logout_at'])) { // 已经退出登录
                $this->session->set('token', null);
                return false;
            }
            return $cacheToken;
          }
      // 为空，直接返回false
      return false;
    }

    public function tokenError()
    {
      $return['errorNo'] = 110;
      $return['errorMsg'] = $this->getErrorMessage($return['errorNo']);
      $this->success($return);
    }




}
