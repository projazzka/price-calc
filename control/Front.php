<?php

require_once( PRICE_CALC_ROOT . 'options.php' );
require_once( PRICE_CALC_CONTROL . 'Phrases.php' );
require_once( PRICE_CALC_CONTROL . 'Form.php' );
require_once( PRICE_CALC_CONTROL . 'Formula.php' );
require_once( PRICE_CALC_CONTROL . 'Validation.php' );

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
		
		$opts = Options::getInstance();
		$results = $opts->getResults();
		$stageNames = $opts->getStageNames();
		$stages = $opts->getStages();
		
		$fullquote = get_option( 'price-calc-fullquote' );
		$contact = get_option( 'price-calc-contact' );
		$print = get_option( 'price-calc-print' );
		$subtotal = get_option( 'price-calc-subtotal' );
		$css = get_option( 'price-calc-css' );
		$subtotaltitle = get_option( 'price-calc-subtotaltitle');
		$subtotalvariable = get_option( 'price-calc-subtotalvariable');
		$subtotalspan = get_option( 'price-calc-subtotalspan');
		$no_variant_continue = get_option( 'price-calc-novariantcontinue');
		$decimals = get_option( 'price-calc-decimals' ); 
		$currency = get_option( 'price-calc-currency' );
		$currencypost = get_option( 'price-calc-currencypost' );
		$thousands = get_option( 'price-calc-thousands' );
		$point = get_option( 'price-calc-point' );
		$multitab = get_option( 'price-calc-multitab' );
		$entertabbing = get_option( 'price-calc-entertabbing' );
		$preloadstages = get_option( 'price-calc-preloadstages' );

		$formula = new Formula();
		$formula_ids = $formula->getIds();
		$formula_operators = $formula->getOperators();
		
		$validation = new Validation();
		$validators = $validation->outputJavaScript();
		
		foreach( $elements as $key => $data ) {
			$type = $data['type'];
			if( in_array( $type, array( 'select', 'fixed', 'number', 'checkbox' ) ) ) {
				$types[ $data['id'] ] = $type;
			}
		}
		
		parse_str( $param_str, $params );
		$variation = $params['variation'];
		if( get_option('price-calc-preloadstages') )
			$stage = 0;
		else
			$stage = 1;
		if( $variation ) {
			$control = new Form();
			$form = $control->getForm( $variation, $stage );
		} elseif( count( $variations ) == 1 ) {
			reset( $variations );
			$variation = key( $variations );
			$control = new Form();
			$form = $control->getForm( $variation, $stage );
		}
		ob_start();
		include( PRICE_CALC_TEMPLATES . 'front.php' );
		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	}
}

?>
