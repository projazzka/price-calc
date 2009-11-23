<?php

/**
 * Translates phrases. This class implements the control class for the corresponing settings screen
 * and includes the actual translation method as well.
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */


function pc_phrase( $id ) {
	static $instance;
	if( !$instance ) {
		$instance = new Phrases();
	}
	echo $instance->getPhrase($id);
}

class Phrases {
	private $defaults;
	private $phrases;
	
	function __construct() {
		$this->defaults = array(
			'continue' => 'Continue',
			'back' => 'Change',
			'general_variation' => 'General variation:',
			'type' => 'Type:',
			'choose' => '-- Please choose --',
			'fullquote' => 'Get Full Quote',
			'print' => 'Print Full Quote',
			'sendmail' => 'Send inquiry via Email',
			'fullname' => 'Full Name:',
			'required' => '* Required',
			'number' => 'Contact Number:',
			'email' => 'Your E-Mail Address:',
			'address' => 'Address:',
			'city' => 'City:',
			'state' => 'State:',
			'Comments:' => 'Comments:',
			'send_copy' => 'Send Me A Copy via Email',
			'popup' => '(opens pop-up window)',
			'total' => 'Total:',
			'loading' => 'Loading...'
		);
	}
	
	function getDefaults() { return $this->defaults; }
	
	function action() {
		switch( price_calc_get_from_request('action') ) {
			case 'save':
				$this->save();
				break;
			default:
				$this->show();
				break;
		}
	}
	
	function save() {
		$phrases = array();
		foreach( $this->defaults as $key => $default ) {
			$phrases[$key] = price_calc_get_from_request( 'phrase_' . $key );
		}
		
		update_option( 'price-calc-phrases', json_encode( $phrases ));
		$this->show();
	}
	
	function getPhrases() {
		if( !$this->phrases )
			$this->phrases = json_decode( get_option( 'price-calc-phrases' ), true );
		return $this->phrases;
	}
	
	function show() {
		$phrases = $this->getPhrases();
		$defaults = $this->getDefaults();
		
		include( PRICE_CALC_TEMPLATES . 'phrases.php' );
	}
	
	function getPhrase( $id ) {
		$phrases = $this->getPhrases();
		return htmlspecialchars($phrases[$id]);
	}
		
}

?>