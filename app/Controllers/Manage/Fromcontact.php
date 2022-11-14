<?php 

namespace App\Controllers\Manage;

use App\Core\Admincontroller;
use App\Models\backend\Fromcontactmodel;

class Fromcontact extends Admincontroller {
    public $_table_names = 'fromcontact';			//set table name
    public $_subView = 'admin/fromcontact/';		//set subview
    public $_redirect = '/fromcontact';				//set controller link
    

    protected $CurrencyModel;

    public function __construct(){
        parent::__construct();

        $this->FromcontactModel = new Fromcontactmodel();

        $this->data['ThisModule'] = $this->FromcontactModel;
        $this->data['CommanModel'] = $this->CommanModel;

        //set left menu active on admin dashboard
        $this->data['active'] = 'From Website';
        $this->data['withoutlang'] = 1;
        
        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';
	$this->data['_view'] = $this->data['admin_link'].$this->_redirect.'/view';

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
			"name"=>"branch_id_TYPEwhere",
			"type"=>"select",
			"options"=>$branches,
			"events"=>array(
			    "onchange"=>"getData('no')"
			)
		    );
	}

	
	$columns_with_filteroptions = array(
			"Client" => array(
				    "name"=>"first_name_CONCAT_last_name_TYPEconcat",
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
			"Phone" => array(
						"name"=>"phone_TYPElike",
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
			"Action" => array(
					"name"=>"view_TYPEwhere",
					"type"=>"select",
					"options"=>$Statusoptions,
					"events"=>array(
					    "onchange"=>"getData('no')"
					)
				    ),
		    );
	

	$where = array();
        $blank_array = array();
        $adminDetails = $this->data['adminDetails'];
        if($adminDetails->role == 'Branch Admin'){
            $loggedinuseremp = $this->data['adminDetails']->employee_id;
	    $thisEmployee = get_langer('employees',false,$loggedinuseremp);
	    $thisbranch = get_langer('branches',$this->data['admin_lang'],$thisEmployee->branch_id);          
            $where = array("branch_id"=>$thisbranch->id);
        }
	$total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$blank_array,$blank_array,'',0,'all',true);

	$main_array_view = array(
			    "view_data"=>array(
				"view_folder"=>"fromcontact",
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
	$this->data['_title_call'] = 'Contact us';
    }

    
     public function index()
    {
        //set title
        $this->data['name'] = 'Contact us';
        $this->data['title'] = $this->data['name']; 
        echo view('admin/_layout_main',$this->data);
    }
   

  
}
