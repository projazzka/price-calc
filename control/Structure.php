<?php

/**
 * Control class for back-end structure settings screen
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

require_once( PRICE_CALC_CONTROL . 'Settings.php' );

class Structure extends Settings  {
	function __construct() {
		$this->options = array( 
			'structure',
			'variations',
			'formula',
			'format',
			'validation'
		);
		$this->template = 'structure.php';
	}

}

?>