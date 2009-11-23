<?php

/**
 * back-end settings template
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

if(!is_admin())
	die;
?>

<div class="wrap"> 
<div id="price-calc-logo"><br /></div> 
<h2>Price Calculator Settings</h2>
<form method="post" action="">
<div class="metabox-holder meta-box-sortables ui-sortable">
<div id="price-calc-general" class="postbox" style="display:block;">
<div class="handlediv" title="Click to toggle"></div>
<h3 class="hndle">General customization</h3>
<div class="inside">
<p>
<table class="settings">
<tr>
<th>
Company Email:
</th>
<td class="values">
<input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>" />
</td>
</tr>
<tr>
<th>
Email Subject:
</th>
<td class="values">
<input type="text" name="subject" value="<?php echo htmlspecialchars($subject) ?>" />
</td>
</tr>
<tr>
<th>
Custom title for intermediate results:
</th>
<td class="values">
<input type="text" name="subtotaltitle" value="<?php echo htmlspecialchars($subtotaltitle) ?>"/>
</td>
</tr>
<tr>
<th>
Custom result variable for intermediate results:<br />
(See the '=' operator in the formula)
</th>
<td class="values">
<input type="text" name="subtotalvariable" value="<?php echo htmlspecialchars($subtotalvariable) ?>"/>
</td>
</tr>
</table>
<p class="checkboxes">
<input type="radio" name="contact" value="" <?php if( $contact=='' ) echo 'checked="checked"' ?> />
No contact form<br />
<input type="radio" name="contact" value="force" <?php if( $contact=='force' ) echo 'checked="checked"' ?> />
Show obligatory contact form<br />
<input type="radio" name="contact" value="on" <?php if( $contact=='on' ) echo 'checked="checked"' ?> />
Show optional contact form<br />
<label for="print"><input type="checkbox" id="print" name="print" <?php if( $print ) echo 'checked="checked"' ?> />
Show print button</label><br />
<label for="fullquote"><input type="checkbox" id="fullquote" name="fullquote" <?php if( $fullquote ) echo 'checked="checked"' ?>/>
Show full quote button</label><br />
<label for="suppresszero"><input type="checkbox" id="suppresszero" name="suppresszero" <?php if( $suppresszero ) echo 'checked="checked"' ?> />
Suppress zero summands</label><br />
<label for="nocontinue"><input type="checkbox" id="nocontinue" name="nocontinue" <?php if( $nocontinue ) echo 'checked="checked"' ?> />
No continue buttons</label><br />
<label for="novariantcontinue"><input type="checkbox" id="novariantcontinue" name="novariantcontinue" <?php if( $novariantcontinue ) echo 'checked="checked"' ?> />
No continue button for variations</label><br />
<label for="noback"><input type="checkbox" id="noback" name="noback" <?php if( $noback ) echo 'checked="checked"' ?> />
No back buttons</label><br />
<label for="subtotal"><input type="checkbox" id="subtotal" name="subtotal" <?php if( $subtotal ) echo 'checked="checked"' ?> />
Display intermediate results</label><br />
<label for="subtotalspan"><input type="checkbox" id="subtotalspan" name="subtotalspan" <?php if( $subtotalspan ) echo 'checked="checked"' ?> />
Display intermediate result in a span</label><br />
<label for="multitab"><input type="checkbox" id="multitab" name="multitab" <?php if( $multitab ) echo 'checked="checked"' ?> />
Multi-tab form</label><br />
<label for="entertabbing"><input type="checkbox" id="entertabbing" name="entertabbing" <?php if( $entertabbing ) echo 'checked="checked"' ?> />
Use Return key to advance in input elements</label><br />
<label for="preloadstages"><input type="checkbox" id="preloadstages" name="preloadstages" <?php if( $preloadstages ) echo 'checked="checked"' ?> />
Pre-load all form stages</label><br />
</p>
</p></div>
</div>

<div id="price-calc-number" class="postbox" style="display:block;">
<div class="handlediv" title="Click to toggle"></div>
<h3 class="hndle">Number Format</h3>
<div class="inside">
<p>
<table class="settings">
<tr>
<th>
Currency (before number)
</th>
<td class="values">
<input type="text" name="currency" value="<?php echo htmlspecialchars($currency) ?>" />
</td>
</tr>
<tr>
<th>
Currency (behind number)
</th>
<td class="values">
<input type="text" name="currencypost" value="<?php echo htmlspecialchars($currencypost) ?>" />
</td>
</tr>
<tr>
<th>
Number of decimals
</th>
<td class="values">
<select id="decimals" name="decimals">
	<option value="0" <?php if($decimals==0) echo 'selected="selected"' ?>>0</option>
	<option value="1" <?php if($decimals==1) echo 'selected="selected"' ?>>1</option>
	<option value="2" <?php if($decimals==2) echo 'selected="selected"' ?>>2</option>
	<option value="3" <?php if($decimals==3) echo 'selected="selected"' ?>>3</option>
	<option value="4" <?php if($decimals==4) echo 'selected="selected"' ?>>4</option>
	<option value="5" <?php if($decimals==5) echo 'selected="selected"' ?>>5</option>
	<option value="6" <?php if($decimals==6) echo 'selected="selected"' ?>>6</option>
</select>
</td>
</tr>
<tr>
<th>
Thousands separation
</th>
<td class="values">
<input type="text" name="thousands" value="<?php echo htmlspecialchars($thousands) ?>" />
</td>
</tr>
<tr>
<th>
Decimal point
</th>
<td class="values">
<input type="text" name="point" value="<?php echo htmlspecialchars($point) ?>" />
</td>
</tr>
</table>
</p>
</div>
</div>


<div id="price-calc-bidformat" class="postbox" style="display:block;">
<div class="handlediv" title="Click to toggle"></div>
<h3 class="hndle">Bid Format</h3>
<div class="inside">
<div>
<textarea name="bidformat" class="bigtext"><?php echo htmlspecialchars($bidformat) ?></textarea>
<p>Please use the following the following placeholders:
<table class="placeholders">
<tr>
<th>%fname%</th>
<td>Customer's full name</td>
</tr>	
<tr>
<th>%cno%</th>
<td>Customer's contact number</td>
</tr>	
<tr>
<th>%email%</th>
<td>Customer's email address</td>
</tr>	
<tr>
<th>%address%</th>
<td>Customer's address</td>
</tr>	
<tr>
<th>%city%</th>
<td>Customer's city</td>
</tr>	
<tr>
<th>%state%</th>
<td>Customer's state</td>
</tr>	
<tr>
<th>%comment%</th>
<td>Customer's comment</td>
</tr>	
<tr>
<th>%sum%</th>
<td>Detail quote summary (table format)</td>
</tr>	
</table></p>
</div></div></div>

<div class="postbox closed" style="display:block;">
<div class="handlediv" title="Click to toggle"></div>
<h3 class="hndle">Custom CSS Style Sheet</h3>
<div class="inside"><div>
<p>(Leave blank if you prefer to use your theme's styles)</p>
<textarea class="bigtext" name="css"><?php echo htmlspecialchars($css, ENT_NOQUOTES) ?></textarea>
</div>
</div>
</div>
</div>
</div>
<input type="hidden" name="action" value="save" />
<input type="submit" class="button-primary" value="Save" />
</form>
	
</p>
</div>