<?php

namespace App\Controllers\Manage; 

use App\Core\Admincontroller;
use App\Models\backend\Pagesmodel;

class Page extends Admincontroller { 
    public $_table_names 	= 'page';					//set table 	
    public $_subView		= 'admin/page/';			//set subview
    public $_mainView 		= 'admin/_layout_main';		//set mainview
    public $_redirect		= '/page';					//set controller link
    public $_current_revision_id;

    protected $PagesModel;

    public function __construct(){
        parent::__construct();

        $this->PagesModel = new Pagesmodel();
        $this->data['ThisModule'] = $this->PagesModel;
        $this->data['CommanModel'] = $this->CommanModel;
        
        $this->data['uploadFolder'] = 'assets/uploads/pages'; 

        //set left menu active on admin dashboard
        $this->data['active'] = 'Content management';
        //set left menu active on admin dashboard
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';

        // for Global List
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Content Management';
        $this->data['_table_names'] = $this->_table_names;
        $columns_with_filteroptions = array(
                    "Name" => array(),
                    "Template" => array(),
                    "Position" => array(),
                    "Action" => array(),
                );
        $blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);
        $main_array_view = array(
                    "view_data"=>array(
                        "view_folder"=>"page",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"no",
                        "default_sort"=>"order",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/page/edit'),
                        "order_link"=>"yes"
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List
        $this->data['_lang_table_names'] = $this->data['_table_names'].'_lang';
    }

    public function index()
    {
        //set title
        $this->data['name'] = 'Pages';
        $this->data['title'] = $this->data['name'];
        echo view('admin/_layout_main',$this->data);
    }


    public function edit($id = NULL){
        $blank_array = array();
        if($id){
            $this->data['name'] = 'Edit Pages';
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
            $this->data['name'] = 'Create Pages';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
            $this->data['thisItems']->image = '';
            $message = 'Data has successfully created';
        }
        $this->data['id'] = $id;       
        $this->data['templates_page'] = $this->data['ThisModule']->getTemplates('page_');
        // Process the form
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;
            $input = $this->validate($this->data['ThisModule']->getAllRules(), array('required' => '%s '.'Field required'));
            if($input) {
                $data = $this->data['ThisModule']->arrayFromPost(array('template','top_left','top_right','middle_left','middle_right','footer_a','footer_b'));
                if($id){
                    $previousdata = $this->data['thisItems'][0];
                }
                if(is_null($id)) {
                    $data['order'] = $this->data['ThisModule']->maxOrder()+1;
                    $data['date'] = date('Y-m-d H:i:s');
                    $d_action = 'New Page added.';
                }
                else {
                    $d_action = 'Page updated.';
                }
                $data_lang = $this->data['ThisModule']->arrayFromPost($this->data['ThisModule']->getLangPostFields());
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
        // Load the view
        $this->data['subview'] = 'admin/page/edit';
        echo view('admin/_layout_main', $this->data);
    }
}
