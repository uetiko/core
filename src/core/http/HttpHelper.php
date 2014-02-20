<?php

namespace core\http;

use core\Routing;
use core\http\Request;
use \Exception;
/**
 * Description of HttpHelper
 * @package core
 * @subpackage http
 * @version 0.1.1
 * @author Angel Barrientos <uetiko@nyxtechnology.com>
 */
class HttpHelper extends Routing {

    private static $INSTANCE = NULL;
    private static $post = NULL;
    private static $get = NULL;
    private static $server = NULL;
    private static $request = NULL;
    private static $files = NULL;

    public function __construct() {
        self::$post = $this->doNotTrustTheUser($_POST);
        self::$get = $this->doNotTrustTheUser($_GET);
        self::$request = $this->doNotTrustTheUser($_REQUEST);
        self::$server = $this->doNotTrustTheUser($_SERVER);
        self::$files = $_FILES;
        $this->routingPath();
        parent::__construct();
    }

    protected function routingPath() {
        if (key_exists('PATH_INFO', self::$server)) {
            self::$request['PATH_INFO'] = self::$server['PATH_INFO'];
        }  else {
            self::$request['PATH_INFO'] = self::$server['REQUEST_URI'];
        }
    }
    /**
     * Regresa una instancia de HttpHelper
     * @return HttpHelper
     */
    private function getInstance() {
        if (!self::$INSTANCE instanceof HttpHelper) {
            self::$INSTANCE = new HttpHelper();
        }
        return self::$INSTANCE;
    }

    protected function getRequest() {
        if(count(self::$get) > 0){
            self::$request['param'] = self::$get;
        }elseif(count(self::$post) > 0){
            self::$request['param'] = self::$post;
        }
        if(count(self::$files)){
            self::$request['file'] = self::$files;
        }
        return new Request(self::$request);
    }
    /**
     * 
     */
    final public function run() {
        $this->executeController($this->getRequest());
    }

    protected function executeController(Request $request) {
        $pathInfo = preg_split("/\?/", $request->getAttribute('PATH_INFO'));
        $defaults = $this->getDefaults($pathInfo[0]);
        if(is_null($defaults)){
            return NULL;
        }
        $arg = explode(':', $defaults['_controller']);
        $module = $arg[0];
        $controller = "\\appmodules\\" . $arg[0] . "\\controller\\" . $arg[1] . "Controller";
        $action = $arg[2] . "Action";
        $obj = new $controller($module, $request);
        $obj->$action();
    }

    /**
     * 
     * @param array $param
     * @return array
     */
    private function doNotTrustTheUser(array $param) {
        foreach ($param as $key => $value) {
            $result[$key] = htmlentities(strip_tags($value));
        }
        return $result;
    }
    /**
     * 
     * @return string
     */
    static public function getPublicDirectory($directoryPublic = TRUE){
        if($directoryPublic){
            return realpath(__DIR__."/../../../public");
        }  else {
            return realpath(__DIR__."/../../../");
        }
    }
    static public function getUrl(){
        return self::$server['SERVER_NAME'];
    }
    
    public function __destruct() {
        
    }
}

?>
