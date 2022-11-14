<?php 

namespace App\Models\backend; 

use App\Core\Mymodel;

class Mixedmodel extends Mymodel {
    protected $_table_name = 'features';
    protected $_order_by = 'parent_id, order, id';
    protected $_connlang = 'connlang_id'; //connecttion lang name
    protected $_connfile = 'connfile_id'; //connecttion file name
    
    public $rules = array(
        'parent_id' => array('field'=>'parent_id', 'label'=>'lang:Parent', 'rules'=>'trim|intval'),
        
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
        }
    }

    public function getNew()
    {
        $page = new \stdClass();
        $page->parent_id = 0;

        $page->template = 'mixed';


        //Add language parameters
        foreach($this->languages as $key=>$value)
        {
            $page->{"title_$key"} = '';
   
        }

        return $page;
    }

  


    public function getTemplates($template_prefix)
    {
        $templates = array(
            'page' 				=> 'Page',
            'faq' 				=> 'Faq',
            'about' 			=> 'About Us',
            'contact' 			=> 'Contact page',
            'contact_new' 			=> 'Test Contact page',
            'become_dealer' 	=> 'Become a Dealer',
            'get_quote' 		=> 'Get Quote',
            'blog' 			    => 'Blog',
            
        );

        return $templates;
    }

 
}
