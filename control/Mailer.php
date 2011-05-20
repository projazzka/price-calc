<?php

class Mailer {
	function send( $msg, $to = null ) {
		$from = get_option( 'price-calc-email' );
		if( !$to )
			$to = $from;
		
		$message .= "$msg\r\n\r\n";
		$subject = get_option( 'price-calc-subject' );
		$headers = 'From: '. $from . "\r\n" .
		"Content-type: text/html\r\n"; 
	    'Reply-To: ' . $from . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();
		
		return @wp_mail( $to, $subject, $message, $headers );
	}
}

?>
