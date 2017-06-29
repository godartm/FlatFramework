<?php

/** SQL literal value
*/
class NotORM_Literal {
	/** @var array */
	public $parameters = array();
	protected $value = '';
	
	/** Create literal value
	* @param string
	* @param mixed parameter
	* @param mixed ...
	*/
	function __construct($value) {
		$this->value = $value;
		$this->parameters = func_get_args();
		array_shift($this->parameters);
	}
	
	/** Get literal value
	* @return string
	*/
	function __toString() {
		return $this->value;
	}
	
}
