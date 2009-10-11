<?php

/**
 * back-end phrases settings template
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

td.values input {
	width: 100%;
}

td, th {
	vertical-align:top;
	text-align:left;
	padding: 10px;
}

</style>
<h2>Price Calculator Phrases</h2>
<p>You can customize the words and phrases that will appear on the front-end form here.</p>
<form method="post" action="">
<table class="settings">
<?php foreach( $defaults as $key => $default ) : ?>
	<tr>
	<td>
	"<?php echo $default ?>"
	</td>
	<td class="values">
	<input type="text" name="phrase_<?php echo $key ?>" value="<?php echo addslashes($phrases[$key]) ?>" />
	</td>
	</tr>
<?php endforeach ?>
</table>
<input type="hidden" name="action" value="save" />
<input type="submit" value="Save" />
</form>
