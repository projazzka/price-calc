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

class Form {
	
	function action() {
		echo $this->getForm( Variation::getFromRequest(), $_REQUEST['formstage'], json_decode($_REQUEST['values'], true) );
	}

	function getForm( $variation, $formStage = 1, $values = null) {
		$storage = new Storage();
		$prices = $storage->load( $variation );

		ob_start();

		$options = Options::getInstance();
		$stages = $options->getStages();
		$no_continue = get_option( 'price-calc-nocontinue' );
		$no_back = get_option( 'price-calc-noback' );
		
		$stageElements = $stages[$formStage-1];
		
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
		include( PRICE_CALC_TEMPLATES . 'main_form.php' );
		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	}

}

?>