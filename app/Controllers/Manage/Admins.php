<?php

namespace App\Controllers\Manage;  
use App\Core\Admincontroller;
use App\Models\backend\Adminsmodel; 

class Admins extends Admincontroller {
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
        echo view('admin/_layout_main',$this->data);
    }


    public function edit($id = NULL) 
    {
        error_reporting(0);
        $blank_array = array();
        if($id){
            $this->data['name'] = 'Edit Admin';
            $this->data['title'] = $this->data['name'];
            $where['id'] = $id;
            $this->data['thisItems'] = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$blank_array,$blank_array,'',0,'all',false);
            
            if(count($this->data['thisItems'])<=0){
                return redirect()->to($this->data['_cancel']);
            }
            $message = 'Data has successfully updated';
        }
        else{
            error_reporting(0);
            $this->data['name'] = 'Create Admin';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
            $this->data['thisItems']->image = '';
            $message = 'Data has successfully created';
        }
        $this->data['id'] = $id;     
        $this->data['all_branches'] = $this->CommanModel->get_lang('branches',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);
        $this->data['employees'] = $this->CommanModel->get_lang('employees',false,false,array(),'connlang_id',FALSE);        
        $this->data['all_roles'] = $this->data['ThisModule']->getRoles();
         
        //pp($this->data['sub_regions']);
        // Process the form
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;
            $input = $this->validate($this->data['ThisModule']->getAllRules());
            if($input) {

             
                $data = $this->data['ThisModule']->arrayFromPost(array('username', 'employee_id', 'role'));                
                $data['password'] = md5($this->data['ThisModule']->arrayFromPost(array('password'))['password']);

                if(is_null($id)) {
                    $where_check['employee_id'] = $data['employee_id'];
                    $checkadmin = $this->CommanModel->getDatamwithlimit('admin',$where_check,$blank_array,$blank_array,'',0,'all',false);
                    if(count($checkadmin)>0){
                        if($checkadmin[0]->role != $data['role']){
                            $this->data['session']->setFlashdata('error','You can not select this employee.');
                            return redirect()->back();
                        }
                    }
                }
                      
                if(is_null($id)) {
                    $data['order'] = $this->data['ThisModule']->maxOrder()+1;
                    $d_action = 'New Admin created.';
                }
                else {
                    $d_action = 'Admin details updated.';
                }  
                $id = $this->data['ThisModule']->saveData($data, $id);

                $d_action .= ' <a href="'.$this->data['_cancel'].'/edit/'.$id.'" class="fs-6 text-gray-800 text-hover-primary fw-bold">View</a>';		
                $logged_in = $this->data['adminDetails'];
                $employeeid = $logged_in->employee_id;
                $insertactivity['employee'] = $employeeid;
                $insertactivity['d_action'] = $d_action;
                $insertactivity['created']  = date("Y-m-d H:i:s");
                activitylogs($insertactivity,'insert');

                
                $this->data['session']->setFlashdata('success',$message);    
                return redirect()->to($this->data['_cancel']);
            }
            else {
                return redirect()->back()->withInput()->with('error', $this->data['validation']->listErrors());
            }
        }

        $this->data['subview'] = $this->_subView.'edit';
        echo view('admin/_layout_main', $this->data);
    }
}