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
var all_select=<?php echo json_encode( $all_select ) ?>;
var all_fixed=<?php echo json_encode( $all_fixed ) ?>;
var contact=<?php echo json_encode($contact_info) ?>;
var contact_obligatory=<?php echo json_encode($contact_obligatory) ?>;
</script>

<script src="<?php echo PRICE_CALC_AJAX_URL ?>front.js"></script>
<style>
	
div#price_calc {
	font-family: Arial, Helvetica, sans-serif;
	text-align: left;
}

#response {
	padding: 30px;
}

table tr th {
	padding-top: 30px;
	text-align: left;
}

table tr td {
	text-align: left;
}
</style>	

<div id="price_calc">
<form id="variations" style="margin-bottom:0;" action="">

<?php if(!$variation) : ?>
<div id="variation_form">
<table border="0" width="400">
<tbody>
<tr>
<th colspan="2">General variation</th>
</tr>
<tr>
<td>
<div class="b">Type:</div></td>
<td align="left">
	<select name="variation" id="variation">
		<option value="0">-- Please choose --</option>
		<? foreach( $variations as $id => $title ) : ?>
			<option value="<?php echo $id ?>"><?php echo $title ?></option>
		<? endforeach; ?>
	</select>
	<input type="button" id="continue" value="Continue" />
</td>
</tr>
</table>
</div>
<?php endif; ?>

<input type="hidden" id="variation" name="variation" value="<?php echo $variation ?>" />

<div id="main_form">
<?php if( $variation ) : ?>
<?php echo $form ?>
<?php endif; ?>
</div>

<div id="control_form" <?php if( !$form ) echo 'style="display:none"'; ?>>

<br /><?php if( $subtotal ) : ?>
<div class="b">Total: </div><input id="subtotal" type="text" value="--" />
<div id="incomplete"></div><br />
<?php endif; ?>
<?php if( $contact ) : ?>
<input id="company_mail" name="company_mail" type="checkbox" /> Send inquiry via Email<br />

<div id="contact_form" style="display:none;">
<table border="0" width="400">
<tr>
<th colspan="2">Contact information</th>
</tr>
<tr>
<td >Full Name:</td>
<td><input name="fname" type="text" /> * Required</td>
</tr>
<tr>
<td >Contact Number:</td>
<td><input name="cno" type="text" /> * Required</td>
</tr>
<tr>
<td >Your E-Mail Address:</td>
<td><input name="email" type="text" /> * Required</td>
</tr>
<tr>
<td >Address:</td>
<td><input name="address" type="text" /></td>
</tr>
<tr>
<td >City:</td>
<td><input name="city" type="text" /></td>
</tr>
<tr>
<td >State:</td>
<td><input name="state" type="text" /></td>
</tr>
<tr>
<td >Comments:</td>
<td><textarea style="width: 300px; height: 150px;" name="comments"></textarea></td>
</tr>
</table>

<br />
<input type="checkbox" name="user_mail" /> Send Me A Copy via Email<br />
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