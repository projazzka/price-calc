<?php require_once( 'functions.php' ); ?>

<table class="sum">
	
<?php foreach( $concepts as $concept ) : ?>
<tr>
<td class="concept"><?php echo htmlspecialchars($concept['title'], ENT_NOQUOTES); ?></td>
<td class="value price">
	<?php switch( $concept['operator'] ) :
		case '+': ?>
	 <?php if( $concept['value']>=0 ) : ?>
	 + <?php echo htmlspecialchars( price_calc_number( $concept['value'] ), ENT_NOQUOTES) ?>&nbsp;
	 <?php else : ?> 
	 - <?php echo htmlspecialchars( price_calc_number( abs($concept['value']) ), ENT_NOQUOTES) ?>&nbsp;
	 <?php endif ?>
	 <?php break;
	    case '*': ?>
	 x <?php echo htmlspecialchars( price_calc_number( $concept['value'], true ), ENT_NOQUOTES) ?>&nbsp;
	 <?php break;
	    case '%': ?>
	 <?php echo htmlspecialchars( price_calc_number( $concept['value'], false, true ), ENT_NOQUOTES) ?>% 
	 <?php break;
	    case '=': ?>
	 &nbsp; <?php echo htmlspecialchars( price_calc_number( $concept['value'] ), ENT_NOQUOTES) ?>&nbsp;
	 <?php break; ?>
	<?php endswitch; ?>
</td>
</tr>
<?php endforeach; ?>

</table>    
