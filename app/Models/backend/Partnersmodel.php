<?php

namespace App\Models\backend;  

use App\Core\Mymodel;

class Partnersmodel extends Mymodel {

    protected $_table_name = 'partners';			//set table name
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
        $page->type = '';
        $page->name = '';

        //Add language parameters
        foreach($this->languages as $key=>$value)
        {
            $page->{"body_$key"} = '';
        }
        return $page;
    }

 

    //for type of banner that show on front
    public function getTemplates($template_prefix)
    {
        $templates = array(
            "home.top"=>"Home Top 1920X120 (px)",
            "page.left"=>"Page Left 160X800 (px)",
            "page.right"=>"Page Left 160X800 (px)",
        );
        return $templates;
    }

}

