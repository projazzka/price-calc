<?php

/**
 * Upgrade controller
 * 
 * (c) 2011 by Igor Prochazka (l90r.com)
 */

require_once(PRICE_CALC_CONTROL . 'Admin.php');
require_once(PRICE_CALC_CORE . 'Compatibility.php');

class PC_Upgrade extends PC_Admin {
    
    function __construct() {
		$this->template = 'upgrade.php';
	}
		
	function save() {
        /* ... */
		$this->show();
	}
	
	function show() {
		parent::show();
	}
}

?>