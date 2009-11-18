<?php

/**
 * Reads in the file that defines the price table's structure
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */


require_once( PRICE_CALC_CONTROL . 'Condition.php' );

define( ELEMENT_HEADING, 'head' );
define( ELEMENT_SELECT, 'select' );
define( ELEMENT_FIXED, 'fixed' );
define( ELEMENT_NUMBER, 'number' );
define( ELEMENT_CHECKBOX, 'checkbox' );
define( ELEMENT_RESULT, 'result' );

class Options {
	private $options;
	private $elements;
	private $lastSelect;
	private $titles;
	private $select;
	private $fixed;
	private $obligatory;
	private $variations;
	private $stages;
	private $stageNames;
	private $results;

	private static $instance;
	public function getInstance() {
		if( !self::$instance ) {
			self::$instance = new Options();
		}
		return self::$instance;
	}

	private function __construct() {
		$this->select = array();
		$this->fixed = array();
		$this->obligatory = array();
		$this->variations = array();
		$this->load();
	}

	function getAllSelect() { return $this->select; }
	function getAllFixed() { return $this->fixed; }
	function getObligatory() { return $this->obligatory; }
	function getVariations() { return $this->variations; }
	function getStages() { return $this->stages; }
	function getResults() { return $this->results; }
	function getStageNames() { return $this->stageNames; }
	function getElements() { return $this->elements; }
	
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
		$stage = 0;
		foreach( $lines as $line ) {
			$line = trim( $line );
			if( strncmp( $line, '==', 2 ) == 0 ) {
				list( $title, $classes, $conditionTxt ) = explode( '|', substr( $line, 2 ));
				$condition = new Condition( $conditionTxt );
				$element = array( "type" => ELEMENT_HEADING, "title" => $title, 'classes' => $classes, "condition" => $condition );
				$this->elements[] = $element;
				$this->stages[$stage][] = $element;
			} elseif( $line[0] == '@' ) {
				list($id,$title,$grid,$conditionTxt,$modifiers) = explode( '|', substr( $line, 1 ) );
				if( $title[strlen($title)-1] == '*') {
					$this->obligatory[] = $id;
					$title = substr( $title, 0, strlen($title)-1 );
				}
				$on_change_next = ( strpos( $modifiers, 'on_change_next' ) !== false );
				$condition = new Condition( $conditionTxt );
				$element = array( "type" => ELEMENT_SELECT, "id" => $id, "title" => $title, "grid" => $grid, "condition" => $condition, "on_change_next" => $on_change_next );
				$match = array();
				if(preg_match('/default=([^;]*)/', $modifiers, $match )) {
					$element['default'] = $match[1];
				}
				$previous_select = $element;
				$this->elements[$id] = $element;
				$this->stages[$stage][] = $element;
				$this->options[$id] = array();
				$this->lastSelect = $id;
				$this->titles[$id] = $title;
				$this->select[] = $id;
			} elseif( $line[0] == '-' ) {
				list($id,$title) = explode( '|', substr( $line, 1 ) );
				$this->options[$this->lastSelect][$id] = $title;
			} elseif( $line[0] == '#' ) {
				list($id,$title) = explode( '|', substr( $line, 1 ) );
				$element = array( "type" => ELEMENT_FIXED, "id" => $id, "title" => $title );
				$this->elements[$id] = $element;
				$this->stages[$stage][] = $element;
				$this->options[$id] = $id;
				$this->fixed[] = $id;

			} elseif( $line[0] == '*' ) {
				list($id,$title,$modifiers) = explode( '|', substr( $line, 1 ) );
				$element = array( "type" => ELEMENT_CHECKBOX, "id" => $id, "title" => $title );
				if( strpos( $modifiers, 'default' ) !== false )
					$element['default'] = '1';
				$this->elements[$id] = $element;
				$this->stages[$stage][] = $element;
				$this->options[$id] = $id;
			} elseif( $line[0] == '$' ) {
				list($id,$title, $modifiers) = explode( '|', substr( $line, 1 ) );
				if( $title[strlen($title)-1] == '*') {
					$this->obligatory[] = $id;
					$title = substr( $title, 0, strlen($title)-1 );
				}
				$element = array( "type" => ELEMENT_NUMBER, "id" => $id, "title" => $title );
				$match = array();
				if(preg_match('/default=(.*)/', $modifiers, $match )) {
					$element['default'] = $match[1];
				}
				$this->elements[$id] = $element;
				$this->stages[$stage][] = $element;
				$this->options[$id] = $id;
			} elseif( $line[0] == '[' ) {
				list($id, $title) = explode( '|', substr( $line, 1 ) );
				$stage++;
				$this->stageNames[ $id ] = $title;
			} elseif( $line[0] == '?' ) {
				list($id,$variable,$title) = explode( '|', substr( $line, 1 ) );
				$element = array( 'type' => ELEMENT_RESULT, 'id' => $id, 'title' => $title, 'variable' => $variable );
				$this->elements[$id] = $element;
				$this->stages[$stage][] = $element;
				$this->results[$id] = $variable;
			}
		}
	}
}

?>