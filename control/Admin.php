<?php

/**
 * Base class for control classes
 * 
 * (c) 2011 by Igor Prochazka (l90r.com)
 */

class PC_Admin {
	
	function action() {
		switch( price_calc_get_from_request('action') ) {
			case 'save':
				$this->save();
				break;
			default:
				$this->show();
				break;
		}
	}
	
	function save() {
		$this->show();
	}
	
	function show() {
		include( PRICE_CALC_TEMPLATES . $this->template );
	}
		
}

?>