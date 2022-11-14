<?php 

namespace App\Models\backend;   

use App\Core\Mymodel;

class Bannermodel extends Mymodel {

    protected $_table_name = 'banners';
    protected $_order_by = 'parent_id, order, id';
    protected $_connlang = 'connlang_id'; //connecttion lang name
    protected $_connfile = 'connfile_id'; //connecttion file name
    
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
            "top.breaking"=>"Top Breaking 1920X120 (px)",
            "home.popup"=>"Home Popup 1920X1080 (px)",
            "onslider.right"=>"On slider right",
            "home.asl"=>"Home After Slider Left",
            "home.asr"=>"Home After Slider Right",
            "home.inquire"=>"Home Inquire",
            "about"=>"About page",
        );
        return $templates;
    }

}

