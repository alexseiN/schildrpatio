<?php

namespace App\Controllers\Manage;

use App\Core\Admincontroller;
use App\Models\backend\Statictextmodel;

class Statictext extends Admincontroller {
    public $_table_names = 'static_text';		//set table
    public $_subView = 'admin/static_text/';	//set subview
    public $_redirect = '/statictext';			//set controller link

    protected $StaticTextModel;

    public function __construct(){
        parent::__construct();
        $this->data['active']= 'General Settings';
        $this->StaticTextModel = new Statictextmodel();
        $this->data['ThisModule'] = $this->StaticTextModel;

        //set function link
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';

        // for Global List
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Base';
        $this->data['_table_names'] = $this->_table_names;
        $columns_with_filteroptions = array(
                    "Name" => array(),
                    "Action" => array(),
                );
        $blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);
        $main_array_view = array(
                    "view_data"=>array(
                        "view_folder"=>"product",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"no",
                        "default_sort"=>"created",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/statictext/edit'),
                        "is_main_filter" => array(
                                            "name"=>"name_TYPElike",
                                            "type"=>"text",
                                            "events"=>array(
                                                "onkeyup"=>"getData('no')"
                                            )
                                        ),
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        $this->data['postarrayelements'] = array('name');

        $this->data['_lang_table_names'] = $this->data['_table_names'].'_lang';
    }

    public function index(){        $this->data['name'] = 'Static areas';
        $this->data['title'] = $this->data['name'];        echo view('admin/_layout_main',$this->data);
    }
    public function edit($id = NULL) 
    {
        if($id)
        {
            $this->data['name'] = 'Edit Static areas';
            $this->data['title'] = $this->data['name'];
            $blank_array = array();
            $where['id'] = $id;
            $this->data['thisItems'] = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$blank_array,$blank_array,'',0,'all',false);
            if(count($this->data['thisItems'])<=0){
                return redirect()->to($this->data['_cancel']);
            }
            $message = 'Data has successfully updated';
        }
        else
        {
            $this->data['name'] = 'Create Static areas';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
            $message = 'Data has successfully created';
        }
        $this->data['id'] = $id;
        // Process the form
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;	         
            $input = $this->validate($this->data['ThisModule']->getAllRules(), array('required' => '%s Field required'));
            if($input) {
                $data['name'] = $postdata['name'];
                if($id){
                    $previousdata = $this->data['thisItems'][0];
                }
                if(is_null($id)) {                    
                    $data['created'] = time();
                    $data['modified'] = time();
                    $d_action = 'New Static areas added.';
                }
                $data_lang = $this->data['ThisModule']->arrayFromPost($this->data['ThisModule']->getLangPostFields());
                if($id){
                    $data['modified'] = time();
                    $d_action = 'Static areas updated.';
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
    function ajaxEdit(){//update data
        $msg = 'error';
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $data = $request->getPost('data');
        if($id){
            if(!empty($data)){
                $post = array('title'=>$data);
                $db = \Config\Database::connect();
                $builder = $db->table($this->_table_names.'_lang');
                $builder->set($post);
                $builder->where('lid', $id); 
                $check = $builder->update();

                if($check){
                    $msg = 'success';
                }
            }
        }
        echo $msg;
    }


    public function editAdmin($id = NULL){///create and update
        // Fetch a data or set a new one
        if($id)
        {
            $check = $this->CommanModel->get_by($this->_table_names,array('id'=>$id), FALSE,false,true);
            if(!$check)
                return redirect()->to(base_url().'/'.$this->data['_cancel']);

            $this->data['news'] = $this->StaticTextModel->getLang($id, FALSE, $this->data['content_language_id']);
            //printR($this->data['news']);die;
            //set title
            $this->data['title'] = 'Edit | '.$this->data['settings']['site_name'];
            $this->data['name'] = 'Edit "'.$this->data['news']->name.'"';
        }
        else{
            //set title
            $this->data['title'] = 'Create | '.$this->data['settings']['site_name'];
            $this->data['name'] = 'Create ';

            //  set a new one
            $this->data['news'] = $this->StaticTextModel->getNew();
            //return redirect()->to(base_url().'/'.$this->data['admin_link'].$this->_redirect);
        }


        // Set up the form
        $input = $this->validate($this->StaticTextModel->getAllRules());

        // Process the form
        if($_POST){
            if($input) {
                $data_lang = $this->StaticTextModel->arrayFromPost($this->StaticTextModel->getLangPostFields());
                $data =array();
                $data = $this->StaticTextModel->arrayFromPost(array('name'));

                if($id == NULL){
                    $data['created'] = time();
                    $data['modified'] = time();
                }
                else{
                    $data['modified'] = time();
                }

                $id = $this->StaticTextModel->saveWithLang($data, $data_lang, $id);
                return redirect()->to(base_url().'/'.$this->data['admin_link'].$this->_redirect.'/editadmin');
            }
        }

        // Load the view
        $this->data['subview'] = $this->_subView.'/edit_admin';
        echo view('admin/_layout_main', $this->data);
    }

  

   
}
