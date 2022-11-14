<?php

namespace App\Models\backend;
use App\Core\Mymodel;

class Activitiesmodel extends Mymodel {
    protected $_table_name = 'activitylogs'; //table name
    protected $_connlang = ''; //connecttion lang field 
    protected $_order_by = 'created';//set order field
    
    public $rules = array(
    
    );

    
    public function __construct(){
        parent::__construct();
	}
}


