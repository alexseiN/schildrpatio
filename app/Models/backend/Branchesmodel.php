<?php

namespace App\Models\backend;

use App\Core\Mymodel;

class Branchesmodel extends Mymodel {
    protected $_table_name = 'branches'; //table name
    protected $_connlang = 'connlang_id'; //connecttion lang name
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
            
            $this->rulesLang["address_$key"] = array('field'=>"address_$key", 'label'=>'lang:Address', 'rules'=>'trim');
            $this->rulesLang["about_$key"] = array('field'=>"about_$key", 'label'=>'lang:About', 'rules'=>'trim');
        }
    }

    public function getNew(){
        $form_data = new \stdClass();
        $form_data->parent_id = 0;

        $form_data->language_id = 0;

        $form_data->name = '';

        $form_data->bname = '';

        $form_data->code = '';

        $form_data->reg = '';

        $form_data->city = '';

        $form_data->gps = '';

        $form_data->phones = '';

        $form_data->email = '';

        $form_data->metric = '';

        $form_data->currency = '';

        $form_data->ortype = ''; 

        $form_data->requisite = '';

        $form_data->diff = '';

        $form_data->m = 0;

        $form_data->rm = 0;

        $form_data->zipranges = '';        
        

        foreach($this->languages as $key=>$value){

            $form_data->{"address_$key"} = '';

            $form_data->{"about_$key"} = '';

        }

        return $form_data;
    }

}


