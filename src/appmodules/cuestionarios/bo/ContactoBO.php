<?php
namespace cuestionarios\bo;
use utils\MailObject;
use cuestionarios\dao\ContactoDAO;
/**
 * Description of ContactoBO
 *
 * @author uetiko
 */
class ContactoBO extends MailObject{
    public function __construct() {
        parent::__construct();
        $this->configSMTP();
    }

    public function mandaCorreo(\core\http\Request $request){
        
        $this->configMailAccount('ventas');
        $this->addAdreess($request->getAttribute('correo'), $request->getAttribute('nombrecompleto'));
        return $this->sendMail("Ventas Prixealo", "test de Angel", $request->getAttribute('comentario'));
    }
}
?>