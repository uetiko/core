<?php
namespace core\http;
/**
 * Description of Request
 *
 * @package core
 * @subpackage http
 * @version 0.1
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
}

?>
