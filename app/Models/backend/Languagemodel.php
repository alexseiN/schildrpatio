<?php 

namespace App\Models\backend;
use App\Core\Mymodel; 

class Languagemodel extends Mymodel {
    protected $_table_name = 'language';
    protected $_order_by = 'parent_id, order, id';

    public $rules_admin = array(
        'code' => array('field'=>'code', 'label'=>'lang:Code', 'rules'=>'trim|required'),
        'language' => array('field'=>'language', 'label'=>'lang:Language', 'rules'=>'trim|required'),
        'default' => array('field'=>'default', 'label'=>'lang:Default', 'rules'=>'trim'),
    );

    public function __construct()
    {
        parent::__construct(); 
    }

    public function getNew() {
        $language = new \stdClass();
        $language->code = '';
        $language->language = '';

        $language->default = 0;
        return $language;
    }
    
    

    public function get_default_code()  
    {
        
        $ip = $_SERVER['REMOTE_ADDR']; 
        $quest = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json")); 
     
        $coder = $quest->country;

        
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
    
    
    public function get_default_id() 
    {
        
        $db      = \Config\Database::connect();
        $builder = $db->table($this->_table_name);
        $builder->where('default', 1);
        $query = $builder->get();
        $result = $query->getResult();
        
        return $result[0]->id;
    } 
    
    
}
