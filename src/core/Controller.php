<?php
namespace core;

use \Exception;
/**
 * 
 * @abstract
 * @package core
 * @version 0.1
 * @author Angel Barrientos <uetiko@nyxtechnology.com>
 */
abstract class Controller {

    private $module = NULL;

    public function __construct($module) {
        $this->module = $module;
    }
    /**
     * 
     * @param string $view
     * @param array $vars
     */
    protected final function render($view, array $vars = NULL) {
        $params = array();
        try {
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        $view = $this->viewExists($view);
        $pantilla = file_get_contents($view);
        if (settype($vars, 'array') && !is_null($vars)) {
            foreach ($vars as $key => $value) {
                $params["{{ $key }}"] = $value;
            }
            $pantilla = str_replace(array_keys($params), array_values($params), $pantilla);
        }
        print $pantilla;
    }

    private function viewExists($view) {
        $path = realpath(__DIR__ . "/../appmodules/{$this->module}/view/");
        $file = "$path/$view.html";
        if(file_exists($file)){
            return $file;
        }  else {
            return NULL;
        }
    }

}

?>