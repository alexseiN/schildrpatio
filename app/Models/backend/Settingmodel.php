<?php

namespace App\Models\backend;

use App\Core\Mymodel;

class Settingmodel extends Mymodel {
    protected $_table_name = 'l_settings'; //set name
    protected $_connlang = 'connlang_id'; //connecttion lang name
    protected $_order_by = 'parent_id, order, id';
    protected $LanguageModel;
    protected $languages;
    protected $languagesIcon;
    public    $rulesLang = array();

    public $rules = array(
        'parent_id' => array('field'=>'parent_id', 'label'=>'lang:Parent', 'rules'=>'trim|intval'),
    );

    public function __construct(){
        parent::__construct();
        $this->LanguageModel = new Languagemodel();
        $this->languages = $this->LanguageModel->getFormDropdown('language', FALSE, FALSE);
        $this->languages_icon = $this->LanguageModel->getFormDropdown('image', FALSE, FALSE);

        //Rules for languages
        foreach($this->languages as $key=>$value)
        {
            $this->rulesLang["title_$key"]          = array('field'=>"title_$key", 'label'=>'lang:Title', 'rules'=>'trim');
            $this->rulesLang["site_name_$key"]      = array('field'=>"title_$key", 'label'=>'lang:Title', 'rules'=>'trim');
            $this->rulesLang["author_$key"]         = array('field'=>"author_$key", 'label'=>'Author', 'rules'=>'trim');
            $this->rulesLang["meta_keyword_$key"]   = array('field'=>"meta_keyword_$key", 'label'=>'meta_keyword', 'rules'=>'trim');
            $this->rulesLang["meta_desc_$key"]      = array('field'=>"meta_desc_$key", 'label'=>'meta_desc_', 'rules'=>'trim');
            $this->rulesLang["owner_$key"]          = array('field'=>"owner_$key", 'label'=>'Owner', 'rules'=>'trim');
            $this->rulesLang["offline_data_$key"]   = array('field'=>"offline_data_$key", 'label'=>'offline_data', 'rules'=>'trim');
        }
    }


    
   
}


