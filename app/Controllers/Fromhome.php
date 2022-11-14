<?php  

namespace App\Controllers;
use App\Core\Maincontroller; 

class Fromhome extends Maincontroller
{
	public function __construct(){
	    parent::__construct();
		helper('cookie');
		
	    
		
	}
	
	



    //get quote
    function getEmail(){
        
        
        $data['email'] = $this->request->getPost('email');
        $data['zipcode'] = $this->request->getPost('zipcode');
        $data['branch'] = $this->request->getPost('branch');
        $data['from'] = $this->request->getPost('from');
       
        $data['created'] = time();
       
      
      
 
        $this->CommanModel->saveData('fromhome',$data, $id = NULL);
        
       // sendmail(13,$this->request->getPost('email'),$data);
       // sendmail(12,$branch->email,$data);
            
           
        
    }
    
    
    public function thanks() {
        
        $data = $this->data;
        
        echo view($this->_subView.'thanks',$data); 
    }
	
	

	
	
	    
	}