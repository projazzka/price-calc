<?php

/**
 * Reads in the file that defines the price table's structure
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

define( ELEMENT_HEADING, 'head' );
define( ELEMENT_SELECT, 'select' );
define( ELEMENT_FIXED, 'fixed' );

class Options {
	private $options;
	private $elements;
	private $lastSelect;
	private $titles;
	private $select;
	private $fixed;
	private $obligatory;
	private $variations;

	function __construct() {
		$this->select = array();
		$this->fixed = array();
		$this->obligatory = array();
		$this->variations = array();
		$this->load();
	}

	function getElements() {
		return $this->elements;
	}
	
	function getAllSelect() { return $this->select; }
	function getAllFixed() { return $this->fixed; }
	function getObligatory() { return $this->obligatory; }
	function getVariations() { return $this->variations; }
	
	function getTitles() {
		return $this->titles;
	}
		
	function getOptions()	{
		return $this->options;
	}
	
	private function load() {
		$data = get_option('price-calc-variations');
		$lines = explode( "\n", $data );
		foreach( $lines as $line ) {
			$line = trim( $line );
			list( $id, $title ) = explode( '|', $line );
			$this->variations[$id] = $title;
		}

		$data = get_option('price-calc-structure');
		$lines = explode( "\n", $data );
		
		foreach( $lines as $line ) {
			$line = trim( $line );
			if( strncmp( $line, '==', 2 ) == 0 ) {
				$this->elements[] = array( "type" => ELEMENT_HEADING, "title" => substr( $line, 2 ) );
			} elseif( $line[0] == '@' ) {
				list($id,$title,$grid) = explode( '|', substr( $line, 1 ) );
				if( $title[strlen($title)-1] == '*') {
					$this->obligatory[] = $id;
					$title = substr( $title, 0, strlen($title)-1 );
				}
				$this->elements[] = array( "type" => ELEMENT_SELECT, "id" => $id, "title" => $title, "grid" => $grid );
				$this->options[$id] = array();
				$this->lastSelect = $id;
				$this->titles[$id] = $title;
				$this->select[] = $id;
			} elseif( $line[0] == '-' ) {
				list($id,$title) = explode( '|', substr( $line, 1 ) );
				$this->options[$this->lastSelect][$id] = $title;
			} else if( $line[0] == '#' ) {
				list($id,$title) = explode( '|', substr( $line, 1 ) );
				$this->elements[] = array( "type" => ELEMENT_FIXED, "id" => $id, "title" => $title );
				$this->options[$id] = $id;
				$this->fixed[] = $id;
			}
		}
	}
}

?>