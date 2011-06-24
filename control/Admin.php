<?php

/**
 * Base class for control classes
 * 
 * (c) 2011 by Igor Prochazka (l90r.com)
 */

class PC_Admin {
	protected $title, $data;
    	
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

    function assign($key, $value) {
        $this->data[$key] = $value;
    }
    
	function save() {
		$this->show();
	}
	
	function show() {
        $this->head();
		if($this->data) {
            extract($this->data);
        }
		include( PRICE_CALC_TEMPLATES . $this->template );
        $this->foot();
	}
    
    function head() {
		$title = $this->title;
		include( PRICE_CALC_TEMPLATES . 'head.php' );        
    }
    
    function foot() {
        include( PRICE_CALC_TEMPLATES . 'foot.php' );
    }
}

?>