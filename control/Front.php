<?php

require_once( PRICE_CALC_ROOT . 'options.php' );
require_once( PRICE_CALC_CONTROL . 'Form.php' );

class Front {
	function action( $param_str ) {
		global $options;
		global $variations;
		global $contact_info;
		global $contact_obligatory;
		global $titles;
		global $elements;
		global $options;
		global $all_select;
		global $all_fixed;
		global $obligatory;
		
		$fullquote = get_option( 'price-calc-fullquote' );
		$contact = get_option( 'price-calc-contact' );
		$print = get_option( 'price-calc-print' );
		$subtotal = get_option( 'price-calc-subtotal' );
		
		parse_str( $param_str, $params );
		$variation = $params['variation'];
		if( $variation ) {
			$control = new Form();
			$form = $control->getForm( $variation );
		} elseif( count( $variations ) == 1 ) {
			reset( $variations );
			$variation = key( $variations );
			$control = new Form();
			$form = $control->getForm( $variation );
		}
		ob_start();
		include( PRICE_CALC_TEMPLATES . 'front.php' );
		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	}
}

?>
