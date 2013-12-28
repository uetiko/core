<?php
namespace cuestionarios\controller;
use core\http\Request;
use cuestionarios\bo\ContactoBO;
use core\Controller;
/**
 * Description of ContactoController
 *
 * @author uetiko
 */
class ContactoController extends Controller{
    public function contactoAction(Request $request){
        $bo = new ContactoBO();
        //$bo->mandaCorreo($request);
        $this->render('view', array('saludo' => 'Te odio'));
    }
}

?>
