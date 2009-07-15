<?php

/**
 * back-end page template
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

if(!is_admin())
	die;

function pricegrid( $id, $options, $all_prices, $columns = 1 ) {
	global $options;

	$set = $options[ $id ];
	$prices = $all_prices[ $id ];

	include PRICE_CALC_TEMPLATES . "pricegrid.php";
}
?>

<style>
html, body {
	font-family: Arial, Helvetica, sans-serif;
}
div.b {
	font-weight: bolder;
	margin-top: 10px;
}

table.pricegrid th {
	font-weight: normal;
	font-size: 0.8em;
}
</style>	

<h2>Price Table</h2>
<p>Blank fields are marked as not available to the customer.</p>

<div class="b">Variation:</div>
<ul><?php foreach( $variation_links as $url => $title ) : ?>
<li><?php if( $url ) : ?>
	<a href="<?php echo $url ?>"><?php echo $title; ?></a>
	<?php else : ?>
	<?php echo $title; ?>
	<?php endif; ?>
</li>
<?php endforeach; ?>
</ul>
<form name="prices" method="post">

<div class="b">Variation:</div> <?php echo $variation_title ?>
<input type="hidden" name="variation" value="<?php echo $variation ?>" />


<?php foreach( $elements as $elem ) : ?>
<?php switch( $elem['type'] ) : ?>
<?php case ELEMENT_HEADING : ?>
	<h2><?php echo $elem['title'] ?></h2>
<?php break; ?>
<?php case ELEMENT_SELECT : ?>
	<div class="b"><?php echo $elem['title'] ?>:</div>
	<?php if( $elem['grid'] ) :?>
		<?php pricegrid($elem['id'], $options, $values, $elem['grid'] ) ?>
	<?php else : ?>
		<?php pricegrid($elem['id'], $options, $values ) ?>
	<?php endif ?>
<?php break ?>
<?php case ELEMENT_FIXED : ?>
	<table class="fixed">
		<tr>
			<th><?php echo $elem['title'] ?>:</th>
			<td><input name="<?php echo $elem['id'] ?>" type="text" value="<?php echo $values[$elem['id']] ?>" /></td>
		</tr>
	</table>
<?php break; ?>
<?php endswitch ?>
<?php endforeach ?>

<!-- <h2>Base</h2>

<div class="b">Dimensions:</div>
<?php pricegrid("base_dim", $options, $values, 5 ); ?>

<div class="b">Height:</div>
<?php pricegrid("base_height", $options, $values, 2 ); ?>

<h2>Roof Option</h2>

<div class="b">Roof Style:</div>
<?php pricegrid("roof_style", $options, $values) ?>

<h2>Both Sides Closed</h2>

<div class="b">Both Sides Closed:</div>
<?php pricegrid("both_sides_closed", $options, $values, 2) ?>

<h2>Each End Closed</h2>

<div class="b">Each End Closed:</div>
<?php pricegrid("each_end_closed", $options, $values, 2) ?>

<h2>Other Options</h2>

<div class="b">Extra Braces:</div>
<?php pricegrid("braces", $options, $values, 4 ) ?>

<div class="b">J-Trim:</div>
<?php pricegrid("j_trim", $options, $values) ?>

<div class="b">Gables:</div>
<?php pricegrid("gables", $options, $values, 4) ?></select>

<h2>Door and Window Options</h2>

<div class="b">Garage Doors:</div>
<?php pricegrid("garage_door", $options, $values, 6) ?>

<div class="b">Walk-In Doors:</div>
<?php pricegrid("door", $options, $values) ?>

<div class="b">Windows:</div>
<?php pricegrid("window", $options, $values) ?>

<h2>Frameout Only - No Door/Window Provided</h2>

<div class="b">Garage Doors:</div>
<?php pricegrid("garage_door_frameout", $options, $values) ?>

<div class="b">Walk-In Doors:</div>
<?php pricegrid("door_frameout", $options, $values) ?>

<div class="b">Windows:</div>
<?php pricegrid("window_frameout", $options, $values) ?>

<h2>Additional Panels</h2>

<div class="b"><?php pricegrid("panel_21_cut", $options, $values, 6 ) ?>

<div class="b">26':</div>
<?php pricegrid("panel_26_cut", $options, $values, 6 ) ?>

<div class="b">31':</div>
<?php pricegrid("panel_31_cut", $options, $values, 6) ?>
-->

<input type="hidden" name="action" value="save" />
<input type="submit" value="Save" />

</form>
