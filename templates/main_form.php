<?php

include PRICE_CALC_TEMPLATES . "functions.php";
?>
<div class="form-stage" id="form-stage-<?php echo $formStage ?>" stage="<?php echo $formStage ?>" <?php if( $hide ) : ?> style="display:none;"<?php endif; ?>>
<table>

<?php if( is_array( $elems ) ) foreach( $elems as $elem ) : ?>
<?php switch( $elem['type'] ) : ?>
<?php case ELEMENT_HEADING : ?>
	<tr class="<?php output_classes('heading-row', $elem) ?>">
	<th colspan="2"><div class="<?php output_classes('heading', $elem) ?>"><?php echo $elem['title'] ?></div></th>
	</tr>
<?php break; ?>
<?php case ELEMENT_RESULT : ?>
	<tr class="<?php output_classes('result-row', $elem) ?>">
	<th><div class="b <?php output_classes('result-title', $elem) ?>"><?php echo $elem['title'] ?></div></th>
	<td align="left"><div class="result-value <?php output_classes('result-value', $elem) ?>">
		<?php output_result($elem['id'], $elem['variable']) ?>
	</div></td>
	</tr>
<?php break; ?>
<?php case ELEMENT_SELECT : ?>
	<tr class="<?php output_classes('select-row', $elem) ?>">
	<th>
	<div class="b <?php output_classes('select-title', $elem) ?>"><?php echo $elem['title'] ?></div></th>
	<td align="left"><div class="<?php output_classes('select-value', $elem) ?>">
		<?php output_select($elem['id'], $prices, $elem['on_change_next'], $formStage, $elem['default'] ) ?>
	</div></td>
	</tr>
<?php break; ?>
<?php case ELEMENT_NUMBER : ?>
	<tr class="<?php output_classes('number-row', $elem) ?>">
	<th>
	<div class="b <?php output_classes('number-title', $elem) ?>"><?php echo $elem['title'] ?></div></th>
	<td align="left"><div class="<?php output_classes('number-value', $elem) ?>">
		<?php output_number($elem['id'], $prices, $elem['default']) ?>
	</div></td>
	</tr>
<?php break; ?>
<?php case ELEMENT_CHECKBOX : ?>
	<tr class="<?php output_classes('checkbox-row', $elem) ?>">
	<th>
	<div class="b <?php output_classes('checkbox-title', $elem) ?>"><?php echo $elem['title'] ?></div></th>
	<td align="left"><div class="<?php output_classes('checkbox-value', $elem) ?>">
		<?php output_checkbox($elem['id'], $prices, $elem['default']) ?>
	</div></td>
	</tr>
<?php break; ?>
<?php case ELEMENT_FIXED : ?>
	<tr class="<?php output_classes('fixed-row', $elem) ?>" style="display:none;">
	<th></th>
	<td align="left"><div class="<?php output_classes('checkbox-value', $elem) ?>">
	<?php output_fixed( $elem['id'], $prices ) ?>
	</div></td>
	</tr>
<?php break; ?>
<?php endswitch; ?>
<?php endforeach; ?>

</table>
</div>
<?php if( $nextStage ) : ?>
	<div class="stage-control" id="stage-control-<?php echo $formStage ?>">
		<span class="stage-control-continue" <?php if( $hide ) : ?> style="display:none;"<?php endif; ?>>
			<?php if( !$no_continue ) : ?>
				<input class="stage-continue" id="stage-continue-<?php echo $formStage ?>" type="button" stage="<?php echo $formStage ?>" value="<?php pc_phrase('continue')?>" />
			<?php endif; ?>
		</span>
		<span class="stage-control-back" style="display:none">
			<?php if( !$no_back ) : ?>
				<input class="stage-back" id="stage-back-<?php echo $formStage ?>" type="button" stage="<?php echo $formStage ?>" value="<?php pc_phrase('back')?>" />
			<?php endif; ?>
		</span>
	</div>
<?php endif ?>
