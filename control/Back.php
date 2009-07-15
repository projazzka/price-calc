<?php

/**
 * Control class for back-end screen
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

require_once( PRICE_CALC_ROOT . 'options.php');
require_once( PRICE_CALC_CONTROL . 'Storage.php');
require_once( PRICE_CALC_CONTROL . 'Variation.php');

class Back {
	private $storage;
	
	function __construct() {
		$this->storage = new Storage();
	}
	
	function action() {
		switch( $_REQUEST['action'] ) {
			case 'save':
				$this->save();
				break;
			default:
				$this->show();
				break;
		}
	}
	
	function save() {
		$this->storage->save( Variation::getFromRequest(), $_REQUEST );
		$this->show();
	}
	
	function show() {
		global $options, $variations, $elements;

		$variation = Variation::getFromRequest();
		$values = $this->storage->load( $variation );
		$variation_title = $variations[ $variation ];

		$baseUrl = preg_replace( '/[&]*variation=[^&]*/', "", $_SERVER['REQUEST_URI'] );
		if(strstr($baseUrl, '?'))
			$baseUrl .= '&';
		else
			$baseUrl .= '?';
			
		foreach( $variations as $id => $title ) {
			if( $id == $variation )
				$url = '';
			else
				$url = $baseUrl . "variation=$id";
			$variation_links[$url]=$title;
		}

		include( PRICE_CALC_TEMPLATES . 'back.php' );
	}
		
}

?>
