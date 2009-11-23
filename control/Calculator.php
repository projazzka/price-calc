<?php

/**
 * Control class for bill/sum sheet
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

require_once( PRICE_CALC_ROOT . 'options.php' );
require_once( PRICE_CALC_CONTROL . '/Storage.php' );
require_once( PRICE_CALC_CONTROL . '/Mailer.php' );
require_once( PRICE_CALC_CONTROL . '/Variation.php' );
require_once( PRICE_CALC_CONTROL . '/Value.php' );
require_once( PRICE_CALC_CONTROL . '/Formula.php' );

class Calculator {

	private $ids;
	private $titles;
	
	function __construct() {
		$this->load();
	}
	
	function load() {
		global $elements;
		
		$data = get_option('price-calc-format');
		$this->ids = array();
		$this->titles = array();
		if( $data ) {
			$lines = explode( "\n", $data );
			foreach( $lines as $line ) {
				$line = trim($line);
				list( $id, $title ) = explode( '|', $line );
				$this->ids[] = $id;
				if( $title )
					$this->titles[$id] = $title;
			}
		} else {
			foreach( $elements as $elem ) {
				if( $elem['type'] != ELEMENT_HEADING ) {
					$this->ids[] = $elem['id'];
				}
			}
			$this->ids[] = '@total';
			$this->titles['@total'] = 'TOTAL';
		}
	}
	
	function action() {
		$storage = new Storage();
		$prices = $storage->load( Variation::getFromRequest() );
		
		$concepts = $this->getConcepts( $prices, $_REQUEST );

		$out = $this->getQuote( $concepts );

		$print = price_calc_get_from_request('print');

		if(!$print) {
			$this->normalResponse( $out );
		} else {
			$this->printResponse( $out );
		}
	}

	function normalResponse( $out ) {
		$mailOk = $this->send( $out );

		$response = array( 
			"error" => ($mailOk) ? "0" : "1",
			"quote" => $out
		);
		echo json_encode( $response );

	}
	
	function printResponse( $out ) {
		$css = get_option( 'price-calc-css' );

		echo '<html><head><style>' . htmlspecialchars($css, ENT_NOQUOTES) . '</style></head><body><a href="javascript:window.print()">Print</a><br />';
		echo $out;
		echo '</body></html>';
	}

	function send( $out ) {
		$mailOk = true;
		
		if( price_calc_get_from_request('company_mail') ) {
			$mailer = new Mailer();
			$mailOk = $mailer->send( $out );
			if( $mailOk && ($email = price_calc_get_from_request('email')) ) {
				$mailOk = $mailer->send( $out, $email );
			}
		}
		return $mailOk;
	}

	function getQuote( $concepts ) {
		$currency = get_option( 'price-calc-currency' );
		$suppresszero = get_option( 'price-calc-suppresszero' );

		ob_start();
		include( PRICE_CALC_TEMPLATES . 'bidformat.php' );
		$out = ob_get_contents();
		$out = apply_filters( 'price-calc-bidformat', $out );
		ob_end_clean();

		ob_start();
		include( PRICE_CALC_TEMPLATES . 'sum.php' );
		$sum = ob_get_contents();
		$sum = apply_filters( 'price-calc-sum', $sum, $concepts );
		ob_end_clean();

		$out .= '<div class="sum">' . wpautop( get_option( 'price-calc-bidformat' ) ) . '</div>';
		
		$out = str_replace( '%sum%', $sum, $out );
		$out = str_replace( '%fname%', htmlspecialchars(price_calc_get_from_request('fname'), ENT_NOQUOTES), $out );
		$out = str_replace( '%cno%', htmlspecialchars(price_calc_get_from_request('cno'), ENT_NOQUOTES), $out );
		$out = str_replace( '%email%', htmlspecialchars(price_calc_get_from_request('email'), ENT_NOQUOTES), $out );
		$out = str_replace( '%address%', htmlspecialchars(price_calc_get_from_request('address'), ENT_NOQUOTES), $out );
		$out = str_replace( '%city%', htmlspecialchars(price_calc_get_from_request('city'), ENT_NOQUOTES), $out );
		$out = str_replace( '%state%', htmlspecialchars(price_calc_get_from_request('state'), ENT_NOQUOTES), $out );
		$out = str_replace( '%comments%', htmlspecialchars(price_calc_get_from_request('comments'), ENT_NOQUOTES), $out );

		$out = apply_filters( 'price-calc-bid', $out );

		return $out;
	}
	
	function getConcepts( $prices, $values ) {
		global $elements;
		global $titles;
		global $options;

		$formula = new Formula();
		$total = $formula->calculate( $prices, $values );
			
		$value = new Value();
			
		foreach( $this->ids as $id ) {
			if( $id[0] == '@' ) {
				$title = $this->titles[ $id ];
				$val = $formula->getMemory( substr( $id, 1 ) );
				$operator = '=';
			} else {
				if( array_key_exists( $id, $this->titles ) )
					$title = $this->titles[ $id ];
				else
					$title = $value->getTitle( $values, $id );
				$val = $value->getValue( $prices, $values, $id );
				$operator = $formula->getOperator( $id );
			}
			$suppress = false;
			if( get_option( 'price-calc-suppresszero' ) ) {
				if($val === false || ($operator == '+' && $val == 0 ) || 
					( $operator == '*' && $val == 1 ) ||
					( $operator == '%' && $val == 0 ))
				$suppress = true;
			}
			if( !$suppress )
				$concepts[] = array( 'id'=>$id, 'title'=>$title, 'value'=>$val, 'operator'=>$operator );
		}
		return $concepts;
	}
	
}

?>