<?php

/**
 * Control class for back-end settings screen
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

class Settings {
	function __construct() {
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
		update_option( 'price-calc-structure', $_REQUEST['structure'] );
		update_option( 'price-calc-bidformat', $_REQUEST['bidformat'] );
		update_option( 'price-calc-variations', $_REQUEST['variations'] );
		update_option( 'price-calc-email', $_REQUEST['email'] );
		update_option( 'price-calc-fullquote', $_REQUEST['fullquote'] );
		update_option( 'price-calc-contact', $_REQUEST['contact'] );
		update_option( 'price-calc-print', $_REQUEST['print'] );
		update_option( 'price-calc-subtotal', $_REQUEST['subtotal'] );
		update_option( 'price-calc-currency', $_REQUEST['currency'] );
		update_option( 'price-calc-subject', $_REQUEST['subject'] );
		$this->show();
	}
	
	function show() {
		$structure = get_option( 'price-calc-structure' );
		$bidformat = get_option( 'price-calc-bidformat' );
		$variations = get_option( 'price-calc-variations' );
		$email = get_option( 'price-calc-email' );
		$fullquote = get_option( 'price-calc-fullquote' );
		$contact = get_option( 'price-calc-contact' );
		$print = get_option( 'price-calc-print' );
		$subtotal = get_option( 'price-calc-subtotal' );
		$currency = get_option( 'price-calc-currency' );
		$subject = get_option( 'price-calc-subject' );

		include( PRICE_CALC_TEMPLATES . 'settings.php' );
	}
		
}

?>