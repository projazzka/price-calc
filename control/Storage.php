<?php
	
require_once( PRICE_CALC_ROOT . 'options.php' );

class Storage {
	function save( $variation, $values ) {
		global $options;
		foreach( array_keys($options) as $item ) {
			$data[$item] = $values[ $item ];
		}
		update_option( $this->getOptionName( $variation ), json_encode( $data ) );
   	}
	
	function load( $variation ) {
		global $options;

		$data = get_option( $this->getOptionName( $variation ) );
		$result = json_decode( $data, true );
		return $result;
	}
	
	function getOptionName( $variation ) {
		$filename = sprintf( PRICE_CALC_OPTION_PATTERN, $variation );
		return $filename;
	}

}
	
?>
