<?php

namespace App\Models\backend;   

use App\Core\Mymodel;

class Featuresmodel extends Mymodel {
    protected $_table_name = 'features'; //table name
    protected $_connlang = 'connlang_id'; //table name
    protected $_connfile = 'connfile_id'; //connecttion file name
    protected $_order_by = 'order, id';//set order field
    public $rules = array(
        'parent_id' => array('field'=>'parent_id', 'label'=>'Parent', 'rules'=>'trim|intval'),
        'template' => array('field'=>'template', 'label'=>'lang:Template', 'rules'=>'trim|required'),
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
            $this->rulesLang["title_$key"] = array('field'=>"title_$key", 'label'=>'lang:Title', 'rules'=>'trim|required');
            $this->rulesLang["description_$key"] = array('field'=>"description_$key", 'label'=>'lang:Description', 'rules'=>'trim');
        }
    }

    public function getNew()
    {
        $features = new \stdClass();
        $features->parent_id = 0;
        $features->language_id = 0;
        $features->template = '';

        //Add language parameters
        foreach($this->languages as $key=>$value)
        {
            $features->{"title_$key"} = '';
            $features->{"description_$key"} = '';
        }

        return $features;
    }
    
    
    
  
    
    
     public function getTemplates($template_prefix)
    {
        $templates = array(
            'simple' 			=> 'Simple',
            '3column' 			=> '3 Column',
            'accordion' 		=> 'Accordion',
            'color' 			=> 'Color list',
            'youtube' 			=> 'Youtube',
            'gallery' 			=> 'Image Gallery',
            'stgallery' 		=> 'Standart Gallery',
            'scroll' 		    => 'Scroll Gallery',
            'showroom' 			=> 'Showroom',
            'mixed' 			=> 'Mixed', 
            'videolist' 	    => 'Video List',
            'localvideos' 	    => 'Local Video List',
            'fullimage' 	    => 'Full image',
        
        );

        return $templates;
    }

}
