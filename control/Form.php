<?php

/**
 * Control class for retrieval of main price form
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

require_once( PRICE_CALC_ROOT . 'options.php' );
require_once( PRICE_CALC_CONTROL . 'Storage.php' );
require_once( PRICE_CALC_CONTROL . 'Variation.php' );

class Form {
	
	function action() {
		echo $this->getForm( Variation::getFromRequest() );
	}

	function getForm( $variation ) {
		$storage = new Storage();
		$prices = $storage->load( $variation );

		ob_start();
		include( PRICE_CALC_TEMPLATES . 'main_form.php' );
		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	}

}

?>