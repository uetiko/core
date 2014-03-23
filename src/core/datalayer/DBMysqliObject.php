<?php
namespace core\datalayer;

use core\settings\utils\Object;
use config\DBConfig;
use \Exception;

/**
 * 
 * @package core
 * @subpackage datalayer
 * @version 0.1
 * @author Angel Barrientos <uetiko@gmail.com>
 */
class DBMysqliObject{
	protected static $cnn = NULL;
	/**
	 * @var config\DBConfig $config
	 */
	protected static $config = NULL;
	protected static $stmt = NULL;
	protected static $sql = NULL;
	protected static $data = NULL;
	public static $result = NULL;
	protected static $reflection = NULL;
	
	private static function _construct(){
		self::$config = DBConfig::getInstance();
	}
	
	protected static function conect(){
		self::_construct();
		try{
			self::$cnn = new mysqli(self::$config->getHost(), self::$config->getUser(), self::$config->getPassword(), self::$config->getDBName());
		}catch(Exception $e){
			error_log($e->getTraceAsString(), 0);
		}
	}
	
	protected static function prepareStmt(){
		self::$stmt = self::$cnn->prepare(self::$sql);
		self::$reflection = new ReflectionClass('mysqli_stmt');
	}
	
	protected static function setData($fields){
		$method = self::$reflection->getMethod('bind_result');
		$method->invokeArgs(self::$stmt, $fields);
		while (self::$stmt->fetch()) {
			self::$result[] = unserialize(serialize($fields));
		}
	}
	
	protected static function setParams(){
		$method = self::$reflection->getMethod('bind_param');
		$method->invokeArgs(self::$stmt, self::$data);
	}
	
	private static function _destruct(){
		self::$stmt->close();
		self::$cnn->close();
	}
	
	final public static function execute($sql, array $data, array $fields = array()){
		self::$sql = $sql;
		self::$data = $data;
		self::conect();
		self::prepareStmt();
		self::setParams();
		self::$stmt->execute();
		if(count($fields) < 0){
			self::setData($fields);
		}else{
			if(strpos(self::$sql, strtoupper('INSERT')) === 0){
				return self::$stmt->insert_id;
			}
		}
		self::_destruct();
	}
}
?>