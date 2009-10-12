<?php

class Element {

	private $type;
	private $id;
	private $title;
	private $grid;
	private $condition; 
	private $on_change_next;
	
	function __construct( $arr ) {
		if( !is_array($arr) )
			return;
		
		$this->type = $arr['type'];
		$this->id = $arr['id'];
		$this->title = $arr['$title'];
		$this->grid = $arr['$grid'];
		$this->condition = $arr['$condition'];
		$this->on_change_next = $arr['$on_change_next'];
	}
	
	function isEnabled( $prices ) {
		$id = $this->id;
		switch( $this->type ) {
			case ELEMENT_SELECT:
				if( !is_array($prices[$id]) )
					return false;
				$enabled = false;	
				foreach( $prices[$id] as $price )
					if( $price !== '' )
						$enabled = true;
				return $enabled;
				break;
			case ELEMENT_FIXED:
			case ELEMENT_NUMBER:
				return ($prices[$id] !== '');
				break;
		}
		return true;
	}
}
?>