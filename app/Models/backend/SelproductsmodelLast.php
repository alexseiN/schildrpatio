<?php

namespace App\Models\backend;  
use App\Core\Mymodel;

class Selproductsmodel extends Mymodel {  

    protected $_table_name = 'selproducts';			//set table name 
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
        $item = new \stdClass();
        $item->parent_id = 0;
        $item->sproduct = '';
        $item->dimensions ='';
        $item->qty ='';
        $item->scolor ='';
        $item->fcolor ='';
        $item->motorauto ='';
        $item->uprice = 0;
        $item->description ='';
        $item->additional ='';
       

        return $item;
    }


}

