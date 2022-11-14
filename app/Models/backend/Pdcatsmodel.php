<?php

namespace App\Models\backend;

use App\Core\Mymodel;

class Pdcatsmodel extends Mymodel {
    protected $_table_name = 'pdcats'; //table name
    protected $_connlang = 'connlang_id'; //connecttion lang field 
    protected $_connfile = 'connfile_id'; //connecttion file field
    protected $_order_by = 'parent_id, order, id';//set order field
    public $rules = array(
        //'parent_id' => array('field'=>'parent_id', 'label'=>'Parent', 'rules'=>'trim|required'),
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
            $this->rulesLang["secondary_$key"] = array('field'=>"secondary_$key", 'label'=>'lang:Secondary', 'rules'=>'trim');
            $this->rulesLang["tags_$key"] = array('field'=>"tags_$key", 'label'=>'Tags', 'rules'=>'trim');
            $this->rulesLang["about_$key"] = array('field'=>"about_$key", 'label'=>'About', 'rules'=>'trim');
            $this->rulesLang["more_$key"] = array('field'=>"more_$key", 'label'=>'more', 'rules'=>'trim');
            $this->rulesLang["meta_keyword_$key"] = array('field'=>"meta_keyword_$key", 'label'=>'Meta keyword', 'rules'=>'trim');
           
        }
    }

    public function getNew()
    {
        $categories = new \stdClass();
        $categories->parent_id = 0;
        $categories->language_id = 0;
        $categories->video = '';
        $categories->bcolor = '';

        //Add language parameters
        foreach($this->languages as $key=>$value)
        {
            $categories->{"title_$key"} = '';
            $categories->{"secondary_$key"} = '';
            $categories->{"slug_$key"} = '';
            $categories->{"tags_$key"} = '';
            $categories->{"about_$key"} = '';
            $categories->{"more_$key"} = '';
            $categories->{"meta_keyword_$key"} = '';
     
        }

        return $categories;
    }

 
  
   
}


