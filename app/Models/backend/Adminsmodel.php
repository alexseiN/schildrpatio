<?php

namespace App\Models\backend;   
use App\Core\Mymodel;

class Adminsmodel extends Mymodel {  

    protected $_table_name = 'admin';			//set table name 
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
        $page->branch_id ='';
        $page->username = '';
        $page->password = '';
        $page->role = '';
       

        return $page;
    }


    public function getRoles()
    {
        $roles = array(
            '' 				            => 'Select',
            'Global Admin' 				=> 'Global Management',
            'Region Admin' 			    => 'Region Manager',
            'Region SubAdmin' 			=> 'Sub Region Manager',
            'Branch Group Admin' 	    => 'Branch Admin',
            'Branch Admin' 			    => 'Branch Employee'
           // 'Admin' 			        => 'Admin',
           // 'Invoice' 			        => 'Invoice',
            
            
            
            
        );

        return $roles;
    }

}

