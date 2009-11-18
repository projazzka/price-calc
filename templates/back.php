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

<div class="wrap"> 
<div id="price-calc-logo"><br /></div> 
<h2>Price Calculator - Price Table</h2>
<div id="price-calc-prices">

<p>Blank fields are marked as not available to the customer.<br />

<h3>Variation:</h3>
<?php if(!is_array( $variation_links )) : ?>
You have to define at least one valid variation
<?php else : ?>
<ul><?php foreach( $variation_links as $url => $title ) : ?>
<li><?php if( $url ) : ?>
	<a href="<?php echo $url ?>"><?php echo $title; ?></a>
	<?php else : ?>
	<?php echo $title; ?>
	<?php endif; ?>
</li>
<?php endforeach; ?>
</ul>
<?php endif ?>
<form name="prices" method="post">

<p></p><span class="b">Current Variation:</span> <?php echo $variation_title ?></p>

<input type="hidden" name="variation" value="<?php echo $variation ?>" />


<?php if(!is_array( $elements )) : ?>
You have to define a price structure, before you can set the prices
<?php else : ?>
<?php foreach( $elements as $elem ) : ?>
<?php switch( $elem['type'] ) : ?>
<?php case ELEMENT_HEADING : ?>
	<h3><?php echo $elem['title'] ?></h3>
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
<?php case ELEMENT_NUMBER : ?>
<?php case ELEMENT_CHECKBOX : ?>
	<table class="fixed">
		<tr>
			<th><?php echo $elem['title'] ?>:</th>
			<td><input name="<?php echo $elem['id'] ?>" type="text" value="<?php echo $values[$elem['id']] ?>" /></td>
		</tr>
	</table>
<?php break; ?>
<?php endswitch ?>
<?php endforeach ?>
<?php endif ?>
<input type="hidden" name="action" value="save" />
<input type="submit" value="Save" class="button-primary"/>

</form>
</div>