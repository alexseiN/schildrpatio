<?php

namespace App\Models\backend; 

use App\Core\Mymodel;

class Pmethodsmodel extends Mymodel {

    protected $_table_name = 'pmethods';			//set table name 
    protected $_order_by = 'parent_id, order, id'; //set order by

    public $rules = array(
        'parent_id' => array('field'=>'parent_id', 'label'=>'lang:Parent', 'rules'=>'trim|intval'),
    );

    public $rulesLang = array();

    protected $LanguageModel;
    public $languages;
    public $languages_icon;

    public function __construct(){
        parent::__construct();

        $this->LanguageModel = new Languagemodel();

        //fetch lang name and image
        $this->languages = $this->LanguageModel->getFormDropdown('language', FALSE, FALSE);
        $this->languages_icon = $this->LanguageModel->getFormDropdown('image', FALSE, FALSE);


    }

    //set a new one
    public function getNew()
    {
        $page = new \stdClass();
        $page->parent_id = 0;
        $page->name = '';
        $page->signature ='';
        $page->sandbox = '';
        $page->password = '';
        $page->username = '';
        $page->currency = '';
       

     
        return $page;
    }


}

