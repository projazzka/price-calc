<?php

/**
 * entry file for back-end screen
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */


if(!is_admin()) die();

require_once( PRICE_CALC_CONTROL . 'Back.php' );

$back = new Back();
$back->action();

?>