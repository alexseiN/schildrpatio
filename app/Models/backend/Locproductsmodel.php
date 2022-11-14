<?php

namespace App\Models\backend;  

use App\Core\Mymodel;
use App\Models\CommanModel;

class Locproductsmodel extends Mymodel {
    protected $_table_name = 'locproducts';
    protected $_info_table = 'loccats';
    protected $_order_by = 'parent_id, order, id';
    protected $_connlang = 'connlang_id'; //table name
    protected $_connfile = 'connfile_id'; //table name
    public $rules = array(
        'parent_id' => array('field'=>'parent_id', 'label'=>'lang:Parent', 'rules'=>'trim|intval'),
        'language_id' => array('field'=>'language_id', 'label'=>'lang:Language', 'rules'=>'trim|intval'),
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
            $this->rulesLang["title_$key"] = array('field'=>"title_$key", 'label'=>'Title', 'rules'=>'trim');
            $this->rulesLang["slug_$key"] = array('field'=>"slug_$key", 'label'=>'Slug', 'rules'=>'trim');
            $this->rulesLang["body_$key"] = array('field'=>"body_$key", 'label'=>'Body', 'rules'=>'trim');
            $this->rulesLang["short_description_$key"] = array('field'=>"short_description_$key", 'label'=>'Meta Description', 'rules'=>'trim');
            $this->rulesLang["keywords_$key"] = array('field'=>"keywords_$key", 'label'=>'Keywords', 'rules'=>'trim');
        }
    }

    public function getNew()
    {
        $page = new \stdClass();
        $page->parent_id = 0;
        $page->category = '';
        $page->oprice = '';
        $page->nprice = '';
        $page->count = '';
        
        
        $page->date = date('Y-m-d H:i:s');

        //Add language parameters
        foreach($this->languages as $key=>$value)
        {
            $page->{"title_$key"} = '';
            $page->{"slug_$key"} = '';
            $page->{"navigation_title_$key"} = '';
            $page->{"body_$key"} = '';
            $page->{"keywords_$key"} = '';
            $page->{"short_description_$key"} = '';
        }

        return $page;
    }

 
}
