<?php
/**
 * 路由配置
 *
 * PHP version 7
 *
 * @category Config
 * @package  Configs
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
use Phalcon\Mvc\Router;

$router = new Router(false);

$router->setDefaultModule('frontend');
$router->removeExtraSlashes(true);
$router->setDefaults(
    [
        "controller" => "Error",
        "action"     => "notFound",
    ]
);
/*
$router->add(
  '/user/update',
  array (
      'module' => 'frontend',
      'controller' => 'User',
      'action' => 'update',
      'params' => 3
  ),
  array()
);
$router->add(
  '/user/update',
  array (
      'module' => 'frontend',
      'controller' => 'User',
      'action' => 'index',
      'params' => 3
  )
)->via([
  'GET'
]);
*/


setRouter($router, 'frontend',[
  [
    'path' => '/login',
    'controller' => 'Token',
    'action' => 'login',
    'method' => ['POST']
  ],
  [
    'path' => '/logout',
    'controller' => 'Token',
    'action' => 'logout',
    'method' => ['DELETE']
  ],
  [
    'path' => '/register',
    'controller' => 'User',
    'action' => 'register',
    'method' => ['POST']
  ],
  [
    'path' => '/user',
    'controller' => 'User',
    'action' => 'index',
    'method' => ['GET']
  ],
  [
    'path' => '/user/{id:[0-9]+}',
    'controller' => 'User',
    'action' => 'get',
    'method' => ['GET'],
  ],
]);

function setRouter($router,$module, $requests){
  foreach ($requests as $request) {
    $router->add(
      $request['path'],
      array(
        'module' => $module,
        'controller' => $request['controller'],
        'action' => $request['action'],
        'params' => isset($request['params'])?$request['params']:1,
      ),
      $request['method']
    );
  }
}

/*
$router->add(
    '/:controller/:action/:params',
    array (
        'module' => 'frontend',
        'controller' => 1,
        'action' => 2,
        'params' => 3
    )
);


$router->add(
    '/admin',
    array (
        'module' => 'admin',
        'controller' => 'index',
        'action' => 'index'
    )
);
$router->add(
    '/admin/:controller',
    array (
        'module' => 'admin',
        'controller' => 1
    )
);
$router->add(
    '/admin/:controller/:action',
    array (
        'module' => 'admin',
        'controller' => 1,
        'action' => 2
    )
);
$router->add(
    '/admin/:controller/:action/:params',
    array (
        'module' => 'admin',
        'controller' => 1,
        'action' => 2,
        'params' => 3,
    )
);
*/

return $router;
