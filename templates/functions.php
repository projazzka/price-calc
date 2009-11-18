<?php

if( !function_exists( 'output_select' ) ) {
	function output_select( $id, $prices, $on_change_next = false, $stage = 0, $default = '' ) {
		global $options;
		global $obligatory;
		
		echo "<select name=\"$id\" id=\"$id\" " . ($on_change_next ? "class=\"on_change_next\" stage=\"$stage\"" : "") . ">";
		foreach( $options[$id] as $value => $title ) {
			$price = $prices[$id][$value];
			if( $price !== '' ) {
				$selected = ($default === $value) ? 'selected="selected"' : '';
				echo '<option value="' . $value . '" price="' . $price . '" ' . $selected . '>' . $title . '</option>';
			}
		}
		echo "</select>";
		if( array_search( $id, $obligatory ) !== false ) {
			echo '&nbsp;<span class="required">' . pc_phrase('required') . '</span>';
		}
	}
}

if( !function_exists( 'output_fixed' ) ) {
	function output_fixed( $id, $prices ) {
		echo "<input type=\"hidden\" id=\"$id\" name=\"$id\" price=\"" . $prices[$id] . "\" />";
	}
}

if( !function_exists( 'output_number' ) ) {
	function output_number( $id, $prices, $default = '' ) {
		echo "<input type=\"text\" id=\"$id\" name=\"$id\" price=\"" . $prices[$id] . "\" value=\"" . $default . "\" />";
	}
}

if( !function_exists( 'output_checkbox' ) ) {
	function output_checkbox( $id, $prices, $default = ''  ) {
		if( $default )
			$checked = 'checked = "checked" ';
		echo "<input type=\"checkbox\" id=\"$id\" name=\"$id\" price=\"" . $prices[$id] . "\" $checked />";
	}
}

if( !function_exists( 'output_result' ) ) {
	function output_result( $id, $variable ) {
		echo "<span id=\"$id\"></span>";
	}
}

if( !function_exists( 'price_calc_number') ) {
	function price_calc_number( $number, $isFactor = false, $isPercentage = false ) {
		$out =	number_format( $number, get_option( 'price-calc-decimals' ), get_option( 'price-calc-point' ), get_option( 'price-calc-thousands' ));
		if( !($isFactor || $isPercentage) )
			$out = get_option( 'price-calc-currency' ) . $out . get_option( 'price-calc-currencypost' );
		return $out;
	}
}

if( !function_exists( 'output_classes') ) {
	function output_classes( $type, $elem ) {
		echo $type;
		if( $elem['id'] )
			echo ' ' . $elem['id'];
		if( $elem['classes'] )
			echo ' ' . $elem['classes'];
	}
}

?>
