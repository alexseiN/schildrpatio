<?php

namespace App\Controllers\Manage;

use App\Core\Admincontroller;
use App\Models\backend\Storedatamodel;

class Storedata extends Admincontroller {
    public $_table_names = 'storedata';			//set table name
    public $_subView = 'admin/storedata/';		//set subview
    public $_redirect = '/storedata';				//set controller link
    

    protected $CurrencyModel;

    public function __construct(){
        parent::__construct();

        $this->StoredataModel = new Storedatamodel();

        $this->data['ThisModule'] = $this->StoredataModel;
        $this->data['CommanModel'] = $this->CommanModel;

        //set left menu active on admin dashboard
        $this->data['active'] = 'From Website';
        $this->data['withoutlang'] = 1;
        
        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';
	$this->data['_view'] = $this->data['admin_link'].$this->_redirect.'/view';


	// for Global List
	$this->data['_table_names'] = $this->_table_names;
	$this->data['_subView'] = $this->_subView;
	$this->data['_parent_folder'] = 'CRM';
	$Statusoptions = array("1"=>"Viewed","0"=>"Waiting");
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
			"Email" => array(
						"name"=>"email_TYPEwhere",
						"type"=>"text",
					"events"=>array(
					    "onkeyup"=>"getData('no')"
					)
					    ),
			"Phone" => array(
						"name"=>"phone_TYPEwhere",
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
	$blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);

	$main_array_view = array(
			    "view_data"=>array(
				"view_folder"=>"storedata",
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
	$this->data['_title_call'] = 'Storedata';
    }

   


    public function index()
    {
        //set title
        $this->data['name'] = 'Store Data';
        $this->data['title'] = $this->data['name']; 
        echo view('admin/_layout_main',$this->data);
    }
    
    function sendAutostore(){
        error_reporting(0);
        $email_data['link'] = $_REQUEST['invoicelink'];
        $email_data['email'] = $_REQUEST['email'];
        $email_data['first_name'] = $_REQUEST['first_name'];
        $email_data['last_name'] = $_REQUEST['last_name'];
       
        

        $sendemail = sendmail(24,$email_data['email'],$email_data); 

        
        $d_action = 'Email successfully sent!';		
                $logged_in = $this->data['adminDetails'];
                $employeeid = $logged_in->employee_id;
                $insertactivity['employee'] = $employeeid;
                $insertactivity['d_action'] = $d_action;
                $insertactivity['created']  = date("Y-m-d H:i:s");
                activitylogs($insertactivity,'insert');

                
        $sendmessage = '0';
        if($sendemail){
            $sendmessage = '1';
        }
        unlink($adata);
        return $sendmessage;
    }

  
}
