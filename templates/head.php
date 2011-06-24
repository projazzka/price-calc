<?php

/**
 * admin screen header template
 * 
 * (c) 2011 by Igor Prochazka (l90r.com)
 */

if(!is_admin())
	die;
?>

<div class="wrap"> 
<div id="price-calc-logo"><br /></div> 
<h2>Price Calculator - <?php echo htmlentities($title) ?></h2>
