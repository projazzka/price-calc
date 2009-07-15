<?php

class Mailer {
	function send( $msg ) {
		$email = get_option( 'price-calc-email' );
		
		$message .= "$msg\r\n\r\n";
		$subject = get_option( 'price-calc-subject' );
		$headers = 'From: '. $email . "\r\n" .
		"Content-type: text/html\r\n"; 
	    'Reply-To: ' . $email . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();
		
		return @mail( $email, $subject, $message, $headers );
	}
}

?>