<?php

/**
 * entry file for back-end structure settings screen
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */


if(!is_admin()) die();

require_once( PRICE_CALC_CONTROL . 'Structure.php' );

$back = new Structure();
$back->action();

?>