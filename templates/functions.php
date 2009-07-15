<?php

if( !function_exists( 'is_select_disabled' ) ) {
	function is_select_disabled( $id, $prices ) {
		if( !is_array($prices[$id]) )
			return true;
		foreach( $prices[$id] as $price )
			if( $price !== '' ) return false;
		return true;
	}
}

if( !function_exists( 'output_select' ) ) {
	function output_select( $id, $prices ) {
		global $options;
		global $obligatory;
		
		echo "<select name=\"$id\" id=\"$id\">";
		foreach( $options[$id] as $value => $title ) {
			$price = $prices[$id][$value];
			if( $price !== '' )
				echo "<option value=\"$value\" price=\"$price\">$title</option>";
		}
		echo "</select>";
		if( array_search( $id, $obligatory ) !== false ) {
			echo " * Required";
		}
	}
}

if( !function_exists( 'output_fixed' ) ) {
	function output_fixed( $id, $prices ) {
		echo "<input type=\"hidden\" id=\"$id\" price=\"" . $prices[$id] . "\" />";
	}
}

?>
