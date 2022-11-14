<?php

namespace App\Controllers\Manage;

use App\Core\Admincontroller;
use App\Models\backend\Quotesmodel;

class Quotes extends Admincontroller {
    public $_table_names = 'quotes';			//set table name
    public $_subView = 'admin/quotes/';		//set subview
    public $_redirect = '/quotes';				//set controller link
    

    protected $CurrencyModel;

    public function __construct(){
        parent::__construct();

        $this->QuotesModel = new Quotesmodel();

        $this->data['ThisModule'] = $this->QuotesModel;
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
        $this->data['pdcats'] = $this->CommanModel->get_lang('pdcats',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);

	
	foreach($this->data['branches'] as $branch){
	    $branches[$branch->id] = $branch->name;
	}
	
	foreach($this->data['pdcats'] as $pdcat){
	    $pdcats[] = array("id"=>$pdcat->id,"parent_id"=>$pdcat->parent_id,"title"=>$pdcat->title);
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
			"Product" => array(
						"name"=>"incat_TYPEwhere",
						"type"=>"selectwithoptiongroup",
						"options"=>$pdcats,
						"events"=>array(
						    "onchange"=>"getData('no')"
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
				"view_folder"=>"quotes",
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
	$this->data['_title_call'] = 'Quotes';
    }

   
    
    public function index()
    {
        //set title
        $this->data['name'] = 'Quotes';
        $this->data['title'] = $this->data['name']; 
        echo view('admin/_layout_main',$this->data);
    }
    
    
    
  

    
  
}
