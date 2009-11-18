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
				if( $operator && strpos( 'fC+*%=', $operator ) !== false ) {
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
			if( $operator == 'f' ) {
				$price = apply_filters( 'price-calc-custom-formula', $price, $id, $prices, $values );
			} else {
				if( $operator != '=' && $operator != 'C' ) {
					if( $id[0] == '@' )
						$operand = $this->memory[substr($id, 1)];
					else
						$operand = $value->getValue( $prices, $values, $id );
				} else {
					$operand = true;
				}
				if( $operand !== false ) {
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
						case 'C':
							$price = 0;
					}
				}
			}
			//echo "step $idx, id $id, operator $operator, operand $operand, price: $price\n";
		}
		$this->memory['total'] = $price;
		return $price;
	}
		
	
}

?>