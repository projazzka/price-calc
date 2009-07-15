<?php
/**
 * template for invoice/bid
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */
?>

<style>

div.sum {
	text-align: left;
	font-family: Courier;
	font-size: 1em;
	
}

table.sum {
	border-collapse: collapse;
	font-family: Courier;
	font-size: 1em;
}
table.sum td, table#sum tr {
	border-style: solid;
	border-width: 1px;	
	padding: 2px;
	margin: 2px;
}

td.price {
	text-align: right;
}
</style>

<?php if( $print ) : ?>
	<a href="javascript:window.print();">Print</a>
<?php endif; ?>

