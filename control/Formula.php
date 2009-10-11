<?php

require_once( PRICE_CALC_CONTROL . '/Value.php' );

class Formula {

	private $operators;
	private $ids;
	private $memory;
	private $operatorsById;
	
	function __construct() {
		$this->load();
	}
	
	function load() {
		global $elements;
		
		$this->operators = array();
		$this->ids = array();
		
		$data = get_option('price-calc-formula');
		if( $data ) {
			$lines = explode( "\n", $data );
			$stage = 0;
			foreach( $lines as $line ) {
				$line = trim($line);
				$operator = $line[0];
				if( $operator && strpos( '+*%=', $operator ) !== false ) {
					$id = substr( $line, 1 );
					$this->ids[] = $id;
					$this->operators[] = $operator;
					$this->operatorsById[$id] = $operator;
				}
			}
		} else {
			foreach( $elements as $elem ) {
				if( $elem['type'] != ELEMENT_HEADING ) {
					$id = $elem['id'];
					$this->operators[] = '+';
					$this->operatorsById[$id] = '+';
					$this->ids[] = $id;
				}
			}
		}
	}
	
	function getIds() { return $this->ids; }
	function getOperators() { return $this->operators; }
	function getMemory( $id ) { return $this->memory[$id]; }
	function getOperator( $id ) { return $this->operatorsById[$id]; }

	function calculate( $prices, $values ) {
		$price = 0;
		$value = new Value();
		
		foreach( $this->ids as $idx => $id ) {
			$operator = $this->operators[$idx];
			if( $operator != '=' )
				$operand = $value->getValue( $prices, $values, $id );
			switch( $operator ) {
				case '+':
					$price += $operand;
					break;
				case '*':
					$price *= $operand;
					break;
				case '%':
					$price *= (($operand/100)+1);
					break;
				case '=':
					$this->memory[$id] = $price;
					//echo "saving $price as @{$id}\n";
					break;
			}
			//echo "step $idx, id $id, operator $operator, operand $operand, price: $price\n";
		}
		$this->memory['total'] = $price;
		return $price;
	}
		
	
}

?>