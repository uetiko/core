<?php
namespace utils;

use config\MailConfig;
use PHPMailer\PHPMailer;

/**
 * Description of MailObject
 *
 * @author Angel Barrientos <>
 */
abstract class MailObject {

    /**
     *
     * @var config\MailConfig
     */
    private $conf = NULL;
    protected $service = NULL;

    protected function __construct() {
        try {
            $this->conf = MailConfig::getInstance();
            $this->service = new PHPMailer();
        } catch (Exception $e) {
        }
    }

    public function configSMTP() {
        $this->service->IsSMTP();
        $this->service->SMTPAuth = $this->conf->getAuth();
        $this->service->SMTPSecure = $this->conf->getSMTPSecure();
        $this->service->Host = $this->conf->getSmtpServer();
        $this->service->Port = $this->conf->getPuerto();
        $this->service->IsHTML();
    }

    public function configMailAccount($correo) {
        $a = $this->conf->getConfigMail($correo);
        $this->service->From = $a['correo'];
        $this->service->Username = $a['usuario'];
        $this->service->Password = $a['password'];
    }

    /**
     * @access public
     * @param string $pathFile
     * @param string $name
     */
    public function addFile($pathFile, $name) {
        $this->service->AddAttachment($path, $name);
    }

    /**
     * 
     * @param string $correo
     * @param string $name
     */
    public function addAdreess($correo, $name = '') {
        $this->service->AddAddress($correo, $name);
    }
    /**
     * 
     * @param type $fromName
     * @param type $asunto
     * @param type $mensaje
     * @param type $filePath
     * @param type $fileName
     * @return boolean
     */
    public function sendMail($fromName, $asunto, $mensaje, $filePath = NULL, $fileName = NULL) {
        $this->service->FromName = $fromName;
        $this->service->Subject = $asunto;
        $this->service->Body = $mensaje;
        if (NULL !== $fileName) {
            $this->service->AddAttachment($filePath, $fileName);
        }
        try {
            if ($this->service->Send()) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (phpmailerException $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

?>