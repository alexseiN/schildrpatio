<?php

namespace App\Controllers\Manage;

use App\Core\Admincontroller;

class Language extends Admincontroller {
    
    public $_table_names = 'language';
    public $_subView = 'admin/language/';
    public $_redirect = '/language';
    protected $CurrencyModel;

    function __construct(){
	parent::__construct();
	$this->data['ThisModule'] = $this->LanguageModel;
	$this->data['CommanModel'] = $this->CommanModel;
	$this->data['uploadFolder'] = 'assets/uploads/language';
	$this->data['active'] = 'General Settings';
	$this->data['withoutlang'] = 1;
	$this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
	$this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
	$this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';
        
	

	// for Global List
	$this->data['_subView'] = $this->_subView;
	$this->data['_parent_folder'] = 'Base';
	$this->data['_table_names'] = $this->_table_names;
	$columns_with_filteroptions = array(
			"Image" => array(),
			"Language" => array(
				    "name"=>"language_TYPElike",
				    "type"=>"text",
				    "events"=>array(
					"onkeyup"=>"getData('no')"
				    )
				),
			"Code" => array(
					"name"=>"code_TYPElike",
					"type"=>"text",
					"events"=>array(
					    "onkeyup"=>"getData('no')"
					)					
				    ),
			"Action" => array(),
		    );
	$blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);
	$main_array_view = array(
			    "view_data"=>array(
				"view_folder"=>"language",
				"columns_with_filteroptions"=>$columns_with_filteroptions,
				"total_count"=>$total_count,
				"is_filter"=>"no",
				"default_sort"=>"order",
				"default_sort_type"=>"ASC",
				"add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/language/edit'),
                        "order_link"=>"yes"
			    )
			);
			
	$this->data['viewdata'] = $main_array_view;
	// end for Global List
	
    }
    
    function index() {
	$this->data['name'] = 'Languages';
	$this->data['title'] = $this->data['name'];
	echo view('admin/_layout_main',$this->data);
    }

    function edit($id= NULL){
	if($id) {
	    $this->data['name'] = 'Edit Languages';
	    $this->data['title'] = $this->data['name'];
	    $blank_array = array();
	    $where['id'] = $id;
            $this->data['thisItems'] = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$blank_array,$blank_array,'',0,'all',false);
	    if(count($this->data['thisItems'])<=0){
                return redirect()->to($this->data['_cancel']);
            }
        }
	else {
	    $this->data['name'] = 'Create Languages';
	    $this->data['title'] = $this->data['name'];
	    $this->data['thisItems'] = $this->data['ThisModule']->getNew();
	    $this->data['thisItems']->image = '';
	    $this->data['thisItems']->enabled = '';
	}
	$this->data['id'] = $id;
	
	if(!empty($this->postdata)) {            
            $postdata = $this->postdata;
            $rules = $this->data['ThisModule']->rules_admin;
	    $input = $this->validate($rules);
	    
            if($input) {
		if($id) {
		    $previousdata = $this->data['thisItems'][0];
		}
		$data = $this->data['ThisModule']->arrayFromPost(array('default','enabled','code','language',));
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
		$ids = $this->data['ThisModule']->saveData($data, $id);

		if($id){
		    $d_action = 'Language updated.';
		}
		else {
		    $d_action = 'New Language added.';
		}
		
		$d_action .= ' <a href="'.$this->data['_cancel'].'/edit/'.$id.'" class="fs-6 text-gray-800 text-hover-primary fw-bold">View language</a>';		
		$logged_in = $this->data['adminDetails'];
                $employeeid = $logged_in->employee_id;
                $insertactivity['employee'] = $employeeid;
                $insertactivity['d_action'] = $d_action;
                $insertactivity['created']  = date("Y-m-d H:i:s");
                activitylogs($insertactivity,'insert');

		
		if(!$id){
		    $statics = $this->CommanModel->get('static_text',false);
		    if($statics){
			foreach($statics as $set_static){			    
			    $builder = $this->db->table('static_text_lang');
			    $builder->set(array('title'=>$set_static->name,'connlang_id'=>$set_static->id,'language_id'=>$ids));
			    $builder->insert();
			}
		    }
		}
		return redirect()->to($this->data['_cancel']);
	    }
	    else {
		return redirect()->back()->withInput()->with('error', $this->data['validation']->listErrors());
	    }
	}
	$this->data['subview'] = $this->_subView.'/edit';
	echo view('admin/_layout_main', $this->data);
    }
    function do_default(){
	$output = array();
	$output['status']= 'error';
	$output['message']= 'there is no data';
	$id = $this->request->getVar('id');
	if($id){
	    $check_user = $this->CommanModel->get_by($this->_table_names,array('id'=>$id),false,false,true);
	    if($check_user){
		$output['status']= 'ok';
		$output['message']= '';

		$builder = $this->db->table('language');
		$builder->set('default',0);
		$builder->update();
				
		//$db = \Config\Database::connect();
		$builder = $this->db->table('language');
		$builder->where('id', $check_user->id);
		if($check_user->default==1){
			$builder->set('default',0);
		}
		else{
			$builder->set('default',1);
		}
		$builder->update();
	    }
	}
	echo json_encode($output);
    }
}