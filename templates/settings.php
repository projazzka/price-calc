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
Structure:<br />
This defines all the possible options available for the product variation and its visualisation. The format is described above.<br />
<td class="values">
<textarea name="structure"><?php echo htmlspecialchars($structure) ?></textarea>
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
</table>
<input type="hidden" name="action" value="save" />
<input type="submit" value="Save" />
</form>
<p>We know this configuration screen is difficult to use and understand. We would appreciate any 
suggestion. We depend on your help to improve it. Go to the <a href="http://www.thickthumb.com/open-source/price-calc/">official plugin homepage</a>
to support this project.</p>

<p>This is the format for the structure settings:
<table>
<tr>
<th>Element</th>
<th>Format</th>
<th>Description</th>
</tr>
<tr>
<td>Heading</td>
<td><pre>==&lt;id&gt;|&lt;title&gt;</pre></td>
<td><pre>
&lt;id&gt; : unique identifier for internal use only
&lt;title&gt; : heading title
</pre>
</td>
</tr>
<tr>
<td>Fixed value</td>
<td><pre>#&lt;id&gt;|&lt;title&gt;&lt;/pre&gt;</td>
<td><pre>
&lt;id&gt; : unique identifier for internal use only
&lt;title&gt; : the value's title
</pre>
</td>
</tr>
<tr>
<td>Option list</td>
<td><pre>@&lt;id&gt;|&lt;title&gt;&lt;required&gt;|&lt;columns&gt;
-&lt;id1&gt;|&lt;title1&gt;
-&lt;id2&gt;|&lt;title2&gt;
-&lt;id3&gt;|&lt;title3&gt;
...
</pre>
</td>
<td><pre>
&lt;id&gt; : unique identifier for internal use only
&lt;title&gt; : the value's title
&lt;required&gt; : an asterik ('*') if obligatory option. Empty otherwise.
&lt;id1&gt; : the option's identifier
&lt;title1&gt; : the option's title
</pre>
</td>
</tr>
</table>
	
</p>