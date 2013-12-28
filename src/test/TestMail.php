<?php
namespace test;
use utils\MailObject;
/**
 * Description of TestMail
 *
 * @author uetiko
 */
class TestMail extends MailObject{
    public function correo(){
        $this->configSMTP(TRUE);
    }
}

?>
