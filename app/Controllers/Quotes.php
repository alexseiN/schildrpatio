<?php  

namespace App\Controllers; 
use App\Core\Maincontroller; 

class Quotes extends Maincontroller
{
    public $_subView = 'main/quotes/';
	public function __construct(){
	    parent::__construct();
		helper('cookie');
		
	    
		
	}
	
	
	function index ($slug) {
	    
	    $data = $this->data;
	    
	    
	     $data['parent'] =  $this->CommanModel->get_lang('pdcats', $this->data['curlangid'] , NULL, array('slug'=>$slug,'enabled'=>1), 'connlang_id', true);
	//	 $data['products'] =  $this->CommanModel->get_lang('product', $this->data['curlangid'] , NULL, array('category'=>$data['parent']->id,'quote'=>1), 'connlang_id', false); 
	 
	     echo view($this->_subView.'index',$data);
	    
	}


    //get quote
    function getQuote(){
        
        $data['first_name'] = $this->request->getPost('first_name'); 
        $data['last_name'] = $this->request->getPost('last_name');
        $data['email'] = $this->request->getPost('email');
        $data['phone'] = $this->request->getPost('phone');
        $data['zipcode'] = $this->request->getPost('zipcode');
        $data['address'] = $this->request->getPost('address');
        $data['city'] = $this->request->getPost('city');
        
        $data['width'] = $this->request->getPost('width');
        $data['depth'] = $this->request->getPost('depth');
        $data['height'] = $this->request->getPost('height');
        
        $data['message'] = $this->request->getPost('message');
        
        $data['pid'] = $this->request->getPost('pid');
        
        $data['incat'] = $this->request->getPost('incat');
        
        $data['branch_id'] = $this->request->getPost('branch');
       
        $data['view'] = 0;
      
      
      
      
      
      
      
        
        if ($data['zipcode']) {
            
            $check = $this->Detectmodel->ziptobranch($data['zipcode']);
            
            
            
            if ($check) { $data['branch_id'] = $check->id;  } else {
            
            $element = $this->Detectmodel->get_compound_by_zip(str_replace(' ', '', $data['zipcode']))->results[0]->geometry->location;

            if($element) {
            
	            $nearbranch = $this->Detectmodel->nearmebranch($element->lat,$element->lng);
	        
	        
	        
    	        if ($nearbranch) {
    	            $data['branch_id'] = $nearbranch['closest']['id'];
    	            $branch = get_langer('branches',FALSE,$data['branch_id']);
    	            

    	        }
            }
            
            }
	       
        }
        
        
       
        $branch = get_langer('branches',FALSE,$data['branch_id']);
      
 
        $this->CommanModel->saveData('quotes',$data, $id = NULL);
        
        sendmail(13,$this->request->getPost('email'),$data,$branch->email);
        sendmail(12,$branch->email,$data);
            
           
        
    }
    
    
    public function thanks() {
        
        $data = $this->data;
        
        echo view($this->_subView.'thanks',$data); 
    }
	
	

	
	
	    
	}