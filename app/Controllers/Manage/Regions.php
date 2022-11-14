<?php

namespace App\Controllers\Manage;
use App\Core\Admincontroller;
use App\Models\backend\Regionsmodel;

class Regions extends Admincontroller {
    public $_table_names = 'regions';
    public $_subView = 'admin/regions/';
    public $_mainView = 'admin/_layout_main';
    public $_redirect = '/regions';
    protected $RegionsModel;

    public function __construct(){
	parent::__construct();
	$this->RegionsModel = new Regionsmodel();
	$this->data['ThisModule'] = $this->RegionsModel;
	$this->data['active'] = 'General Settings';
	$this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
	$this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
	$this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';
	$this->data['_subView'] = $this->_subView;
	$this->data['_parent_folder'] = 'Base';
	$this->data['_table_names'] = $this->_table_names;
	$columns_with_filteroptions = array(
			"Region" => array(),
			"Domains" => array(),
			"Code" => array(),
			"Active Languages" => array(),
			"Action" => array(),
		    );
	$blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);
	$main_array_view = array(
			    "view_data"=>array(
				"view_folder"=>"regions",
				"columns_with_filteroptions"=>$columns_with_filteroptions,
				"total_count"=>$total_count,
				"is_filter"=>"no",
				"default_sort"=>"order",
				"default_sort_type"=>"ASC",
				"add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/regions/edit'),
                        "order_link"=>"yes"
			    )
			);
			
	$this->data['viewdata'] = $main_array_view;
	// end for Global List
	$this->data['_lang_table_names'] = $this->data['_table_names'].'_lang';
    }

    public function index(){
        $this->data['name'] = 'Regions';
        $this->data['title'] = $this->data['name'];
        echo view('admin/_layout_main',$this->data);
    }



    public function edit($id = NULL){
	error_reporting(0);
        if($id){
            $this->data['name'] = 'Edit Regions';
            $this->data['title'] = $this->data['name'];
	    $blank_array = array();
	    $where['id'] = $id;
            $this->data['thisItems'] = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$blank_array,$blank_array,'',0,'all',false);
	    if(count($this->data['thisItems'])<=0){
                return redirect()->to($this->data['_cancel']);
            }
        }
        else{
            $this->data['name'] = 'Create Regions';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
        }
	$this->data['id'] = $id;
        // Process the form
        if(!empty($this->postdata)) {            
            $postdata = $this->postdata;
            $input = $this->validate($this->data['ThisModule']->getAllRules(), array('required' => '%s Field required'));
            if($input) {		
                $data = $this->data['ThisModule']->arrayFromPost(array('code'));
		$data_lang = $this->data['ThisModule']->arrayFromPost($this->data['ThisModule']->getLangPostFields());		
		if(is_null($id)){
		    $data['order'] = $this->data['ThisModule']->maxOrder()+1;
		    $data['on_date'] = date('Y-m-d H:i:s');
                    $data['created'] = time();
                    $data['modified'] = time();
                    $data['currency'] = '';
                    $data['domains'] = array();
                    $data['selang'] = array();
		    $message = 'Data has successfully created';
		    $d_action = 'New Region added.';
		}
		else{
                    $data['modified'] = time();
		    $message = 'Data has successfully updated';
		    $d_action = 'Region updated.';
                }
		
		$data['selang'] = implode(',',$postdata['selang']);
		$data['domains'] = $postdata['domains'];                   
		//create or update data
                $id = $this->data['ThisModule']->saveWithLang($data, $data_lang, $id);

		$d_action .= ' <a href="'.$this->data['_cancel'].'/edit/'.$id.'" class="fs-6 text-gray-800 text-hover-primary fw-bold">View Region</a>';		
		$logged_in = $this->data['adminDetails'];
                $employeeid = $logged_in->employee_id;
                $insertactivity['employee'] = $employeeid;
                $insertactivity['d_action'] = $d_action;
                $insertactivity['created']  = date("Y-m-d H:i:s");
                activitylogs($insertactivity,'insert');
		
                $this->data['session']->setFlashdata('success',$message);	
		return redirect()->to($this->data['_cancel']);
            }
        }
        $this->data['subview'] = $this->_subView.'edit';
        echo view('admin/_layout_main', $this->data);
    }      
}