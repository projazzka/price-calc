<?php

/**
 * Control class for back-end settings screen
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

class Settings {
	function __construct() {
		$this->options = array( 
			'bidformat',
			'email',
			'fullquote',
			'contact',
			'print',
			'subtotal',
			'currency',
			'currencypost',
			'subject',
			'suppresszero',
			'css',
			'nocontinue',
			'noback',
			'subtotaltitle',
			'subtotalvariable',
			'subtotalspan',
			'novariantcontinue',
			'decimals',
			'point',
			'thousands',
			'multitab',
			'entertabbing',
			'preloadstages'
		);
		$this->template = 'settings.php';
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
		foreach( $this->options as $option ) {
			update_option( 'price-calc-' . $option, $_REQUEST[$option]);
		}
		$this->show();
	}
	
	function show() {
		foreach( $this->options as $option ) {
			$$option = get_option('price-calc-' . $option);
		}
		include( PRICE_CALC_TEMPLATES . $this->template );
	}
		
}

?>