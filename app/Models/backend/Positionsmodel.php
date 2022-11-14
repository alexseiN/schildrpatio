<?php

namespace App\Models\backend; 
use App\Core\Mymodel;

class Positionsmodel extends Mymodel {  

    protected $_table_name = 'positions';			//set table name 
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
        $page->type ='';
        $page->ex = '';
        $page->title = '';
        $page->about = '';

       

        return $page;
    }


}

