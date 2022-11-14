<?php  

namespace App\Controllers; 
use App\Core\Maincontroller;

 
class Page extends Maincontroller
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
	
	
	
	//becomedealer A
    function becomedealer1(){
        
        $data['first_name'] = $this->request->getPost('first_name'); 
        $data['last_name'] = $this->request->getPost('last_name');
        $data['company'] = $this->request->getPost('company');
        $data['email'] = $this->request->getPost('email');
        $data['phone'] = $this->request->getPost('phone');
        $data['zipcode'] = $this->request->getPost('zipcode');
        $data['city'] = $this->request->getPost('city');
        $data['areamiles'] = $this->request->getPost('areamiles');
        $data['website'] = $this->request->getPost('website');
     
        $data['view'] = 0;
 
        $data['dealer_id'] = $this->CommanModel->saveData('becomedealer',$data, $id = NULL);
        
        sendmail(18,$data['email'],$data);
            
        
    }
	
	//becomedealer B view
    function becomedealer2($id){
        
       // echo $id;die();
       
       $data = $this->data;
       
       $data['dealer_id'] = $id;
        

        echo view($this->_subView.'become_dealer_b',$data); 
            
        
    }
    
    //becomedealer B send
    function becomedealerid(){
        
       
       $data = $this->data;
      
        $data2['id'] = $this->request->getPost('dealer_id');
        $data2['facebook'] = $this->request->getPost('facebook');
        $data2['instagram'] = $this->request->getPost('instagram');
        $data2['linkedin'] = $this->request->getPost('linkedin');
        $data2['comprq'] = $this->request->getPost('comprq');
        $data2['resprq'] = $this->request->getPost('resprq');
        $data2['salem'] = $this->request->getPost('salem');
        $data2['instem'] = $this->request->getPost('instem');
        $data2['product'] = $this->request->getPost('product');
        $data2['prevbrand'] = $this->request->getPost('prevbrand');
        $data2['adbudget'] = $this->request->getPost('adbudget');
        $data2['comesfrom'] = $this->request->getPost('comesfrom');
        $data2['howfindus'] = $this->request->getPost('howfindus');
        
        
        $data2['yearsexperience'] = $this->request->getPost('yearsexperience');
        $data2['aremanufacturer'] = $this->request->getPost('aremanufacturer');
        
        
        
        $data2['q1'] = $this->request->getPost('q1');
        $data2['q2'] = $this->request->getPost('q2');
        
        $data2['areas'] = $this->request->getPost('areas');
        
        $data2['comments'] = $this->request->getPost('comments');
    
 
        $this->CommanModel->saveData('becomedealer',$data2, $data2['id']);
        
        echo view($this->_subView.'become_dealer_b',$data); 
            
        
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
        
        $data['view'] = 0;
        
        
        
        
        
       if ($data['zipcode']) {
           
           
           $check = $this->Detectmodel->ziptobranch($data['zipcode']);
            
        
            if ($check) { $data['branch_id'] = $check->id; } else {
            
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
       //echo $branch->email;
        
        $branch = get_langer('branches',FALSE,$data['branch_id']);
        //Save in database

        $this->CommanModel->saveData('fromcontact',$data, $id = NULL);
            
            
            
        sendmail(4,$this->request->getPost('email'),$data,$branch->email);
        sendmail(11,$branch->email,$data);
        
    }
    
    
    
     //Send Contact
    function sendmeeting(){
        
        $data['first_name'] = $this->request->getPost('first_name'); 
        $data['last_name'] = $this->request->getPost('last_name');
        $data['date'] = $this->request->getPost('date');
        $data['time'] = $this->request->getPost('time');
        
        $data['phone'] = $this->request->getPost('phone');
        $data['email'] = $this->request->getPost('email');
        
        $data['message'] = $this->request->getPost('message');
        $data['zipcode'] = $this->request->getPost('zipcode');
        
        $data['branch_id'] = $this->request->getPost('branch');
        
        $data['view'] = 0;
        
        
        
        
        
       if ($data['zipcode']) {
           
           
           $check = $this->Detectmodel->ziptobranch($data['zipcode']);
            
        
            if ($check) { $data['branch_id'] = $check->id; } else {
            
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
       //echo $branch->email;
        
        $branch = get_langer('branches',FALSE,$data['branch_id']);
        //Save in database

        $this->CommanModel->saveData('meeting',$data, $id = NULL);
            
            
            
        sendmail(21,$this->request->getPost('email'),$data,$branch->email);
        sendmail(22,$branch->email,$data);
        
    }
    
    
      public function thanks() {
        
        $data = $this->data;
        
        echo view($this->_subView.'thanks',$data); 
    }
    
     public function thankscontact() {
        
        $data = $this->data;
        
        echo view($this->_subView.'thankscontact',$data); 
    }
	
	
}
