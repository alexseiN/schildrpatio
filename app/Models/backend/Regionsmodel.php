<?php

namespace App\Models\backend;

use App\Core\Mymodel; 

class Regionsmodel extends Mymodel {
    protected $_table_name = 'regions'; //table name
    protected $_connlang = 'connlang_id'; //table name
    protected $_order_by = 'parent_id, order, id';//set order field
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
            $this->rulesLang["title_$key"] = array('field'=>"title_$key", 'label'=>'lang:Title', 'rules'=>'trim');
            $this->rulesLang["message_$key"] = array('field'=>"message_$key", 'label'=>'lang:Message', 'rules'=>'trim');
        }
    }

    public function getNew(){
        $form_data = new \stdClass();
        $form_data->parent_id = 0;
        $form_data->language_id = 0;
        $form_data->currency = 0;
        
        //Add language parameters
        foreach($this->languages as $key=>$value){
            $form_data->{"title_$key"} = '';
            $form_data->{"message_$key"} = '';
        }
        return $form_data;
    }
    
    
    
    
    public function get_current_region()  
    {
        
        $ip = $_SERVER['REMOTE_ADDR']; 
        
        
   //     $quest = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json")); 
    //    $coder = $quest->country;

        $coder = 'us';
        
        
        $db      = \Config\Database::connect();
        $builder = $db->table($this->_table_name);
        $query = $builder->get();
        $result = $query->getResult();
        
        foreach ($result as $lan) {
            
            if ($lan->code == strtolower($coder)) { $selected = $lan->code;  }
            
        }

        if ($selected == '') {
            
            foreach ($result as $lan) {
                
            if ($lan->default == 1) { $selected = $lan->code; }
                
            }
            
        }



        return $selected;
    }


}


