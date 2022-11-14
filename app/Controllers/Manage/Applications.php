<?php

namespace App\Controllers\Manage;

use App\Core\Admincontroller;
use App\Models\backend\Applicationsmodel;

class Applications extends Admincontroller {
    public $_table_names 	= 'applications';		//set table
    public $_subView = 'admin/applications/';			//set subview
    public $_mainView = 'admin/_layout_main';		//set mainview
    public $_redirect = '/applications';				//set controller link

    protected $FeaturesModel;

    public function __construct(){
        parent::__construct();
        //set left menu active on admin dashboard
        $this->data['active'] = 'Product Management';

        $this->ApplicationsModel = new Applicationsmodel();
        $this->data['ThisModule'] = $this->ApplicationsModel;

        //set link with function name 
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';

        // for Global List
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Product Management';
        $this->data['_table_names'] = $this->_table_names;
        $columns_with_filteroptions = array(
                    "Name" => array(),
                    "Action" => array(),
                );
        $blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);
        $main_array_view = array(
                    "view_data"=>array(
                        "view_folder"=>"applications",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"no",
                        "default_sort"=>"order",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/applications/edit')
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List
        $this->data['_lang_table_names'] = $this->data['_table_names'].'_lang';
    }

    public function index()
    {
        //set title
        $this->data['name'] = 'Applications';
        $this->data['title'] = $this->data['name'];
        echo view('admin/_layout_main',$this->data);
    }


    public function edit($id = NULL){
        $blank_array = array();
        if($id){
            $this->data['name'] = 'Edit Color';
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
            $this->data['name'] = 'Create Color';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
            $this->data['thisItems']->image = '';
            $message = 'Data has successfully created';
        }
        $this->data['id'] = $id;
        $input = $this->validate($this->data['ThisModule']->getAllRules(), array('required', '%s Field required'));
        // Process the form
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;	         
            $input = $this->validate($this->data['ThisModule']->getAllRules(), array('required' => '%s Field required'));
            if($input) {
                $data =array();
                if($id){
                    $previousdata = $this->data['thisItems'][0];
                }
                if(is_null($id)) {
                    $data['order'] = $this->data['ThisModule']->maxOrder()+1;
                    $d_action = 'New Product application added.';
                }
                else {
                    $d_action = 'Product application updated.';
                }
                $data_lang = $this->data['ThisModule']->arrayFromPost($this->data['ThisModule']->getLangPostFields());
                if($id){
                    $data['modified'] = time();
                }
                //create or update data
                $id = $this->data['ThisModule']->saveWithLang($data, $data_lang, $id);

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
