<?php

namespace App\Models\backend;    
use App\Core\Mymodel;

class Quotesmodel extends Mymodel {  

    protected $_table_name = 'quotes';			//set table name 
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
        $page->width = '';
        $page->debth = '';
        $page->message = '';
        $page->pid = '';
        $page->view = '';


        return $page;
    }


}

