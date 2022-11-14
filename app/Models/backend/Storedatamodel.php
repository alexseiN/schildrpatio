<?php

namespace App\Models\backend;   
use App\Core\Mymodel;

class Storedatamodel extends Mymodel {  

    protected $_table_name = 'storedata';			//set table name 
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
        $page->first_name = '';
        $page->last_name = '';
        $page->email = '';
        $page->phone = '';
        $page->company = '';
        $page->areas = '';
        $page->comments = '';
        $page->q1 = 0;
        $page->q2 = 0;
        
        
       

        return $page;
    }


}

