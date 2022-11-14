<?php 

namespace App\Models\backend;  

use App\Core\Mymodel;

class Videosmodel extends Mymodel {

    protected $_table_name = 'videos';
    protected $_order_by = 'parent_id, order, id';
    protected $_connlang = 'connlang_id'; //connecttion lang name
    
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

        //fetch lang name and image
        $this->languages = $this->LanguageModel->getFormDropdown('language', FALSE, FALSE);
        $this->languages_icon = $this->LanguageModel->getFormDropdown('image', FALSE, FALSE);

        //Rules for languages
        foreach($this->languages as $key=>$value)
        {
            $this->rulesLang["body_$key"] = array('field'=>"body_$key", 'label'=>'Body', 'rules'=>'trim');
        }
    }

    public function getNew()
    {
        $page = new \stdClass();
        $page->parent_id = 0;
        $page->link ='';
        $page->language_id = 0;
        $page->type = '';
        $page->reg = '';
        $page->name = '';

        //Add language parameters
        foreach($this->languages as $key=>$value)
        {
            $page->{"body_$key"} = '';
        }
        return $page;
    }



    //for type of videos that show on front
    public function getTemplates($template_prefix)
    {
        $templates = array(
            "home"=>"Home videos",
        );
        return $templates;
    }

}

