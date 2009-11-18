<?php

/**
 * back-end structure settings template
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

if(!is_admin())
	die;
?>

<div class="wrap"> 
<div id="price-calc-logo"><br /></div> 
<h2>Price Calculator - Structure</h2>
<div id="price-calc-structure">

<form method="post" action="">
<div class="metabox-holder meta-box-sortables ui-sortable">
	
<div id="price-calc-variations" class="price-calc-bigbox postbox">
<div class="handlediv" title="Click to toggle"></div>
<h3 class="hndle">Variations</h3>
<div class="inside">
<p>List of product general variations. One per line. Id (used internally) and title seperated by vertical lines ('<code>|</code>')
</p>
<textarea name="variations"><?php echo $variations ?></textarea>
</div>
</div>

<div id="price-calc-elements" class="price-calc-bigbox postbox">
<div class="handlediv" title="Click to toggle"></div>
<h3 class="hndle">Structure</h3>
<div class="inside">
	<p>
		This defines all the possible options available for the product variation and its visualisation.
	</p>
	<textarea name="structure"><?php echo htmlspecialchars($structure) ?></textarea>
</div>
</div>

<div id="price-calc-formula" class="price-calc-bigbox postbox closed">
<div class="handlediv" title="Click to toggle"></div>
<h3 class="hndle">Formula</h3>
<div class="inside">
<p>List of steps to be made for the calculation. Format: operator ('<code>+</code>','<code>*</code>','<code>%</code>' or '<code>=</code>') followed by a form field identifier.<br />
Use '<code>=result</code>' to save an intermediate result into a memory named '<code>result</code>'.
If the formula is left blank then addition is applied to all form fields.
</p>
<textarea name="formula"><?php echo $formula ?></textarea>
</div>
</div>

<div id="price-calc-format" class="price-calc-bigbox postbox closed">
<div class="handlediv" title="Click to toggle"></div>
<h3 class="hndle">Quote display</h3>
<div class="inside">
<p>A list of items to be shown in the printed quote. Format per line: <code>id|title</code>. If title is left blank, then title from the form is used.
If left blank, all items are shown. You can also use values stored with the '<code>=</code>' operator in the formula. Use '<code>@result</code>' as an id to show
the memory named '<code>result</code>'.</p>
<textarea name="format"><?php echo htmlspecialchars($format, ENT_NOQUOTES) ?></textarea>
</div></div>

<div id="price-calc-validation" class="price-calc-bigbox postbox closed">
<div class="handlediv" title="Click to toggle"></div>
<h3 class="hndle">Extra validation:</h3>
<div class="inside">
<p>Add additional validations to be performed when the user submits the form.
For example <code>field1=field2</code> means an alert is raised when Field 1 and 2 are equal.</p>
<textarea name="validation"><?php echo $validation ?></textarea>
</div></div>

<input type="hidden" name="action" value="save" />
<input type="submit" value="Save" class="button-primary" />
</form>

<p>I know this configuration screen is difficult to use and understand. I would appreciate any 
suggestion. I depend on your support to improve it. Go to the <a href="http://www.thickthumb.com/open-source/price-calc/">official plugin homepage</a>
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
</div>