<?php

/**
 * Compatibility
 * 
 * (c) 2011 by Igor Prochazka (l90r.com)
 */

class PC_Version {
    public $major, $minor, $maintenance, $version;
    
    public function __construct($version = NULL) {
        if($version) {
            $this->parse($version);
        }
    }

    public function parse($version) {
        sscanf($version, "%d.%d.%d", $this->major, $this->minor, $this->maintenance);
        $this->version = $version;        
    }

    public function newerThan($other) {
        return $this->toHex() > $other->toHex();
    }

    private function toHex() {
        return ($this->major << 16) | ($this->minor << 8) | ($this->maintenance);
    }
}

class PC_Compatibility {
    private $software, $previous;

    function __construct() {
        $this->software = new PC_Version(PRICE_CALC_VERSION);
        $this->previous = new PC_Version($this->getPrevious());
    }

    function toBeUpgraded() {
        $limit = new PC_Version('0.7.0');
        return $limit->newerThan($this->previous);
    }

    function getPrevious() {
        if(!($version = get_option('price-calc-version'))) {
            $version = '0.1.0';
        }
        return $version;
    }
}
