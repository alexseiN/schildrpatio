<?php

namespace App\Models\backend; 
use App\Core\Mymodel; 

class Employeesmodel extends Mymodel {  

    protected $_table_name = 'employees';			//set table name 
    protected $_order_by = 'parent_id, order, id'; //set order by

    public $rules = array(
        'parent_id' => array('field'=>'parent_id', 'label'=>'lang:Parent', 'rules'=>'trim|intval'),
    );

    public $rulesLang = array();



    public function __construct(){
        parent::__construct();


    }

    //set a new one
    public function getNew()
    {
        $page = new \stdClass();
        $page->parent_id = 0;
        $page->gender = '';
        $page->branch_id ='';
        $page->first_name = '';
        $page->last_name = '';
        $page->email = '';
        $page->login = '';
        $page->mobile = '';
        $page->position = '';
       

        return $page;
    }


}

