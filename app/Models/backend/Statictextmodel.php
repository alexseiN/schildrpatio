<?php

namespace App\Models\backend;

use App\Core\Mymodel;

class Statictextmodel extends Mymodel {
    protected $_table_name = 'static_text';			//set table
    protected $_connlang = 'connlang_id';           //table name
    protected $_order_by = 'order';					// set order

    public $rules = array(
        'name' => array('field'=>'name', 'label'=>'name', 'rules'=>'trim'),
    );

    public $rulesLang = array();

    protected $LanguageModel;

    protected $languages;
    protected $languages_icon;

    public function __construct(){
        parent::__construct();

        $this->LanguageModel = new Languagemodel();

        $this->languages = $this->LanguageModel->getFormDropdown('language', FALSE, FALSE);
        $this->languages_icon = $this->LanguageModel->getFormDropdown('image', FALSE, FALSE); 

        //Rules for languages
        foreach($this->languages as $key=>$value)
        {
            $this->rulesLang["title_$key"] = array('field'=>"title_$key", 'label'=>'lang:Title', 'rules'=>'trim|required');
        }
    }

    //set new
    public function getNew(){
        $news = new \stdClass();
        $news->name = '';

        //Add language parameters
        foreach($this->languages as $key=>$value)
        {
            $news->{"title_$key"} = '';
        }

        return $news;
    }

 


}


