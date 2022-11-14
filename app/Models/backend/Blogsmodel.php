<?php

namespace App\Models\backend; 

use App\Core\Mymodel;

class Blogsmodel extends Mymodel {
    protected $_table_name = 'blog';
    protected $_order_by = 'parent_id, order, id';
    protected $_connlang = 'connlang_id'; //connecttion lang name
    protected $_connfile = 'connfile_id'; //connecttion file name
    
    public $rules = array(
        'parent_id' => array('field'=>'parent_id', 'label'=>'lang:Parent', 'rules'=>'trim|intval'),
        'region_id' => array('field'=>'region_id', 'label'=>'Region', 'rules'=>'trim|intval'),
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
            $this->rulesLang["meta_desc_$key"] = array('field'=>"meta_desc_$key", 'label'=>'Meta Description', 'rules'=>'trim');
            $this->rulesLang["meta_keyword_$key"] = array('field'=>"keywords_$key", 'label'=>'Keywords', 'rules'=>'trim');
        }
    }

    public function getNew()
    {
        $page = new \stdClass();
        $page->parent_id = 0;
        $page->top = 0;
        $page->left_top = 0;
        $page->left_b = 0; 
        $page->footer_a = 0;
        $page->footer_b = 0;
        $page->template = 'page';
        $page->date = date('Y-m-d H:i:s');

        //Add language parameters
        foreach($this->languages as $key=>$value)
        {
            $page->{"title_$key"} = '';
            $page->{"slug_$key"} = '';
            $page->{"body_$key"} = '';
            $page->{"meta_keyword_$key"} = '';
            $page->{"meta_desc_$key"} = '';
        }

        return $page;
    }

  


    public function getTemplates($template_prefix)
    {
        $templates = array(
            'page' 				=> 'Page',
            'contact' 			=> 'Contact page',
            'become_dealer' 	=> 'Become a Dealer',
            'get_quote' 		=> 'Get Quote',
            'blog' 			    => 'Blog',
            
        );

        return $templates;
    }

 
}
