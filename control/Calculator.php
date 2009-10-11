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

		$print = $_REQUEST['print'];

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
		echo '<html><body><a href="javascript:window.print()">Print</a><br />';
		echo $out;
		echo '</body></html>';
	}

	function send( $out ) {
		$mailOk = true;
		
		if( $_REQUEST['company_mail'] ) {
			$mailer = new Mailer();
			$mailOk = $mailer->send( $out );
			if( $mailOk && ($email = $_REQUEST['email']) ) {
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
		ob_end_clean();

		ob_start();
		include( PRICE_CALC_TEMPLATES . 'sum.php' );
		$sum = ob_get_contents();
		ob_end_clean();

		$out .= '<div class="sum">' . wpautop( get_option( 'price-calc-bidformat' ) ) . '</div>';
		
		$out = str_replace( '%sum%', $sum, $out );
		$out = str_replace( '%fname%', $_REQUEST['fname'] /*htmlspecialchars($_REQUEST['fname'])*/, $out );
		$out = str_replace( '%cno%', htmlspecialchars($_REQUEST['cno']), $out );
		$out = str_replace( '%email%', htmlspecialchars($_REQUEST['email']), $out );
		$out = str_replace( '%address%', htmlspecialchars($_REQUEST['address']), $out );
		$out = str_replace( '%city%', htmlspecialchars($_REQUEST['city']), $out );
		$out = str_replace( '%state%', htmlspecialchars($_REQUEST['state']), $out );
		$out = str_replace( '%comments%', htmlspecialchars($_REQUEST['comments']), $out );

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
				if(($operator == '+' && $val == 0 ) || 
					( $operator == '*' && $val == 1 ) ||
					( $operator == '%' && $val == 0 ))
				$suppress = true;
			}
			if( !$suppress )
				$concepts[] = array( 'title'=>$title, 'value'=>$val, 'operator'=>$operator );
		}
		return $concepts;
	}
	
}

?>