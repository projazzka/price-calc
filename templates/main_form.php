<?php

include PRICE_CALC_TEMPLATES . "functions.php";
?>
<div class="form-stage" id="form-stage-<?php echo $formStage ?>" stage="<?php echo $formStage ?>">
<table>

<?php if( is_array( $elems ) ) foreach( $elems as $elem ) : ?>
<?php switch( $elem['type'] ) : ?>
<?php case ELEMENT_HEADING : ?>
	<tr>
	<th colspan="2"><?php echo $elem['title'] ?></th>
	</tr>
<?php break; ?>
<?php case ELEMENT_SELECT : ?>
	<tr>
	<th>
	<div class="b"><?php echo $elem['title'] ?>:</div></th>
	<td align="left">
		<?php output_select($elem['id'], $prices, $elem['on_change_next'], $formStage ) ?>
	</td>
	</tr>
<?php break; ?>
<?php case ELEMENT_NUMBER : ?>
	<tr>
	<th>
	<div class="b"><?php echo $elem['title'] ?>:</div></th>
	<td align="left">
		<?php output_number($elem['id'], $prices) ?>
	</td>
	</tr>
<?php break; ?>
<?php case ELEMENT_CHECKBOX : ?>
	<tr>
	<th>
	<div class="b"><?php echo $elem['title'] ?>:</div></th>
	<td align="left">
		<?php output_checkbox($elem['id'], $prices) ?>
	</td>
	</tr>
<?php break; ?>
<?php case ELEMENT_FIXED : ?>
	<?php output_fixed( $elem['id'], $prices ) ?>
<?php break; ?>
<?php endswitch; ?>
<?php endforeach; ?>

</table>
</div>
<?php if( $nextStage ) : ?>
	<div class="stage-control" id="stage-control-<?php echo $formStage ?>">
		<span class="stage-control-continue">
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
