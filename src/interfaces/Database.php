<?php

namespace interfaces;

/**
 * 
 * @package interfaces
 * @author uetiko
 */
interface Database {

    static public function close();
    static public function query($query, array $options);
}

?>
