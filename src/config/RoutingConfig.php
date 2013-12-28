<?php
namespace config;
use spyc\Spyc;

/**
 * Description of RoutingConfig
 *
 * @author uetiko
 */
class RoutingConfig {
    private $propertie = NULL;
    
    public function __construct() {
        $this->propertie = Spyc::YAMLLoad(realpath(__DIR__ . '/../resources/routing.yml'));
    }
    
    public function getPropeties(){
        return $this->propertie;
    }
    
    static public function getRoutingRules(){
        return Spyc::YAMLLoad(realpath(__DIR__ . '/../resources/routing.yml'));
    }
}

?>
