<?php

global $elements;
include PRICE_CALC_TEMPLATES . "functions.php";

?>

<table>
<?php foreach( $elements as $elem ) : ?>
<?php switch( $elem['type'] ) : ?>
<?php case ELEMENT_HEADING : ?>
	<tr>
	<th colspan="2"><?php echo $elem['title'] ?></th>
	</tr>
<?php break; ?>
<?php case ELEMENT_SELECT : ?>
<?php if(!is_select_disabled($elem['id'], $prices)) : ?>
	<tr>
	<td>
	<div class="b"><?php echo $elem['title'] ?>:</div></td>
	<td align="left">
		<?php output_select($elem['id'], $prices ) ?>
	</td>
	</tr>
<?php endif ?>
<?php break; ?>
<?php case ELEMENT_FIXED : ?>
	<?php output_fixed( $elem['id'], $prices ) ?>
<?php break; ?>
<?php endswitch; ?>
<?php endforeach; ?>

</table>

