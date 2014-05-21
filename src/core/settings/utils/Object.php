<?hh
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
 abstract class Object extends \stdClass{
 	/**
	 * 
	 */
 	public function getClass(): string {
 		return get_class($this);
 	}
	/**
	 * 
	 */
	public function equals(stdClass $obj): bool{
		return ($this == $obj);
	}
	
	public function toString(): string {
		return (string)$this;
	}
 }
?>
