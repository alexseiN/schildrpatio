<?php

namespace App\Controllers\Manage;  

use App\Core\Admincontroller;




class Allvisitors extends Admincontroller {
    public $_table_names 	= 'allvisitors';		//set table
    public $_subView = 'admin/allvisitors/';			//set subview
    public $_mainView = 'admin/_layout_main';		//set mainview
    public $_redirect = '/allvisitors';	 			//set controller link				//set controller link
    public function __construct(){
        parent::__construct();
        $this->data['active'] = 'General Settings';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
	$this->data['_table_names'] = $this->_table_names;
	$this->data['_subView'] = $this->_subView;
	$this->data['_parent_folder'] = 'Base';
	// for Global List
	$Statusoptions = array("0"=>"Normal","1"=>"Problem");
	$columns_with_filteroptions = array(
			"IP" => array(
				    "name"=>"ip_TYPElike",
				    "type"=>"text",
				    "events"=>array(
					"onkeyup"=>"getData('no')"
				    )
				),
			"Lat,Long" => array(
					"name"=>"latlong_TYPElike",
					"type"=>"text",
					"events"=>array(
					    "onkeyup"=>"getData('no')"
					)					
				    ),
			"Branch" => array(
					"name"=>"branch_TYPElike",
					"type"=>"text",
					"events"=>array(
					    "onkeyup"=>"getData('no')"
					)
				    ),
			"Google Detected" => array(),
			"Time" => array(),
			"Status" => array(
					"name"=>"status_TYPElike",
					"type"=>"select",
					"options"=>$Statusoptions,
					"events"=>array(
					    "onchange"=>"getData('no')"
					)
				    ),
		    );
	$blank_array = array();
	$total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);
	$main_array_view = array(
			    "view_data"=>array(
				"view_folder"=>"allvisitors",
				"columns_with_filteroptions"=>$columns_with_filteroptions,
				"total_count"=>$total_count,
				"is_filter"=>"yes",
				"default_sort"=>"time",
				"default_sort_type"=>"DESC",
				"add_link"=>array("status"=>"no","link"=>"")
			    )
			);
			
	$this->data['viewdata'] = $main_array_view;
	// end for Global List
    }

    public function index() {
        $this->data['name'] = 'All visitors';
        $this->data['title'] = $this->data['name'];        
	echo view('admin/_layout_main', $this->data);
    }

    public function modal() {
        echo view('admin/_layout_modal', $this->data);
    }
    
     
    
}
