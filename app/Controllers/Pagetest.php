<?php  

namespace App\Controllers;
use App\Core\Maincontroller;

 
class Pagetest extends Maincontroller
{
    public $_subView = 'main/page/';
	public function __construct(){
	    parent::__construct();
	    
	    
	    
		helper('cookie');
		
	
		
	}

	public function index($slug)
	{
	    $data = $this->data;
	    
	    
		
		$data['page'] =  $this->CommanModel->get_lang('page', $this->data['curlangid'] , NULL, array('slug'=>$slug,'enabled'=>1), 'connlang_id', true);
		
		$data['ogtitle'] = $data['page']->title;
		$data['ogdesc'] = $data['page']->meta_desc;
		$data['keywords'] = $data['page']->meta_keyword;
		$data['ogimage'] = 'assets/uploads/pages/thumbnails/'.$data['page']->image;
		
		$data['features'] =  $this->CommanModel->get_lang('sections', $this->data['curlangid'] , NULL, array('category_id'=>$data['page']->id,'enabled'=>1), 'connlang_id', false);
		
        echo view($this->_subView.$data['page']->template,$data);
	}
	
	//becomedealer
    function becomedealer(){
        
        $data['first_name'] = $this->request->getPost('first_name'); 
        $data['last_name'] = $this->request->getPost('last_name');
        $data['company'] = $this->request->getPost('company');
        $data['email'] = $this->request->getPost('email');
        $data['phone'] = $this->request->getPost('phone');
        $data['zipcode'] = $this->request->getPost('zipcode');
        
        $data['q1'] = $this->request->getPost('q1');
        $data['q2'] = $this->request->getPost('q2');
        
        $data['areas'] = $this->request->getPost('areas');
        
        $data['comments'] = $this->request->getPost('comments');
        
        
       
  
        
       //print_r($data);
 
        $this->CommanModel->saveData('becomedealer',$data, $id = NULL);
            
        
    }
	
	
    
    //Send Contact
    function sendcontact(){
        
        $data['first_name'] = $this->request->getPost('first_name'); 
        $data['last_name'] = $this->request->getPost('last_name');
        $data['street'] = $this->request->getPost('street');
        $data['zipcode'] = $this->request->getPost('zipcode');
        $data['city'] = $this->request->getPost('city');
        
        $data['phone'] = $this->request->getPost('phone');
        $data['email'] = $this->request->getPost('email');
        
        $data['message'] = $this->request->getPost('message');
        
        $data['callbacktime'] = $this->request->getPost('callbacktime');
        
        $data['branch_id'] = $this->request->getPost('branch');
        
        
        $branch = get_langer('branches',FALSE,$data['branch_id']);
        
        
        if ($data['zipcode']) {
            
            $element = $this->Detectmodel->get_compound_by_zip(str_replace(' ', '', $data['zipcode']))->results[0]->geometry->location;
            
            print_r($element);die();
            
            if($element) {
            
	        $nearbranch = $this->Detectmodel->nearmebranch($element->lat,$element->lng);
	        
	        
	        
    	        if ($nearbranch) {
    	            $data['branch_id'] = $nearbranch['id'];
    	            $branch = get_langer('branches',FALSE,$data['branch_id']);
    	            
    	            
    	            
    	        }
    	        
            }
	       
        }
      
       print_r($branch);die();
       //echo $branch->email;
        
        
        //Save in database
 
        //$this->CommanModel->saveData('fromcontact',$data, $id = NULL);
            
            
            
       // sendmail(4,$this->request->getPost('email'),$data);
       // sendmail(11,$branch->email,$data);
        
    }
    
    
    
    
    
    
      public function thanks() {
        
        $data = $this->data;
        
        echo view($this->_subView.'thanks',$data); 
    }
	
	
}
