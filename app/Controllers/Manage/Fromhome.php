<?php

namespace App\Controllers\Manage; 
use App\Core\Admincontroller;
use App\Models\backend\Fromhomemodel;

class Fromhome extends Admincontroller {
    public $_table_names = 'fromhome';			//set table name
    public $_subView = 'admin/fromhome/';		//set subview
    public $_redirect = '/fromhome';				//set controller link
    

    protected $CurrencyModel;

    public function __construct(){
        parent::__construct();

        $this->FromhomeModel = new Fromhomemodel();

        $this->data['ThisModule'] = $this->FromhomeModel;
        $this->data['CommanModel'] = $this->CommanModel;

        //set left menu active on admin dashboard
        $this->data['active'] = 'From Website';
        $this->data['withoutlang'] = 1;
        
        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';
	$this->data['branches'] = $this->CommanModel->get_lang('branches',false,false,array(),'connlang_id',FALSE);

	foreach($this->data['branches'] as $branch){
	    $branches[$branch->id] = $branch->name;
	}
	// for Global List
	$this->data['_table_names'] = $this->_table_names;
	$this->data['_subView'] = $this->_subView;
	$this->data['_parent_folder'] = 'CRM';
	$Statusoptions = array("1"=>"Viewed","0"=>"Waiting");

	$adminDetails = $this->data['adminDetails'];
	if($adminDetails->role == 'Branch Admin'){
	    $setarray = array();
	}
	else {
	    $setarray = array(
			"name"=>"branch_TYPEwhere",
			"type"=>"select",
			"options"=>$branches,
			"events"=>array(
			    "onchange"=>"getData('no')"
			)
		    );
	}
	
	$columns_with_filteroptions = array(
			"Position" => array(
				    "name"=>"from_TYPElike",
				    "type"=>"text",
				    "events"=>array(
					"onkeyup"=>"getData('no')"
				    )
				),
			"Zip Code" => array(
					"name"=>"zipcode_TYPElike",
					"type"=>"text",
					"events"=>array(
					    "onkeyup"=>"getData('no')"
					)					
				    ),
			"Branch" => $setarray,
			"Email" => array(
						"name"=>"email_TYPElike",
					"type"=>"text",
					"events"=>array(
					    "onkeyup"=>"getData('no')"
					)
					    ),					    
			"Received Time" => array(
						"name"=>"created_TYPEwheredaterange",
						"type"=>"datetimerange",
						"events"=>array(
						    "onkeyup"=>"getData('no')"
						)
					    ),
			"Action" => array(),
		    );
	$where = array();
        $blank_array = array();
        $adminDetails = $this->data['adminDetails'];
        if($adminDetails->role == 'Branch Admin'){
            $loggedinuseremp = $this->data['adminDetails']->employee_id;
	    $thisEmployee = get_langer('employees',false,$loggedinuseremp);
	    $thisbranch = get_langer('branches',$this->data['admin_lang'],$thisEmployee->branch_id);          
            $where = array("branch"=>$thisbranch->id);
        }
	$total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$blank_array,$blank_array,'',0,'all',true);

	$main_array_view = array(
			    "view_data"=>array(
				"view_folder"=>"fromhome",
				"columns_with_filteroptions"=>$columns_with_filteroptions,
				"total_count"=>$total_count,
				"is_filter"=>"yes",
				"default_sort"=>"created",
				"default_sort_type"=>"DESC",
				"add_link"=>array("status"=>"no","link"=>"")
			    )
			);
			
	$this->data['viewdata'] = $main_array_view;
	// end for Global List

    }

    
     
    
     public function index()
    {
        //set title
        $this->data['name'] = 'Subscribers';
        $this->data['title'] = $this->data['name']; 
        echo view('admin/_layout_main',$this->data);
    }
    
    
    function ajax_list(){
		
		
		
		
        $havingIn = array();
        
        $from = $this->request->getPost('from');
        $zipcode = $this->request->getPost('zipcode');
        $branch = $this->request->getPost('branch');
        $email = $this->request->getPost('email');
        
        
        
         
    
		
		if ($branch) {$where['branch']=$branch;} else {unset($where['branch']);}
	
		    
        $like = array(
            'from'=>$from,
            'zipcode'=>$zipcode,
            'email'=>$email
            
            );
   
        

			
			
			
			
		$this->items['objects'] = $this->CommanModel->getDatam('fromhome',$where,false,$like,'created');  

		
		
		//set load view
        $this->data['subview'] = 'setproject/index';
        $html = view('admin/fromhome/ajax_list', $this->items);
        
		return $html;
		
		
        
        
		
		
		
	}
    
    




    

  
}
