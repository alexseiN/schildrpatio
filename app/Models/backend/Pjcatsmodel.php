<?php

namespace App\Models\backend; 

use App\Core\Mymodel;

class Pjcatsmodel extends Mymodel {
    protected $_table_name = 'pjcats'; //table name
    protected $_connlang = 'connlang_id'; //connecttion lang field
    protected $_connfile = 'connfile_id'; //connecttion file field
    protected $_order_by = 'parent_id, order, id';//set order field
    public $rules = array(
        'parent_id' => array('field'=>'parent_id', 'label'=>'Parent', 'rules'=>'trim'),
    );

    public $rulesLang = array();

    protected $LanguageModel;
    public $languages;
    public $languages_icon;

    public function __construct(){
        parent::__construct();

        $this->LanguageModel = new Languagemodel();
        $this->languages = $this->LanguageModel->getFormDropdown('language', FALSE, FALSE);
        $this->languages_icon = $this->LanguageModel->getFormDropdown('image', FALSE, FALSE);

        //Rules for languages
        foreach($this->languages as $key=>$value)
        {
            $this->rulesLang["title_$key"] = array('field'=>"title_$key", 'label'=>'lang:Title', 'rules'=>'trim');
            $this->rulesLang["slug_$key"] = array('field'=>"slug_$key", 'label'=>'lang:Slug', 'rules'=>'trim');
            $this->rulesLang["body_$key"] = array('field'=>"body_$key", 'label'=>'lang:Body', 'rules'=>'trim');
            $this->rulesLang["meta_desc_$key"] = array('field'=>"meta_desc_$key", 'label'=>'lang:Meta Description', 'rules'=>'trim');
            $this->rulesLang["meta_keyword_$key"] = array('field'=>"meta_keyword_$key", 'label'=>'lang:Meta Keyword', 'rules'=>'trim');
        }
    }

    public function getNew()
    {
        $categories = new \stdClass();
        $categories->parent_id = 0;
        $categories->language_id = 0;

        //Add language parameters
        foreach($this->languages as $key=>$value)
        {
            $categories->{"title_$key"} = '';
            $categories->{"slug_$key"} = '';
            $categories->{"body_$key"} = '';
            $categories->{"meta_desc_$key"} = '';
            $categories->{"meta_keyword_$key"} = '';
        }

        return $categories;
    }

 
   
}


