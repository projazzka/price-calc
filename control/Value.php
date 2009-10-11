<?php

global $options;

class Value {
	
	function getTitle( $values, $id ) {
		global $elements;
		global $titles;
		global $options;
		
		$elem = $elements[$id];
		if(!$elem)
			return false;
			
		if( $elem['type'] == ELEMENT_SELECT ) {
			$chosen = $values[ $id ];
			$title = $titles[$id] . ': ' . $options[$id][ $chosen ];
		} else {
			$title = $elem['title'];
		}
		return $title;
	}

	function getValue( $prices, $values, $id ) {
		global $elements;
		$elem = $elements[$id];
		if(!$elem)
			return false;
		if( $elem['type'] == ELEMENT_SELECT ) {
			$chosen = $values[ $id ];
			if( $chosen ) {
				$textual = $prices[$id][$chosen];
			}
		} else {
			$textual = $prices[$id];
		}
		if( $textual && is_numeric( $textual ))
			$value = $textual;
		else 
			return false;

		switch( $elem['type'] ) {
			case ELEMENT_CHECKBOX:
				$checked = $values[ $id ];
				if(!$checked ) {
					$value = 0;
				}
				break;
			case ELEMENT_NUMBER:
				$number = $values[ $id ];
				$value *= $number;
				break;
		}
		
		return $value;
	}
}

?>