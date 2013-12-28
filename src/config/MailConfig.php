<?php
namespace config;

 /**
 * Clase de configuración basica para envío de
 * correo electrónico por medio del protocolo
 * SMTP
 * @package Config
 * @author Angel Barrientos 
 * @copyright 2013
 * @license http://www.gnu.org/copyleft/lesser.html Distributed under the Lesser General Public License (LGPL)
 * @version 0.1
 */
class MailConfig {

    private $properties = NULL;
    private static $INSTANCE = NULL;
    /**
     * @access private
     */
    private function __construct() {
        $this->properties = \spyc\Spyc::YAMLLoad(realpath(__DIR__ .'/../resources/MailConfig.yml'));
    }
    /**
     * @access public
     * @return Object \Config\MailConfig
     */
    public static function getInstance() {
        if(self::$INSTANCE instanceof \config\MailConfig){
            return self::$INSTANCE;
        }else{
            return self::$INSTANCE = new \config\MailConfig();
        }
    }
    /**
     * @access public
     * @return string nombre de usuario
     */
    public function getUsuarioPrueba() {
        return $this->properties['correo']['prueba']['usuario'];
    }
    /**
     * 
     * @return sting
     */
    public function getUsuarioInfo(){
        return $this->properties['correo']['info']['usuario'];
    }
    /**
     * 
     * @return sting
     */
    public function getUsuarioNewsletter(){
        return $this->properties['correo']['newsletter']['usuario'];
    }

    /**
     * @access public
     * @return string
     */
    public function getPasswordPrueba() {
        return $this->properties['correo']['prueba']['password'];
    }
    
    public function getPasswordInfo(){
        return $this->properties['correo']['info']['password'];
    }
    
    public function getPasswordNewsletter(){
        return $this->properties['correo']['newsletter']['password'];
    }

    /**
     * @access public 
     * @return string 
     */
    public function getCorreoPrueba() {
        return $this->properties['correo']['prueba']['correo'];
    }
    
    public function getCorreoInfo() {
        return $this->properties['correo']['info']['correo'];
    }
    
    public function getCorreoNewsletter() {
        return $this->properties['correo']['newsletter']['correo'];
    }

    /**
     * @access public 
     * @return string regresa el nombre del emisor del correo electronico
     */
    public function getEmisorPrueba() {
        return $this->properties['correo']['prueba']['nombre'];
    }
    
    public function getEmisorInfo() {
        return $this->properties['correo']['info']['nombre'];
    }
    
    public function getEmisorNewsletter() {
        return $this->properties['correo']['newsletter']['nombre'];
    }

    /**
     * @access public 
     * @return string regresa un arreglo con la configuración del smtp
     */
    public function getSMTPConfig() {
        return $this->properties['smtp'];
    }

    /**
     * @access public 
     * @return array regresa una matriz con la configuración de la cuenta de correo electronico.
     */
    public function getProperties() {
        return $this->properties;
    }

    /**
     * Regresa el servidor SMTP
     * @access public 
     * @return SMTPServer direccion
     */
    public function getSmtpServer() {
        return $this->properties['smtp']['server'];
    }

    /**
     * Regresa un booleano para la autentificacion
     * @access public 
     * @return true
     */
    public function getAuth() {
        return $this->properties['smtp']['SMTPAuth'];
    }

    /**
     * Regresa un false para indicar que no hay 
     * autentificacion
     * @access public 
     * @return false
     */
    public function getNoAuth() {
        return $this->properties['smtp']['NoSMTPAuth'];
    }

    /**
     * @access public 
     * @return string Puerto del smtp
     */
    public function getPuerto() {
        return $this->properties['smtp']['puerto'];
    }

    /**
     * @access public
     * @return string seguridad del smtp
     */
    public function getSMTPSecure() {
        return $this->properties['smtp']['SMTPSecure'];
    }
    /**
     * 
     * @param string $correo
     * @return array 
     */
    public function getConfigMail($correo){
        return $this->properties['correo'][$correo];
    }
}
?>
