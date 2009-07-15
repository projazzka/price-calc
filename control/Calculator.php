<?php

/**
 * Control class for bill/sum sheet
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

require_once( dirname( __FILE__ ) . '/../options.php' );
require_once( dirname( __FILE__ ) . '/Storage.php' );
require_once( dirname( __FILE__ ) . '/Mailer.php' );
require_once( dirname( __FILE__ ) . '/Variation.php' );

class Calculator {
	
	function action() {
		$storage = new Storage();
		$prices = $storage->load( Variation::getFromRequest() );
		
		$summands = $this->getSummands( $prices, $_REQUEST );

		if( $_REQUEST['subtotal'] ) {
			$total = $this->getTotal( $summands );
			$this->outputSubtotal( $total );
		} else {
			$out = $this->getQuote( $summands );
	
			$print = $_REQUEST['print'];

			if(!$print) {
				$this->normalResponse( $out );
			} else {
				$this->printResponse( $out );
			}
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
			if( $mailOk && $_REQUEST['user_mail'] ) {
				$mailOk = $mailer->send( $out, $email );
			}
		}
		return $mailOk;
	}

	function getQuote( $summands ) {
		$total = $this->getTotal( $summands );
		$currency = get_option( 'price-calc-currency' );

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
	
	function getSummands( $prices, $values ) {
		global $elements;
		global $titles;
		global $options;
		
		foreach( $elements as $elem ) {
			$id = $elem['id'];
			switch( $elem['type']) {
				case ELEMENT_SELECT:
					$chosen = $values[ $id ];
					if( $chosen ) {
						$title = $titles[$id] . ': ' . $options[$id][ $chosen ];
						$price = $prices[$id][$chosen];
						$result[$title] = $price;
					}
					break;
				case ELEMENT_FIXED:
						$price = $prices[$id];
						$result[$elem['title']] = $price;
					break;
			}
		}
		return $result;
	}
	
	function getTotal( $summands ) {
		$total = 0;
		if( is_array( $summands ) ) 
			foreach( $summands as $summand )
				$total += $summand;
		return $total;
	}
	
	function outputSubtotal( $total ) {
		echo "Subtotal: $total<br />\n";
	}
}

?>