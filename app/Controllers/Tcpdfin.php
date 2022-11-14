<?php

namespace App\Controllers;
use App\Core\Maincontroller;


class Tcpdfin extends Maincontroller {
	function __construct() {
		parent::__construct();
	}
	function index($zip) {	
	    
	    
		$output = $this->Detectmodel->ziptobranch($zip);
		
		echo '<pre>';
	print_r($output);
		
	}
}
?>
