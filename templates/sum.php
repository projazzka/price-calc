<table class="sum">
	
<?php foreach( $summands as $concept => $price ) : ?>
<tr>
<td class="concept"><?php echo $concept; ?></td>
<td class="price"><?php echo htmlspecialchars($currency) ?><?php printf( "%.2f", $price ); ?></td>
</tr>
<?php endforeach; ?>
<tr></tr>
<tr class="total">
	<td>TOTAL</td>
	<td class="price"><?php echo htmlspecialchars($currency) ?><?php printf( "%.2f", $total ); ?></td>
</tr>
</table>    
