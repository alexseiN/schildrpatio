<?php

namespace App\Models\backend;

use App\Core\Mymodel;

class Faqmodel extends Mymodel {

    protected $_table_name = 'faqs';
    protected $_connlang = 'connlang_id'; //connecttion lang name
    protected $_order_by = 'parent_id, order, id';
    public $rules = array(
        'parent_id' => array('field'=>'parent_id', 'label'=>'Parent', 'rules'=>'trim|intval'),
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
            $this->rulesLang["title_$key"] = array('field'=>"title_$key", 'label'=>'Title', 'rules'=>'trim|required');
            $this->rulesLang["body_$key"] = array('field'=>"body_$key", 'label'=>'body', 'rules'=>'trim|required');
        }
    }

    public function getNew()
    {
        $page = new \stdClass();
        $page->parent_id = 0;
        $page->name = '';
        $page->link = '';
        $page->desc ='';

        $page->language_id = 0;

        //Add language parameters
        foreach($this->languages as $key=>$value)
        {
            $page->{"title_$key"} = '';
            $page->{"body_$key"} = '';
        }

        return $page;
    }


}
