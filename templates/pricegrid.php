<?php

/**
 * template for price-grid used in back-end page
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

	$n = count($set);
	$rows = ceil( ($n-1) / $columns );
	$keys = array_keys( $set );
?>

<table class="pricegrid">
	<?php for( $row=0; $row<$rows; $row++ ) : ?>
		<tr>
	<?php for( $col=0; $col<$columns; $col++ ) : ?>
		<?php $i = $col*$rows + $row + 1; // ascend from top to buttom, skip zero element ?>
		<?php if( $i < $n ) : ?>
			<th><?php echo $set[$keys[$i]] ?></th>
			<td><input type="text" size="10" name="<?php echo $id ?>[<?php echo $keys[$i] ?>]" value="<?php echo $prices[$keys[$i]] ?>" /></td>
		<?php endif; ?>
	<?php $i++; endfor; ?>
		</tr>
	<?php endfor; ?>
</table>
