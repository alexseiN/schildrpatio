<?php

namespace App\Models\backend; 

use App\Core\Mymodel;

class Reviewsmodel extends Mymodel {

    protected $_table_name = 'reviews';			//set table name
    protected $_connlang = 'connlang_id'; //connecttion lang name
    protected $_order_by = 'parent_id, order, id'; //set order by

    public $rules = array(
        'parent_id' => array('field'=>'parent_id', 'label'=>'lang:Parent', 'rules'=>'trim|intval'),
        'language_id' => array('field'=>'language_id', 'label'=>'lang:Language', 'rules'=>'trim|intval'),
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

        //Rules for languages
        foreach($this->languages as $key=>$value)
        {
            $this->rulesLang["body_$key"] = array('field'=>"body_$key", 'label'=>'Body', 'rules'=>'trim');
        }
    }

    //set a new one
    public function getNew()
    {
        $page = new \stdClass();
        $page->parent_id = 0;
        $page->link ='';
        $page->language_id = 0;
        $page->name = '';

        //Add language parameters
        foreach($this->languages as $key=>$value)
        {
            $page->{"body_$key"} = '';
        }
        return $page;
    }




}

