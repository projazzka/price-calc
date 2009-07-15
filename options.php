<?php

/**
 * definitions about product variation and options
 * 
 * (c) 2009 by Igor Prochazka (thickthumb.com)
 */

require_once( dirname( __FILE__ ) . "/control/Options.php" );

global $options;
global $variations;
global $contact_info;
global $contact_obligatory;
global $titles;
global $elements;
global $options;
global $all_select;
global $all_fixed;
global $obligatory;

// used for javascript form checking:
$contact_info = array( "user_mail", "company_mail", "fname", "cno", "email", "address", "city", "state", "comments" );
$contact_obligatory = array( "fname", "cno", "email" );

// general product variations


$opts = new Options();

// terms used in the invoice:
$titles = $opts->getTitles();
$elements = $opts->getElements();
$options = $opts->getOptions();
$all_select = $opts->getAllSelect();
$all_fixed = $opts->getAllFixed();
$obligatory = $opts->getObligatory();
$variations = $opts->getVariations();

?>
