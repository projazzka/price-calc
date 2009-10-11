<?php

/**
 * front-end page template
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

?>

<script>
var obligatory=<?php echo json_encode($obligatory); ?>;
var all=<?php $all = array_keys($options); $all[] = "variation"; echo json_encode($all) ?>;
var types=<?php echo json_encode( $types ) ?>;
var contact=<?php echo json_encode($contact_info) ?>;
var contact_obligatory=<?php echo json_encode($contact_obligatory) ?>;
var formula_ids=<?php echo json_encode($formula_ids) ?>;
var formula_operators=<?php echo json_encode($formula_operators) ?>;

function validate_extra() {
	<?php echo $validators ?>
	return true;
}
</script>

<script src="<?php echo PRICE_CALC_AJAX_URL ?>front.js"></script>
<script src="<?php echo PRICE_CALC_AJAX_URL ?>json2.min.js"></script>
<style>
<?php echo htmlspecialchars($css, ENT_NOQUOTES) ?>
</style>	

<div id="price_calc">
<form id="price-calc-form" style="margin-bottom:0;" action="">

<?php if(!$variation) : ?>
	<table border="0">
	<tbody>
	<tr>
	<th colspan="2"><?php pc_phrase('general_variation')?></th>
	</tr>
	<tr>
	<th>
	<div class="b"><?php pc_phrase('type')?></div></th>
	<td align="left">
<span class="form-stage" id="form-stage-0">
		<select id="variation" name="variation" id="variation">
			<option value="0"><?php pc_phrase('choose')?></option>
			<?php foreach( $variations as $id => $title ) : ?>
				<option value="<?php echo $id ?>"><?php echo $title ?></option>
			<?php endforeach; ?>
		</select>
</span>
	<span class="stage-control" id="stage-control-0">
		<span class="stage-control-continue">
			<input class="stage-continue" id="stage-continue-0" type="button" stage="0" value="<?php pc_phrase('continue')?>" />
		</span>
		<span class="stage-control-back" style="display:none">
			<input class="stage-back" id="stage-back-0" type="button" stage="0" value="<?php pc_phrase('back')?>" />
		</span>
	</span>
	
</td>
</tr>
</table>
<?php endif; ?>

<input type="hidden" id="variation" name="variation" value="<?php echo $variation ?>" />

<div id="main_form">
<?php if( $variation ) : ?>
<?php echo $form ?>
<?php endif; ?>
</div>

<div id="form_loading" style="display:none">
	<?php pc_phrase('Loading...') ?>
</div>

<div id="control_form" <?php if( !$form ) echo 'style="display:none"'; ?>>

<br /><?php if( $subtotal ) : ?>
<div class="b"><?php pc_phrase('total') ?> </div><input id="subtotal" type="text" readonly="readonly" value="--" />
<div id="incomplete"></div><br />
<?php endif; ?>
<?php if( $contact ) : ?>
<input id="company_mail" name="company_mail" type="checkbox" /> <?php pc_phrase('sendmail') ?><br />

<div id="contact_form" style="display:none;">
<table border="0" width="400">
<tr>
<th colspan="2"><?php pc_phrase('contact') ?></th>
</tr>
<tr>
<td ><?php pc_phrase('fullname') ?></td>
<td><input name="fname" type="text" /> <?php pc_phrase('required') ?></td>
</tr>
<tr>
<td ><?php pc_phrase('number') ?></td>
<td><input name="cno" type="text" /> <?php pc_phrase('required') ?></td>
</tr>
<tr>
<td ><?php pc_phrase('email') ?></td>
<td><input name="email" type="text" /> <?php pc_phrase('required') ?></td>
</tr>
<tr>
<td ><?php pc_phrase('address') ?></td>
<td><input name="address" type="text" /></td>
</tr>
<tr>
<td ><?php pc_phrase('city') ?></td>
<td><input name="city" type="text" /></td>
</tr>
<tr>
<td ><?php pc_phrase('state') ?></td>
<td><input name="state" type="text" /></td>
</tr>
<tr>
<td ><?php pc_phrase('comments') ?></td>
<td><textarea style="width: 300px; height: 150px;" name="comments"></textarea></td>
</tr>
</table>

<br />
<input type="checkbox" name="user_mail" /> <?php pc_phrase('send_copy') ?><br />
</div>
<?php endif; // contact ?>
<?php if( $fullquote ) : ?>
<br /><input id="calculate" type="button" value="Get Full Quote" />
<?php endif; ?>
<?php if( $print ) : ?>
<input id="print" type="button" value="Print Full Quote" /> (opens pop-up window)<br /> 
<?php endif ?>
<br />

<div id="response" style="border: 1px solid; width: 600px; display:none"><br /><br /></div>


</div>

</form>
</div>