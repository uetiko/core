<?php
namespace core;
/**
 * Description of Register
 *
 * @author uetiko
 */
class Register {
    private $register = NULL;
    /**
     *
     * @var core\Register
     */
    private static $instance = NULL;
    
    private function __construct() {
        $this->register = new \ArrayObject(array());
    }
    
    final public function setRegister($K, $V){
        $this->register->offsetSet($K, $V);
    }
    
    final public function getRegister($k){
        if($this->register->offsetExists($K)){
            return $this->register->offsetGet($k);
        }else{
            return NULL;
        }
    }
    /**
     * 
     * @return core\Register
     */
    static final public function getInstance(){
        if(!self::$instance instanceof Register){
            self::$instance = new Register();
        }
        return self::$instance;
    }
}

?>
