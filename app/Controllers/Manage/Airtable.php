<?php

namespace App\Controllers\Manage; 
use App\Core\Admincontroller;
use App\Models\backend\Adminsmodel; 

class Airtable extends Admincontroller {
    public $_table_names = 'admin';			//set table name
    public $_subView = 'admin/admins/';		//set subview
    public $_redirect = '/admins';				//set controller link
    

    protected $AdminsModel;

    public function __construct(){
        parent::__construct();

        $this->AdminsModel = new Adminsmodel();

        $this->data['ThisModule'] = $this->AdminsModel;
        $this->data['CommanModel'] = $this->CommanModel;

        //set left menu active on admin dashboard
        $this->data['active'] = 'User Management';
        $this->data['withoutlang'] = 1;
        
        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';

        // for Global List
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Account Management';
        $this->data['_table_names'] = $this->_table_names;
        $columns_with_filteroptions = array(
                    "Name" => array(),
                    "Action" => array(),
                );
        $blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);
        $main_array_view = array(
                    "view_data"=>array(
                        "view_folder"=>"admins",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"no",
                        "default_sort"=>"order",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/admins/edit'),
                         "order_link"=>"yes"
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List
    }

    public function index()
    {
        //set title
        $this->data['name'] = 'Admins';
        $this->data['title'] = $this->data['name'];
      
        
        return redirect()->to('https://airtable.com/shrSYqozuECjkMZn1',null,'refresh');
    }


}