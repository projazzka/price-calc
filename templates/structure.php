<?php

/**
 * back-end structure settings template
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
Variations:<br />
List of product general variations. One per line. Id (used internally) and title seperated by vertical lines ('|')
</td>
<td class="values">
<textarea name="variations"><?php echo $variations ?></textarea>
</td>
</tr>
<tr>
<td>
Structure:<br />
This defines all the possible options available for the product variation and its visualisation. The format is described below.<br />
<td class="values">
<textarea name="structure"><?php echo htmlspecialchars($structure) ?></textarea>
</td>
</tr>
<tr>
<td>
Formula:<br />
List of steps to be made for the calculation. Format: operator ('+','*','%' or '=') followed by a form field identifier.<br />
Use '=result' to save an intermediate result into a memory named 'result'.
If the formula is left blank then addition is applied to all form fields.
</td>
<td class="values">
<textarea name="formula"><?php echo $formula ?></textarea>
</td>
</tr>
<tr>
<td>
Quote display:<br />
A list of items to be shown in the printed quote. Format per line: id|title. If title is left blank, then title from the form is used.
If left blank, all items are shown. You can also use values stored with the '=' operator in the formula. Use '@result' as an id to show
the memory named 'result'.
</td>
<td class="values">
<textarea name="format"><?php echo htmlspecialchars($format, ENT_NOQUOTES) ?></textarea>
</td>
</tr>
<tr>
<td>
Extra validation:<br />
Add additional validations to be performed when the user submits the form.
field1=field2;Field 1 and 2 have to be different.
</td>
<td class="values">
<textarea name="validation"><?php echo $validation ?></textarea>
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