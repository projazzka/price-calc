<?php

/**
 * entry file for upgrade screen
 * 
 * (c) 2011 by Igor Prochazka (l90r.com)
 */

if(!is_admin()) die();

require_once( PRICE_CALC_CONTROL . 'Upgrade.php' );

$back = new PC_Upgrade();
$back->action();

?>