<?php
/**
 * Frontend模块入口文件
 *
 * PHP version 7
 *
 * @category Module
 * @package  Frontend
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link https://github.com/hongker
 */

namespace Frontend;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\DiInterface;

/**
 * Module Class
 *
 * PHP version 7
 *
 * @category Module
 * @package  Frontend
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
class Module implements ModuleDefinitionInterface
{
    /**
     * 注册自定义加载器
     *
     * @param Phalcon\DiInterface $dependencyInjector 依赖注入
     *
     * @return null
     */
    public function registerAutoloaders(DiInterface $dependencyInjector = null)
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            array(
                'Frontend\Controllers' => ROOT . '/frontend/controllers/',
                'Core\Models'      => ROOT . '/core/models/',
                'Core\Controllers' => ROOT . '/core/controllers/',
                'Core\Operations' => ROOT . '/core/operations/',
                'Core\Utils' => ROOT . '/core/utils/',
                //'Core\Security' => '../apps/core/security/',
                //'Core\Validators' => '../apps/core/validators/',
            )
        );
        $loader->register();
    }
    /**
     * 注册自定义服务
     *
     * @param Phalcon\DiInterface $di 依赖注入
     *
     * @return null
     */
    public function registerServices(DiInterface $di)
    {
        //Registering a dispatcher
        $di->set(
            'dispatcher',
            function () {
                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace("Frontend\Controllers");
                return $dispatcher;
            }
        );
        //Registering the view component
        $di->set(
            'view',
            function () {
                $view = new View();

                $view->setViewsDir(ROOT . '/frontend/views');

                return $view;
            }
        );
    }
}
