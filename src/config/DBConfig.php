<?php

namespace config;

/**
 * Description of DBConfig
 *
 * @author uetiko
 */
class DBConfig {

    private $properties = NULL;

    /**
     *
     * @var \config\ConfigDB
     */
    private $INSTANCE = NULL;

    private function __construct() {
        $this->properties = \spyc\Spyc::YAMLLoad(realpath(__DIR__ . '/../resources/DBConfig.yml'));
    }

    public function getStringConnection() {
        return "{$this->getDatabaseDriver()}: host={$this->getHost()};dbname={$this->getDBName()};charset={$this->getEncode()}";
    }

    /**
     * @return string Cadena de conexión para pdo.
     */
    public function getDatabaseDriver() {
        return $this->properties['base']['driver'];
    }

    /**
     * @return string Nombre de la base de datos.
     */
    public function getHost() {
        return $this->properties['base']['host'];
    }

    public function getPort() {
        return$this->properties['base']['puerto'];
    }

    /**
     * @return string Nombre de la base de datos
     */
    public function getDBName() {
        return $this->properties['base']['dbname'];
    }

    /**
     * @return string Nombre del usuario de la base de datos
     */
    public function getUser() {
        return $this->properties['base']['usuario'];
    }

    /**
     * @return string Password de la base de datos.
     * @access public
     */
    public function getPassword() {
        return $this->properties['base']['passwd'];
    }

    public function getEncode() {
        return $this->properties['base']['charset'];
    }

    /**
     * @access private
     */
    public function __destruct() {
        $this->properties = NULL;
    }

    /**
     * 
     * @return \config\ConfigDB Instancia de la clase ConfigDB
     */
    public static function getInstance() {
        if (!(self::$INSTANCE instanceof \config\DBConfig)) {
            self::$INSTANCE = new \config\DBConfig();
        }
        return self::$INSTANCE;
    }

}

?>
