<?php
	define( 'PRICE_CALC_PATTERN', "/\[price-calc([^\]]*)\]/" );
	define( 'PRICE_CALC_OPTION_PATTERN', 'price-calc-table-%s');

	/* paths */
    define( 'PRICE_CALC_ROOT', dirname(__FILE__) . '/' );
	define( 'PRICE_CALC_CONTROL', PRICE_CALC_ROOT . 'control/' );
	define( 'PRICE_CALC_CORE', PRICE_CALC_ROOT . 'core/' );
	define( 'PRICE_CALC_TEMPLATES', PRICE_CALC_ROOT . 'templates/' );
	define( 'PRICE_CALC_DATA', PRICE_CALC_ROOT . 'data/' );
	define( 'PRICE_CALC_AJAX', PRICE_CALC_ROOT . 'ajax/' );
	define( 'PRICE_CALC_AJAX_URL', plugin_dir_url( PRICE_CALC_ROOT ) . 'price-calc/ajax/' );

?>