<?php

class Condition {
	private $conditions;
	
	function __construct( $text ) {
		$this->create( $text );
	}

	function parse( $chunk ) {
		if( $chunk[0] == '(' && $chunk[strlen($chunk)-1] == ')' ) {
			$chunk = substr( $chunk, 1, strlen($chunk)-2 );
		}
		list( $field, $valuesTxt ) = sscanf( trim( $chunk ), '%s in (%[^)])' );
		if( !$field || !$valuesTxt )
			return false;
		$values = explode( ',', $valuesTxt );
		if( empty( $values ))
			return false;
		foreach( $values as &$v ) {
			$v = trim( $v );
			if( !$v )
				return false;
		}
		return array( 'field' => $field, 'values' => $values );
	}
	
	public function create( $text ) {
		$chunks = explode( ' or ', $text );
		foreach( $chunks as $chunk ) {
			$condition = $this->parse( $chunk );
			if( $condition !== false ) {
				$this->conditions[] = $condition;
			}
		}
	}
	
	function check( $values ) {
		if( empty($this->conditions) )
			return true;
		foreach( $this->conditions as $condition ) {
			$left = $values[$condition['field']];
			if( in_array( $left, $condition['values'] ) ) {
				return true;
			}
		}
		return false;
	}
}
?>