<?php

/**
 * back-end settings template
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

if(!is_admin())
	die;
?>

<style>
td.values {
	width: 80%;
}

td.values textarea {
	width: 100%;
	height: 300px;
}

td, th {
	vertical-align:top;
	text-align:left;
	padding: 10px;
}

</style>
<h2>Price Calculator Settings</h2>

<form method="post" action="">
<table class="settings">
<tr>
<td>
Company Email:
</td>
<td class="values">
<input type="text" name="email" value="<?php echo addslashes($email) ?>" />
</td>
</tr>
<tr>
<td>
Email Subject:
</td>
<td class="values">
<input type="text" name="subject" value="<?php echo addslashes($subject) ?>" />
</td>
</tr>
<tr>
<td>
Currency:
</td>
<td class="values">
<input type="text" name="currency" value="<?php echo addslashes($currency) ?>" />
</td>
</tr>

<tr>
<td>
Show contact form:<br />
</td>
<td class="values">
<input type="checkbox" name="contact" <?php if( $contact ) echo 'checked="checked"' ?>"/>
</td>
</tr>
<tr>
<td>
Show print button:
</td>
<td class="values">
<input type="checkbox" name="print" <?php if( $print ) echo 'checked="checked"' ?>"/>
</td>
</tr>
<tr>
<td>
Show full quote button:
</td>
<td class="values">
<input type="checkbox" name="fullquote" <?php if( $fullquote ) echo 'checked="checked"' ?>"/>
</td>
</tr>
<tr>
<td>
Suppress zero summands:
</td>
<td class="values">
<input type="checkbox" name="suppresszero" <?php if( $suppresszero ) echo 'checked="checked"' ?>"/>
</td>
</tr>
<tr>
<td>
No continue buttons:
</td>
<td class="values">
<input type="checkbox" name="nocontinue" <?php if( $nocontinue ) echo 'checked="checked"' ?>"/>
</td>
</tr>
<tr>
<td>
No back buttons:
</td>
<td class="values">
<input type="checkbox" name="noback" <?php if( $noback ) echo 'checked="checked"' ?>"/>
</td>
</tr>
<tr>
<tr>
<td>
Display intermediate results:
</td>
<td class="values">
<input type="checkbox" name="subtotal" <?php if( $subtotal ) echo 'checked="checked"' ?>"/>
</td>
</tr>
<tr>
<td>
Bid Format:<br />
Please use the following the following placeholder:
<table>
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
</table>
</td>
<td class="values">
<textarea name="bidformat"><?php echo htmlspecialchars($bidformat) ?></textarea>
</td>
</tr>
<tr>
<td>
Variations:<br />
List of product general variations. One per line. Id (used internally) and title seperated by vertical lines ('|')
</td>
<td class="values">
<textarea name="variations"><?php echo $variations ?></textarea>
</td>
</tr>
<tr>
<td>
CSS Style Sheet:<br />
(Leave blank if you prefer to use your theme's styles)
</td>
<td class="values">
<textarea name="css"><?php echo htmlspecialchars($css, ENT_NOQUOTES) ?></textarea>
</td>
</tr>
</table>
<input type="hidden" name="action" value="save" />
<input type="submit" value="Save" />
</form>
<p>We know this configuration screen is difficult to use and understand. We would appreciate any 
suggestion. We depend on your help to improve it. Go to the <a href="http://www.thickthumb.com/open-source/price-calc/">official plugin homepage</a>
to support this project.</p>
	
</p>