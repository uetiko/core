<?php
namespace src;
/**
 * Clase de Autocarga de clases bajo demanda capaz de leer namespaces y la
 * convencion de ZendFramework 1
 * @version 0.3
 * @author Angel Barrientos <uetiko@gmail.com>
 */
class Autoloader {

    /**     
     *
     * @var \Autoloader
     */
    static private $INSTANCE = NULL;

    /**
     * @access private
     * @return void
     */
    private function __construct() {
        
    }

    /**
     * Se encarga de registrar las clases que se van necesitando.
     * @access public
     * @return boolean
     */
    public function registro() {
        ini_set('unserialize_callback_func', 'spl_autoload_call');
        return spl_autoload_register(array(new Autoloader, 'autoload'));
    }

    /**
     * method that remplaces the magic method __autoload
     * @access private
     * @param string $classname el nombre de la clase
     * @return void
     */
    private function autoload($classname) {
        $tmp = $classname;
        $arrayClass = array_reverse(explode('\\', $classname));
        $classname = $arrayClass[0];
        $reverse = array_reverse(explode(DIRECTORY_SEPARATOR, dirname(__FILE__)));
        $base = array_splice($reverse, 1, count($reverse));
        $basefolder = implode(DIRECTORY_SEPARATOR, array_reverse($base));
        $sourceFile = implode(DIRECTORY_SEPARATOR, array($basefolder, 'src'));
        $libfolder = implode(DIRECTORY_SEPARATOR, array($sourceFile, 'lib'));
        $database = implode(DIRECTORY_SEPARATOR, array($sourceFile, 'orm'));

        $path = '';
        $namespace = '';
        $s = ($last = strripos($classname, '\\'));
        if (false !== ($last = strripos($classname, '\\'))) {
            $namespace = substr($classname, 0, $last);
            $classname = substr($classname, $last + 1);
            $path .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        } elseif (false == preg_match('/_/', $tmp)) {
            $path .= str_replace('\\', DIRECTORY_SEPARATOR, $tmp) . '.php';
        } else {
            $path .= str_replace('_', DIRECTORY_SEPARATOR, $classname) . '.php';
        }
        $inbase = implode(DIRECTORY_SEPARATOR, array($basefolder, $path));
        $insrc = implode(DIRECTORY_SEPARATOR, array($sourceFile, $path));
        $inlib = implode(DIRECTORY_SEPARATOR, array($libfolder, $path));
        $orm = implode(DIRECTORY_SEPARATOR, array($database, $path));

        switch(true){
            case file_exists($inbase);
                require_once($inbase);
                break;
            case file_exists($insrc):
                require_once($insrc);
                break;
            case file_exists($inlib):
                require_once($inlib);
                break;
            case file_exists($orm);
                require_once($orm);
                break;
        }
    }

    /**
     * return a instance of Autoloader
     * @return \Autoloader
     */
    static final public function getInstance() {
        if (!self::$INSTANCE instanceof Autoloader) {
            self::$INSTANCE = new Autoloader();
        }
        return self::$INSTANCE; 
   }
}?>
