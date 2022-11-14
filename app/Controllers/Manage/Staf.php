<?php

namespace App\Controllers\Manage;  
use App\Core\Admincontroller;
use App\Models\backend\Employeesmodel; 

class Staf extends Admincontroller {
    public $_table_names = 'employees';			//set table name
    public $_subView = 'admin/staf/';		//set subview
    public $_redirect = '/staf';				//set controller link
    

    protected $EmployeesModel;

    public function __construct(){
        parent::__construct();

        $this->EmployeesModel = new Employeesmodel();

        $this->data['ThisModule'] = $this->EmployeesModel;
        $this->data['CommanModel'] = $this->CommanModel;

        //set left menu active on admin dashboard
        $this->data['active'] = 'Important';
        $this->data['withoutlang'] = 1;
        
        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';
        
        

        $this->data['branches'] = $this->CommanModel->get_lang('branches',false,false,array(),'connlang_id',FALSE);

        $this->data['positions'] = $this->CommanModel->get_by('positions',array(),false,false,false);

        foreach($this->data['branches'] as $branch){
            $branches[$branch->id] = $branch->name;
        }
        // for Global List
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Intranet';
        $this->data['_table_names'] = $this->_table_names;

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
                    "Name" => array(
                                    "name"=>"first_name_CONCAT_last_name_TYPEconcat",
                                    "type"=>"text",
                                    "events"=>array(
                                        "onkeyup"=>"getData('no')"
                                    )
                                ),
                    "Company" => $setarray,
                    "Position" => array(),
                    "Phone" => array(),
                    "Email" => array(),
                );
        $blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);
        $main_array_view = array(
                    "view_data"=>array(
                        "view_folder"=>"staf",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"yes",
                        "default_sort"=>"order",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"no","link"=>""),
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List

    }

    public function index()
    {
        //set title
        $this->data['name'] = 'Company Employees';
        $this->data['title'] = $this->data['name'];
        echo view('admin/_layout_main',$this->data);
    }


    public function edit($id = NULL) 
    {
        // Fetch a data or set a new one
        if($id)
        {
            //set title
            $this->data['name'] = 'Edit';
            $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];

            $this->data['thisItems'] = $this->data['ThisModule']->get($id, FALSE);
            $this->data['errors'][] = 'User could not be found';
        }
        else
        {
            //set title
            $this->data['name'] = 'Create new';
            $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];

            // set a new one
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
        }

     
        $this->data['all_branches'] = $this->CommanModel->get_lang('branches',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);

        // Set up the form
        $input = $this->validate($this->data['ThisModule']->getAllRules());

        $this->data['validation'] = \Config\Services::validation();

        // Process the form
        if($_POST){
            if($input) {
                // get post data from form
                $data = $this->data['ThisModule']->arrayFromPost(array('first_name','last_name','gender','branch_id','mobile','login','email','position'));
                if($id == NULL)$data['order'] = $this->data['ThisModule']->maxOrder()+1;
      



                //create or update data
                $id = $this->data['ThisModule']->saveData($data, $id);
                if(empty($this->data['thisItems']->id))
                    $this->data['session']->setFlashdata('success','Data has successfully created');
                else
                    $this->data['session']->setFlashdata('success','Data has successfully updated');
                return redirect()->to(base_url().'/'.$this->data['_cancel']);
            }
        }

        $request = \Config\Services::request();
        $this->data['request'] = $request;

        //set load view
        $this->data['subview'] = $this->_subView.'edit';
        echo view('admin/_layout_main', $this->data);
    }
    
    
    function ajax_list(){
		
		
		$where= array();
		
        $company = $this->request->getPost('company');
        
        $fullname = $this->request->getPost('fullname');
        
        $ns =explode(' ',$fullname);
     //   $position = $this->request->getPost('position');
        
        
       
        
        
        
        if ($company) {$where['branch_id']=$company;} else {unset($where['branch_id']);}
       // if ($position) {$where['position']=$position;} else {unset($where['position']);}
        
        
        
        
        
		
		
		
		//if ($fullname) { $builder->like('first_name', $ns[0]); }
		//if ($fullname) { $builder->like('last_name', $ns[1]); }
	
			
		$this->items['objects'] = $this->CommanModel->getSearch('employees',$where, $ns[0]); 

		
		
		//set load view
        $this->data['subview'] = $this->_subView.'index';
        
        
        $html = view('admin/staf/ajax_list', $this->items);
        
		return $html;
		
		
		
	}

  
}
