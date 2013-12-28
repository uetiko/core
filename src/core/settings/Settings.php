<?php

namespace core\settings;

/**
 * Description of Settings
 *
 * @author uetiko
 */
class Settings {

    const PRODUCCION = FALSE;

    static final public function getInitEnvironment() {
        if (!self::PRODUCCION) {
            ini_set('error_reporting', E_ALL | E_NOTICE | E_STRICT);
            ini_set('display_errors', '1');
        } else {
            ini_set('display_errors', '0');
        }
    }
}

?>
