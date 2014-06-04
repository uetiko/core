<?php
namespace core;
use core\http\Request;
use core\settings\utils\Cache;
use config\Config;
use core\settings\utils\Object;
use \Exception;
/**
 *
 * @abstract
 * @package core
 * @version 0.1.6
 * @author Angel Barrientos <uetiko@nyxtechnology.com>
 */
abstract class Controller extends Object{

    private $module = NULL;
	private $request = NULL;
    private $cache  = null;
    private $pantilla = null;
    /**
     * @var \config\Config
     */
    private $conf = null;

    public function __construct($module, Request $request) {
        $this->module = $module;
		$this->request = $request;
        $this->cache = Cache::getInstance();
        $this->conf = Config::getInstance();
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
            header("HTTP/1.0 404 Not Found");
        }
        if (settype($vars, 'array') && !is_null($vars)) {
            foreach ($vars as $key => $value) {
                $params["{{ $key }}"] = $value;
            }
            $pantilla = str_replace(array_keys($params), array_values($params), $this->getView($view));
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
        return $this->cache->setToCache($view,$plantilla, 'core', 0);
    }

    private function getViewToCache($view){
        return $this->cache->getToCache($view, 'core');
    }

    /**
     * @param $view
     * @return array|null|string
     */
    private function getView($view){
        $pantilla = '';
        switch(true){
            case 'devel' == $this->conf->getEnviroment():
                $pantilla = file_get_contents($view);
                break;
            case 'prod' == $this->conf->getEnviroment():
                $pantilla = $this->getViewToCache($view);
                if(!$pantilla){
                    $pantilla = file_get_contents($view);
                    $pantilla = $this->saveViewInCache($view, $pantilla);
                    $pantilla = $this->getViewToCache($view);
                }
                break;
        }
        return $pantilla;
    }

	public function __destruct(){

	}
}