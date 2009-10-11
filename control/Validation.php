<?php

class Validation {
	private $validators;
	private $expressions;
	
	function __construct() {
		$this->expressions = array(
			'unequal' => '/(.*)<>(.*)/',
			'equal' => '/(.*)=(.*)/',
			'greater' => '/(.*)>(.*)/',
			'less' => '/(.*)<(.*)/'
		);
		$this->load();
	}

	function outputJavaScript() {
		foreach( $this->validators as $v ) {
			$out .= 'if(!validate_' . $v['validator'] . '_' . $v['type'] . '("' .
				htmlspecialchars($v['left']) . '","' .
				htmlspecialchars($v['right']) . '","' .
				htmlspecialchars($v['alert']) . "\")) return false;\n";
		}
		return $out;
	}

	private function isReference( $subject ) { return preg_match( '/^[a-z0-9A-Z_]*$/', $subject ); }
	private function getValue( $subject ) {
		if( preg_match( '/^"(.*)"$/', $subject, $match ) ) {
			return $match[1];
		} else {
			return false;
		}
	}

	function parse( $condition ) {
		foreach( $this->expressions as $id => $regexp ) {
			unset($match);
			if( preg_match( $regexp, $condition, $match ) ) {
				$validator = $id;
				$left = $match[1];
				$right = $match[2];
				if( $this->isReference( $left ) ) {
					$value = $this->getValue( $right );
					if( $value !== false ) {
						$type = 'value';
						$right = $value;
					} elseif( $this->isReference( $right )) {
						$type = 'reference';
					}
				}
				return compact( 'validator', 'type', 'left', 'right' );
			}
		}
	}
	
	function load() {
		$this->validators = array();
		$data = get_option('price-calc-validation');
		if( $data ) {
			$lines = explode( "\n", $data );
			foreach( $lines as $line ) {
				$line = trim($line);
				list( $condition, $alert ) = explode( ';', $line );
				if( $condition ) {
					if( $validator = $this->parse( $condition ) ) {
						$validator['alert'] = $alert;
						$this->validators[] = $validator;
					}
				}
			}
		}
	}
}


?>