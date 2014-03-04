<?php
namespace core\settings\utils;

/**
 * 
 * @abstract
 * @package core
 * @subpackage settings
 * @subpackage utils
 * @version 0.1
 * @author Angel Barrientos <uetiko@gmail.com>
 */
 abstract class Object extends stdClass{
 	/**
	 * 
	 */
 	public function getClass(){
 		return get_class($this);
 	}
	/**
	 * 
	 */
	public function equals(stdClass $obj){
		return ($this == $obj);
	}
	
	public function toString(){
		return (string)$this;
	}
 }
?>