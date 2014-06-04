<?php
/**
 * Created by PhpStorm.
 * User: uetiko
 * Date: 30/05/14
 * Time: 22:31
 */

namespace core\settings\utils;
use core\settings\utils\Object;

/**
 * Class Cache
 * @package core\settings\utils
 * @author Angel Barrientos <uetiko@gmail.com>
 * @version 0.1
 */
class Cache extends Object{
    /**
     * @var Cache
     */
    static private $INSTANCE = NULL;
    /**
     * @var \Memcache
     */
    protected $memcache = null;

    private final function __construct(){
        $this->memcache = new \Memcache();
        $this->memcache->pconnect('localhost', 11211);
    }

    /**
     * @return Cache
     */
    static public function getInstance(){
        if(!self::$INSTANCE instanceof Cache){
            self::$INSTANCE = new Cache();
        }
        return self::$INSTANCE;
    }

    /**
     * @param $k key
     * @param $v value
     * @param $prefix prefix to key
     * @param null $expirtion time in seconds
     */
    final public function setToCache($k,$v, $prefix, $expirtion = null){
        if(is_null($expirtion)){
            $expirtion = 0;
        }
        return $this->memcache->set("{$prefix}_{$k}", $v, false, $expirtion);
    }

    /**
     * @param $K
     * @param $prefix
     * @return array|string
     */
    final public function getToCache($K, $prefix){
        return $this->memcache->get("{$prefix}_{$K}");
    }
    final public function __destruct(){
        try{
            $this->memcache->close();
        }catch (\Exception $e){
            error_log($e->getTraceAsString(), 0);
        }
    }
}
