<?php

namespace App\Controllers\Manage; 

use App\Core\Admincontroller;
use App\Models\backend\Activitiesmodel;

class Activities extends Admincontroller
{
    public $_table_names 	= 'activitylogs';		//set table
    public $_subView = 'admin/activitylogs/';			//set subview
    public $_mainView = 'admin/_layout_main';		//set mainview
    public $_redirect = '/activities';				//set controller link

    protected $PdcatsModel;

    public function __construct(){
        parent::__construct();
        //set left menu active on admin dashboard
        $this->data['active'] = 'Logs';

        $this->Activitiesmodel = new Activitiesmodel();
        $this->data['ThisModule'] = $this->Activitiesmodel;
        

        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';

        // for Global List
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Logs';
        $this->data['_table_names'] = $this->_table_names;
        $columns_with_filteroptions = array(
                    "Activity details" => array(),
                    "Date & Time" => array(),
                );
        $blank_array = array();

        $loggedinuseremp = $this->data['adminDetails']->employee_id;
        if ($this->data['adminDetails']->role == 'Branch Admin') {
			$where = array("employee"=>$loggedinuseremp);
		}
		else {
			$where = array();
		}
		
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$blank_array,$blank_array,'',0,'all',true);
        
        $main_array_view = array(
                    "view_data"=>array(
                        "view_folder"=>"activitylogs",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"no",
                        "default_sort"=>"created",
                        "default_sort_type"=>"DESC",
                        "add_link"=>array("status"=>"no","link"=>'')
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List
        $this->data['_lang_table_names'] = $this->data['_table_names'].'_lang';
    }

    public function index()
    {
        // set title
        $this->data['name'] = 'Activity logs';
        $this->data['title'] = $this->data['name'];
        echo view('admin/_layout_main',$this->data);
    }

}