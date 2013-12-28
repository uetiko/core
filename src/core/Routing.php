<?php
namespace core;
use config\RoutingConfig;
use core\http\Request;
/**
 * Description of Routing
 *
 * @author uetiko
 */
class Routing {
    /**
     *
     * @var array
     */
    private $rules = NULL;
    protected function __construct() {
        $this->rules = RoutingConfig::getRoutingRules();
    }
    
    protected function findRoutingRule(Request $request){
        foreach ($this->rules as $value) {
            if(in_array($request->getAttribute('PATH_INFO'), $value)){
                return $value;
            }
        }
    }
    
    protected function getDefaults($pattern){
        foreach ($this->rules as $value) {
            if(in_array($pattern, $value)){
                return $value['defaults'];
            }
        }
    }
}

?>
