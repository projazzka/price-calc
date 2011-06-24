<?php
/*
Plugin Name: price-calc
Plugin URI: http://www.thickthumb.com/open-source/price-calc/
Description: Displays a configurable price calculator for your products
Version: 0.7.0
Author: Igor Prochazka
Author URI: http://www.thickthumb.com

---------------------------------------------------------------------
	This file is part of the wordpress plugin "price-calc"
    Copyright (C) 2009 by Igor Prochazka

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

---------------------------------------------------------------------
*/

define('PRICE_CALC_VERSION', '0.7.0');

include( dirname( __FILE__) . '/env.php' );

wp_enqueue_script('jquery');

function price_calc_replace( $content ) {
	$content = preg_replace_callback( PRICE_CALC_PATTERN, "price_calc_callback", $content );
	return $content;
}

function price_calc_callback( $matches ) {
	require_once( PRICE_CALC_CONTROL . 'Front.php' );
	
	$front = new Front();
	return $front->action($matches[1]);
}

function price_calc_head() {
	$url = htmlspecialchars( plugin_dir_url( __FILE__ ) );
	echo '<link rel="stylesheet" type="text/css" href="' . $url . "admin-style.css\" />\n";
	echo '<script src="' . $url . 'ajax/back.js" ></script>' . "\n";
}

function price_calc_admin() {
    require_once( PRICE_CALC_CORE . 'Compatibility.php');
  
	// top-level menu
	add_object_page("Calculator", "Calculator", -1, __FILE__, "price-calc_plugin");
	
	$compatibility = new PC_Compatibility();
	if($compatibility->toBeUpgraded()) {
		add_submenu_page(__FILE__,"Upgrade","Upgrade", 8, PRICE_CALC_ROOT . "upgrade.php");		
	} else {
		add_submenu_page(__FILE__,"Prices","Prices", 8, PRICE_CALC_ROOT . "back.php");
		add_submenu_page(__FILE__,"Structure","Structure", 8, PRICE_CALC_ROOT . "structure.php");
		add_submenu_page(__FILE__,"Phrases","Phrases", 8, PRICE_CALC_ROOT . "phrases.php");
		$page = add_submenu_page(__FILE__,"Settings","Settings", 8, PRICE_CALC_ROOT . "settings.php");
	}
	if( strpos( $_REQUEST['page'], 'price-calc' ) !== false ) {
		add_action( 'admin_head', 'price_calc_head' );
		wp_enqueue_script('jquery-ui-sortable');
	}
}

function price_calc_init() {
	if( $_REQUEST['price-calc-ajax'] == '1' ) {
		require_once( PRICE_CALC_CONTROL . 'Calculator.php' );
		
		$calc = new Calculator();
		$calc->action();	
		exit();
	} elseif( $_REQUEST['price-calc-form'] == '1' ) {
		require_once( PRICE_CALC_CONTROL . 'Form.php' );

		$form = new Form();
		$form->action();	

		exit();
	}
}

function price_calc_activate() {
	static $default_options;
	
	require_once( PRICE_CALC_CONTROL . 'Phrases.php' );
	
	$phrases = new Phrases();
	
	$default_options = array(
		'price-calc-bidformat' => "Give your pet a new home!\r\n<table>\r\n	<tr><td>Full name:</td><td>%fname%</td></tr>\r\n	<tr><td>Contact number:</td><td>%cno%</td></tr>\r\n	<tr><td>Email:</td><td>%email%</td></tr>\r\n	<tr><td>Comment:</td><td>%comments%</td></tr>\r\n</table>\r\n\r\n%sum%\r\n\r\n<p>Thank you for your inquiry!</p>",
		'price-calc-contact' => 'on',
		'price-calc-currency' => '$',
		'price-calc-point' => '.',
		'price-calc-decimals' => '2',
		'price-calc-subject' => 'Cost Estimate',
		'price-calc-email' => 'test@localhost',
		'price-calc-fullquote' => 'on',
		'price-calc-print' => 'on',
		'price-calc-structure' => "#base_price|Base Price\r\n== Dimensions\r\n@base_dim|Base*|2\r\n-0|Base\r\n-2x3|2 x 3 FT\r\n-3x4|3 x 4 FT\r\n-3x5|3 x 5 FT\r\n-6x6|6 x 6 FT\r\n@base_height|Height*|2|\r\n-0|-- Height --\r\n-5|5 FT\r\n-6|6 FT\r\n-7|7 FT\r\n-8|8 FT\r\n-9|9 FT\r\n-10|10 FT\r\n-11|11 FT\r\n-12|12 FT\r\n== Extras\r\n@color|Color|2|\r\n-0|Standard\r\n-black|black\r\n-white|white\r\n-red|red\r\n-green|green\r\n@windows|windows|6|\r\n-0|-- Quantity --\r\n-1|1 Window\r\n-2|2 Window\r\n-3|3 Window\r\n@door|Extra Door\r\n-0|No\r\n-1|Yes",
		'price-calc-subtotal' => 'on',
		'price-calc-table-cat' => '{"base_price":"150","base_dim":{"2x3":"12","3x5":"20","3x4":"14","6x6":"30"},"base_height":{"5":"0","9":"","6":"0","10":"","7":"10","11":"","8":"","12":""},"color":{"black":"0","red":"0","white":"0","green":"10"},"windows":{"1":"5","2":"10","3":"15"},"door":{"1":""}}',
		'price-calc-table-dog' => '{"base_price":"100","base_dim":{"2x3":"10","3x5":"30","3x4":"20","6x6":"50"},"base_height":{"5":"0","9":"5","6":"0","10":"5","7":"0","11":"5","8":"0","12":"5"},"color":{"black":"0","red":"20","white":"0","green":"20"},"windows":{"1":"50","2":"100","3":"150"},"door":{"1":"15"}}',
		'price-calc-table-puppet' => '{"base_price":"300","base_dim":{"2x3":"40","3x5":"60","3x4":"50","6x6":"70"},"base_height":{"5":"0","9":"20","6":"10","10":"20","7":"10","11":"30","8":"20","12":"30"},"color":{"black":"5","red":"10","white":"5","green":"10"},"windows":{"1":"45","2":"90","3":"135"},"door":{"1":"20"}}',
		'price-calc-variations' => "dog|Dog House\r\ncat|Cat House\r\npuppet|Puppet House\r\n",
		'price-calc-phrases' => json_encode($phrases->getDefaults()),
		'price-calc-css' => "div#price_calc {\r\n	font-family: Arial, Helvetica, sans-serif;\r\n	text-align: left;\r\n}\r\n\r\n#response {\r\n	padding: 30px;\r\n}\r\n\r\n#price_calc table {\r\n	width: 500px;\r\n}\r\n\r\n#price_calc th {\r\n	width:100px;        \r\n	margin-top: 30px;\r\n	text-align: left;\r\n}\r\n\r\n#price_calc td {\r\n	width:200px;\r\n}\r\n\r\n#price_calc table.sum td {\r\n	width:200px;\r\n}\r\n\r\n.stage-control {\r\n	text-align: left;\r\n}\r\n\r\n#response {\r\n	border: 1px solid; width: 600px; display:none;\r\n}\r\n\r\ndiv.sum {\r\n	text-align: left;\r\n	font-family: Courier;\r\n	font-size: 1em;\r\n	\r\n}\r\n\r\ntable.sum {\r\n	border-collapse: collapse;\r\n	font-family: Courier;\r\n	font-size: 1em;\r\n}\r\ntable.sum td, table#sum tr {\r\n	border-style: solid;\r\n	border-width: 1px;	\r\n	padding: 2px;\r\n	margin: 2px;\r\n}\r\n\r\ntable.sum td.concept {\r\n	text-align: left;\r\n}\r\n\r\ntable.sum td.price {\r\n	text-align: right;\r\n}"
	);
	foreach( $default_options as $key => $value ) {
		add_option( $key, $value );
	}
}

function price_calc_get_from_request( $id ) {
	$value = $_REQUEST[$id];
	$value = stripslashes( $value );
	return $value;
}

/* register filter hook */

register_activation_hook( __FILE__, 'price_calc_activate' );
add_filter('widget_text', 'price_calc_replace');
add_filter('the_content', 'price_calc_replace');
add_action('admin_menu', 'price_calc_admin' );
add_action('init', 'price_calc_init' );


?>