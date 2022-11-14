<?php
 
namespace App\Controllers\Manage;   

use App\Core\Admincontroller;
use App\Models\backend\Employeesmodel; 

class Employees extends Admincontroller {
    public $_table_names = 'employees';			//set table name
    public $_subView = 'admin/employees/';		//set subview
    public $_redirect = '/employees';				//set controller link
    
    

    protected $EmployeesModel;

    public function __construct(){
        parent::__construct();

        $this->EmployeesModel = new Employeesmodel();

        $this->data['ThisModule'] = $this->EmployeesModel;
        $this->data['CommanModel'] = $this->CommanModel;
        
        $this->data['uploadFolder'] = 'assets/uploads/employees';

        //set left menu active on admin dashboard
        $this->data['active'] = 'Organisation';
        $this->data['withoutlang'] = 1;
        
        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';


        
        // for Global List
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Organisation';
        $this->data['_table_names'] = $this->_table_names;
        $columns_with_filteroptions = array(
                    "Name" => array(),
                    "Branch" => array(),
                    //"Email" => array(),
                    "Position" => array(),
                    "Action" => array(),
                );
        $blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);
        $main_array_view = array(
                    "view_data"=>array(
                        "view_folder"=>"employees",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"no",
                        "default_sort"=>"order",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/employees/edit')
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List
    }

    public function index()
    {
        //set title
        $this->data['name'] = 'Employees';
        $this->data['title'] = $this->data['name'];

        echo view('admin/_layout_main',$this->data);
    }


    public function edit($id = NULL) 
    {
        $blank_array = array();
        if($id){
            $this->data['name'] = 'Edit Employees';
            $this->data['title'] = $this->data['name'];
            $where['id'] = $id;
            $this->data['thisItems'] = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$blank_array,$blank_array,'',0,'all',false);
            if(count($this->data['thisItems'])<=0){
                return redirect()->to($this->data['_cancel']);
            }
            $message = 'Data has successfully updated';
        }
        else{
            error_reporting(1);
            $this->data['name'] = 'Create Employees';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
	    $this->data['thisItems']->image = '';
	    $message = 'Data has successfully created';
        }
	$this->data['id'] = $id;
     
        $this->data['all_branches'] = $this->CommanModel->getDatamwithlimit('branches',$blank_array,$blank_array,$blank_array,'',0,'all',false);
        $this->data['all_positions'] = $this->CommanModel->getDatamwithlimit('positions',$blank_array,$blank_array,$blank_array,'',0,'all',false);
        // Process the form
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;	         
            $input = $this->validate($this->data['ThisModule']->getAllRules());
            if($input) {
		if($id){
		    $previousdata = $this->data['thisItems'][0];
		}
                $data = $this->data['ThisModule']->arrayFromPost(array('first_name','last_name','gender','branch_id','mobile','rep','email','position'));
                if(is_null($id)) {
                    $data['order'] = $this->data['ThisModule']->maxOrder()+1;
		    $d_action = 'New Employee added.';
                }
                else {
                    $d_action = 'Employee updated.';
                }
		
                if ($_FILES['image']['error']<=0){
		    $result =$this->CommanModel->do_upload('image','./'.$this->data['uploadFolder']);
		    if($result['status']=='error'){
			$this->data['session']->setFlashdata('error',$result['message']);
			return redirect()->to($this->data['_cancel']);
		    }
		    else if($result['status']=='success'){
			$data['image'] = $result['product_image'];
		    }
		}
		else{
		    $checkname_remove = $postdata["image_remove"];
		    if($checkname_remove == 1){
			$data['image']  = null;
		    }
		    else {
			$data['image']  = ($id)?$previousdata->image:null;
		    }
		}
		$data['position'] = implode(",",$postdata['position']);
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
        //set load view
        $this->data['subview'] = $this->_subView.'edit';
        echo view('admin/_layout_main', $this->data);
    }

  
}
