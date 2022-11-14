<?php

namespace App\Controllers\Manage; 

use App\Core\Admincontroller;
use App\Models\backend\Pdcatsmodel;

class Pdcats extends Admincontroller
{
    public $_table_names 	= 'pdcats';		//set table
    public $_subView = 'admin/pdcats/';			//set subview
    public $_mainView = 'admin/_layout_main';		//set mainview
    public $_redirect = '/pdcats';				//set controller link

    protected $PdcatsModel;

    public function __construct(){
        parent::__construct();
        //set left menu active on admin dashboard
        $this->data['active'] = 'Product Management';

        $this->PdcatsModel = new Pdcatsmodel();
        $this->data['ThisModule'] = $this->PdcatsModel;
        
        $this->data['uploadFolder'] = 'assets/uploads/pdcats'; 

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
                        "view_folder"=>"pdcats",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"no",
                        "default_sort"=>"order",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/pdcats/edit'),
                        "order_link"=>"yes",
                        
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List
        $this->data['_lang_table_names'] = $this->data['_table_names'].'_lang';
        $this->data['_lang_applications'] = 'applications_lang';
        $this->data['_lang_colorcats'] = 'colorcats_lang';
        
    }

    public function index()
    {
        $this->data['name'] = 'Categories';
        $this->data['title'] = $this->data['name'];
        echo view('admin/_layout_main',$this->data);
    }



   public function edit($id = NULL){
        $blank_array = array();
        if($id){
            $this->data['name'] = 'Edit Categories';
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
            $this->data['name'] = 'Create Categories';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
            $this->data['thisItems']->image = '';
            $message = 'Data has successfully created';
        }
        $this->data['id'] = $id;
        $this->data['all_applications'] = $this->CommanModel->getDatamwithlimit('applications',$blank_array,$blank_array,$blank_array,"order ASC",0,'all',false);
        $this->data['all_colorcats'] = $this->CommanModel->getDatamwithlimit('colorcats',$blank_array,$blank_array,$blank_array,"order ASC",0,'all',false);
	//process form
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;
            $input = $this->validate($this->data['ThisModule']->getAllRules(), array('required' => '%s Field required'));
            if($input) {
                $data = $this->data['ThisModule']->arrayFromPost(array('video','bcolor'));
                if($id){
                    $previousdata = $this->data['thisItems'][0];
                    $data['modified'] = time();
                }
                if(is_null($id)) {
                    $data['order'] = $this->data['ThisModule']->maxOrder()+1;
                    $d_action = 'New Product Category added.';
                }
                else {
                    $d_action = 'Product Category updated.';
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
                
                // echo '<pre>'; print_r($postdata);die();
                
                if (isset($postdata['secolorcats'])) { $data['secolorcats']   = implode(",",$postdata['secolorcats']); }
                
                
                if (isset($postdata['seapplication'])) { $data['seapplication'] = implode(",",$postdata['seapplication']); }
                
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
        //set load view
        $this->data['subview'] = $this->_subView.'edit';
        echo view('admin/_layout_main', $this->data);
    }
}
