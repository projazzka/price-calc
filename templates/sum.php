<table class="sum">
	
<?php foreach( $concepts as $concept ) : ?>
<tr>
<td class="concept"><?php echo htmlspecialchars($concept['title'], ENT_NOQUOTES); ?></td>
<td class="value price">
	<?php switch( $concept['operator'] ) :
		case '+': ?>
	 <?php if( $concept['value']>=0 ) : ?>
	 + <?php echo htmlspecialchars($currency, ENT_NOQUOTES) ?><?php printf( "%.2f", $concept['value'] ); ?>&nbsp;
	 <?php else : ?> 
	 -<?php echo htmlspecialchars($currency, ENT_NOQUOTES) ?><?php printf( "%.2f", abs($concept['value']) ); ?>&nbsp;
	 <?php endif ?>
	 <?php break;
	    case '*': ?>
	 x <?php printf( "%.2f", $concept['value'] ); ?>&nbsp;
	 <?php break;
	    case '%': ?>
	 <?php printf( "%.2f", $concept['value'] ); ?>% 
	 <?php break;
	    case '=': ?>
	 &nbsp; <?php echo htmlspecialchars($currency, ENT_NOQUOTES) ?><?php printf( "%.2f", $concept['value'] ); ?>&nbsp;
	 <?php break; ?>
	<?php endswitch; ?>
</td>
</tr>
<?php endforeach; ?>

</table>    
