<?php

namespace App\Models\backend;  
use App\Core\Mymodel;

class Chathistorymodel extends Mymodel {  

    protected $_table_name = 'supportvisitors';			//set table name  
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
        $page->zipcode = '';
        $page->street = '';
        $page->city = '';
        $page->message = '';
        $page->callbacktime = '';
        $page->view = '';
        
        
       

        return $page;
    }


}

