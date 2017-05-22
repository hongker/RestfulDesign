<?php
/**
 * Admin模块入口文件
 *
 * PHP version 7
 *
 * @category Module
 * @package  Admin
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */

namespace Admin;

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
 * @package  Admin
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
                'Admin\Controllers' => '../apps/admin/controllers/',
                'Core\Models'      => '../apps/core/models/',
                'Core\Controllers' => '../apps/core/controllers/',
                'Core\Utils' => '../apps/core/utils/',
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
                $dispatcher->setDefaultNamespace("Admin\Controllers");
                return $dispatcher;
            }
        );
        //Registering the view component
        $di->set(
            'view', 
            function () {
                $view = new View();
                
                $view->setViewsDir('../apps/admin/views/');
                
                $view->registerEngines(
                    array(
                        ".html" => function ($view, $di) {
                            $volt = new Volt($view, $di);
                    
                            $volt->setOptions(
                                array(
                                    "compiledPath" => function ($templatePath) {
                                        $dirName = ROOT . '/apps/cache/';
                                        if (! is_dir($dirName)) {
                                            mkdir($dirName);
                                        }
                                        
                                        $templatePath = str_replace('/', '%', $templatePath);
                                        return $dirName . $templatePath . '.php';
                                    }
                                )
                            );
                            $compiler = $volt->getCompiler();
                            $compiler->addFunction('explode', 'explode');
                            $compiler->addFunction('in_array', 'in_array');
                            $compiler->addFunction('isset', 'isset');
                            $compiler->addFunction('array_key_exists', 'array_key_exists');
                            return $volt;
                        }
                    )
                );
                
                return $view;
            }
        );
    }
}