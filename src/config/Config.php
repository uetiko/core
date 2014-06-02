<?php
namespace config;
/**
 * Class Config
 * @package config
 * @author Angel Barrientos <uetiko@gmail.com>
 */
class Config {
    private $properties = null;
    static private $INSTANCE = null;

    private function __construct(){
        $this->properties = \spyc\Spyc::YAMLLoad(realpath(__DIR__ . '/../resources/Config.yml'));
    }

    static public function getInstance(){
        if(!self::$INSTANCE instanceof Config){
            self::$INSTANCE = new Config();
        }
        return self::$INSTANCE;
    }

    public function getEnviroment(){
        return $this->properties['config']['environment'];
    }
} 