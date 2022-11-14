<?php

namespace App\Models\backend;

use App\Core\Mymodel;

class Applicationsmodel extends Mymodel {
    protected $_table_name = 'applications'; //table name
    protected $_connlang = 'connlang_id'; //table name
    protected $_order_by = 'order, id';//set order field
    public $rules = array(
        //'parent_id' => array('field'=>'parent_id', 'label'=>'Parent', 'rules'=>'trim|intval'),
    );

    protected $LanguageModel;

    public $languages;
    public $languages_icon;
    public $rulesLang = array();

    public function __construct(){
        parent::__construct();
        $this->LanguageModel = new Languagemodel();
        $this->languages = $this->LanguageModel->getFormDropdown('language', FALSE, FALSE);
        $this->languages_icon = $this->LanguageModel->getFormDropdown('image', FALSE, FALSE);

        //Rules for languages
        foreach($this->languages as $key=>$value)
        {
            $this->rulesLang["title_$key"] = array('field'=>"title_$key", 'label'=>'lang:Title', 'rules'=>'trim');
        }
    }

    public function getNew()
    {
        $features = new \stdClass();
        $features->parent_id = 0;
        $features->language_id = 0;

        //Add language parameters
        foreach($this->languages as $key=>$value)
        {
            $features->{"title_$key"} = '';
        }

        return $features;
    }



}
