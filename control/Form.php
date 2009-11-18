<?php

/**
 * Control class for retrieval of main price form
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

require_once( PRICE_CALC_ROOT . 'options.php' );
require_once( PRICE_CALC_CONTROL . 'Phrases.php' );
require_once( PRICE_CALC_CONTROL . 'Storage.php' );
require_once( PRICE_CALC_CONTROL . 'Variation.php' );
require_once( PRICE_CALC_CONTROL . 'Element.php' );
require_once( PRICE_CALC_CONTROL . 'Formula.php' );

class Form {
	
	function action() {
		echo $this->getForm( Variation::getFromRequest(), $_REQUEST['formstage'], json_decode($_REQUEST['values'], true) );
	}

	function getForm( $variation, $stage = 0, $values = null) {
		$storage = new Storage();
		$prices = $storage->load( $variation );

		$options = Options::getInstance();
		$stages = $options->getStages();
		$no_continue = get_option( 'price-calc-nocontinue' );
		$no_back = get_option( 'price-calc-noback' );

		if( $stage ) {
			$start = $stage;
			$end = $stage + 1;
		} else {
			$start = 1;
			$end = count( $stages ) + 1;
		}
		
		for( $formStage=$start; $formStage<$end; $formStage++ )	{
			$stageElements = $stages[$formStage-1];
	
			$elems = array();
			foreach( $stageElements as $element ) {
				$obj = new Element( $element );
				if( $obj->isEnabled( $prices ) ) {
					if( $condition = $element['condition'] ) {
						if( $condition->check( $values ) ) {
							$elems[] = $element;
						}
					} else {
						$elems[] = $element;
					}
				}
			}
			
			if( $formStage < count($stages) )
				$nextStage = $formStage + 1;
			else
				$nextStage = false;

			$hide = (!$stage && $formStage > 1 );

			ob_start();
			include( PRICE_CALC_TEMPLATES . 'main_form.php' );
			$stageOut = ob_get_contents();
			ob_end_clean();
			
			$formula = new Formula();
			$formula->calculate( $prices, $values );
			$stageOut = apply_filters( 'price-calc-form-evaluate', $stageOut, $formStage, $formula );
			$out .= $stageOut;
		}
		return $out;
	}

}

?>