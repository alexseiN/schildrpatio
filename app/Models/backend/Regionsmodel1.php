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
       
        $form_data->code = '';
        
        //Add language parameters
        foreach($this->languages as $key=>$value){
            $form_data->{"title_$key"} = '';
            $form_data->{"message_$key"} = '';
        }
        return $form_data;
    }
    
    
    
    
   
    
    public function get_near_branch() {
        
    //    $ip = $_SERVER['REMOTE_ADDR']; 
        
        
     //    $detect = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));  
        

        
      //  $user_location = explode(',',$detect->loc);
        
      //   $lat=$user_location[0];
	  //   $long=$user_location[1];
        

      //  $coder = $detect->country;
        
    //    $coder = 'en';
        
     //   $db      = \Config\Database::connect();
     //   $builder = $db->table($this->_table_name);
     //   $query = $builder->get();
    //    $regions = $query->getResult();
        
    //    foreach ($regions as $region) {
            
     //       if ($region->code == strtolower($coder)) { $selected = $region->code;  }
            
     //   }

     //   if ($selected == '') {
            
        //    foreach ($regions as $region) {
                
      //      if ($region->default == 1) { $selected = $region->code; }
                
      //      }
            
     //   }






        $lat = 40;
        $long = 40;


        
        
        
    	
    	$db      = \Config\Database::connect();
        $builder = $db->table('branches');
        $query = $builder->get();
    //    $builder->where('region_id', $selected);
        $branches = $query->getResult();
        
        
		
		$branches2 =json_decode(json_encode($branches),true);;
		
	
	//	return $branches2;
		
		
		foreach ($branches2 as $key=>$branch)
    	{
    		$branch_location = explode(",", $branch['gps']);
    		$branch_region = $branch['gps'];
    		$a = $lat - $branch_location[0];
    		$b = $long - $branch_location[1];
    		$distance = sqrt(($a**2) + ($b**2));
    		$distances[$key] = $distance;
    	}
    	# Get The Closest Branch
    	asort($distances);
    	//$key = key($distances);
    	$closest = $branches2[key($distances)];
		return $closest; 
        
        
    }
    
    


}


