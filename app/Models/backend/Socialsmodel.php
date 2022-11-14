<?php

namespace App\Models\backend;  

use App\Core\Mymodel;

class Socialsmodel extends Mymodel {

    protected $_table_name = 'socials';
    protected $_order_by = 'parent_id, order, id';
    
    public $rules = array(
        'parent_id' => array('field'=>'parent_id', 'label'=>'Parent', 'rules'=>'trim|intval'),
    );

   public $rulesLang = array();

    public function __construct(){
        parent::__construct();

        
    }

    public function getNew()
    {
        $page = new \stdClass();
        $page->parent_id = 0;
        $page->link ='';
        $page->class ='';
        $page->name = '';

    
        return $page;
    }



}

