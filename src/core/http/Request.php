<?php
namespace core\http;
/**
 * Description of Request
 *
 * @package core
 * @subpackage http
 * @version 0.1.13
 * @author Angel Barrientos <uetiko@nyxtechnology.com>
 */
class Request {
    private $attributes = NULL;
    public function __construct(array $request) {
        $this->attributes = $request;
    }
    
    public function getAttribute($k){
        return $this->attributes[$k];
    }
    public function getArrayAttributes(){
        return $this->attributes;
    }

    public function getServerUrl(){
        return "http://{$_SERVER['SERVER_NAME']}";
    }
    
    public function getRedirectUrl(){
        return $_SERVER['REDIRECT_URL'];
    }

    public function setRedirectUrl($url){
        $_SERVER['REDIRECT_URL'] = $url;
    }

    public function getRequestUrl(){
        return $_SERVER['REQUEST_URI'];
    }
}

?>
