<?php
namespace core;
use core\http\Request;
use core\settings\utils\Object;
use core\settings\utils\Cache;
use \Exception;
/**
 *
 * @abstract
 * @package core
 * @version 0.1.6
 * @author Angel Barrientos <uetiko@gmail.com>
 */
abstract class Controller extends Object{

    private $module = NULL;
    private $request = NULL;
    private $cache  = null;
    private $pantilla = null;

    public function __construct($module, Request $request) {
        $this->module = $module;
        $this->request = $request;
        $this->cache = Cache::getInstance();
    }
    /**
     * Imprime la vista con los parametro
     * @param string $view
     * @param array $vars
     */
    protected final function render($view, array $vars = NULL) {
        $params = array();
        $view = $this->viewExists($view);
        if(is_null($view)){
            //no implement yet
        }
        try {
            $pantilla = $this->getViewToCache($view);
            if(!$pantilla){
                $pantilla = file_get_contents($view);
                $this->saveViewInCache($view, $pantilla);
            }
        } catch (Exception $exc) {
            error_log($exc->getTraceAsString(), 0);
        }

        if (settype($vars, 'array') && !is_null($vars)) {
            foreach ($vars as $key => $value) {
                $params["{{ $key }}"] = $value;
            }
            $pantilla = str_replace(array_keys($params), array_values($params), $pantilla);
        }
        print $pantilla;
    }
    /**
     * comprueba que la vista solicitada exista
     * @var string $view
     */
    private function viewExists($view) {
        $path = realpath(__DIR__ . "/../appmodules/{$this->module}/view/");
        $file = "$path/$view.html";
        if(file_exists($file)){
            return $file;
        }  else {
            return NULL;
        }
    }
    /**
     * Regresa el objeto core\http\Request
     * @return core\http\Request $request
     */
    protected function getRequest(){
        return $this->request;
    }

    private function saveViewInCache($view, $plantilla){
        $this->cache->setToCache($view,$plantilla, 'core', 15);
    }

    private function getViewToCache($view){
        return $this->cache->getToCache($view, 'core');
    }

    public function __destruct(){

    }

}