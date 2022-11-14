<?php

namespace App\Controllers\Manage;  
use App\Core\Admincontroller;
use App\Models\backend\Bsectionsmodel;

class Bsections extends Admincontroller {
    public $_table_names 	= 'bsections';		//set table
    public $_subView = 'admin/bsections/';			//set subview
    public $_mainView = 'admin/_layout_main';		//set mainview
    public $_redirect = '/bsections';				//set controller link

    protected $SectionsModel;

    public function __construct(){
        parent::__construct();
        
        //set left menu active on admin dashboard
        $this->data['active'] = 'Content management';

        $this->BsectionsModel = new Bsectionsmodel();
        $this->data['ThisModule'] = $this->BsectionsModel;
        
        $this->data['uploadFolder'] = 'assets/uploads/bsections';

        //set link with function name 
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';

        $this->data['_m_cancel'] = $this->data['admin_link'].'/bsections';

        // for Global List
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Content management';
        $this->data['_table_names'] = $this->_table_names;
        $columns_with_filteroptions = array(
                    "Name" => array(),
                    "Action" => array()
                );
        $uri = current_url(true);
        $segment = $uri->getSegment('4');


        $blank_array = array();
        $where['category_id'] = $segment;
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$blank_array,$blank_array,'',0,'all',true);
        //pp($total_count);
        $main_array_view = array(
                    "view_data"=>array(
                        "view_folder"=>"bsections",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"no",
                        "default_sort"=>"order",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"yes","link"=>$this->data['_edit'].'/'.$segment),
                        "is_main_filter" => array(),
                        "order_link"=>"yes",
                        "segment_add_order"=>$segment,
                        
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List
        $this->data['_lang_table_names'] = $this->data['_table_names'].'_lang';
        
    }

    public function l($id=false){
        if(!$id){
            return redirect()->to($this->data['_m_cancel']);
        }
        $this->data['c_id'] = $id;
        $this->data['name'] = 'Blog Sections';
        $this->data['title'] = $this->data['name'];
        echo view('admin/_layout_main',$this->data);
    }

    public function orderAjax($id=false){
        // Save order from ajax call
        if (isset($_POST['sortable'])) {
            $this->data['ThisModule']->saveOrder($_POST['sortable']);
        }

        // Fetch all pages
        $this->data['thisItems'] = $this->data['ThisModule']->getNested($this->data['admin_lang'],false,array('category_id'=>$id));

        // Load view
        echo view($this->_subView.'order_ajax', $this->data);
    }

    public function edit($c_id=false,$id = NULL){
                if(!$c_id){
            return redirect()->to($this->data['_m_cancel']);
        }

        //$this->data['_cancel'] = $this->data['_cancel'].'/l/'.$c_id;
        $this->data['_return_url'] = $this->data['_cancel'].'/l/'.$c_id;
        
        $this->data['c_id'] = $c_id;
        $blank_array = array();
        if($id){
            $this->data['name'] = 'Edit Blog Section';
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
            $this->data['name'] = 'Create Blog Section';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
            $this->data['thisItems']->image = '';
            $message = 'Data has successfully created';
        }
        $this->data['id'] = $id;
        $this->data['templates_page'] = $this->data['ThisModule']->getTemplates('page_');

        if(!empty($this->postdata)) {
            
            $postdata = $this->postdata;
            
            $input = $this->validate($this->data['ThisModule']->getAllRules(), array('required' => '%s Field required'));
            
            if($input) {
                
                $data = $this->data['ThisModule']->arrayFromPost(array('template','parent_id'));
                
                $data['parent_id'] = 0;
                
                $data['category_id'] = $c_id;
                
                $data_lang = $this->data['ThisModule']->arrayFromPost($this->data['ThisModule']->getLangPostFields());
                
                //pp($data_lang);
                
                if($id == NULL){
                    
                    $data['on_date'] = date('Y-m-d H:i:s');
                    
                    $data['created'] = time();
                    
                    $data['modified'] = time();
                    
                    $d_action = 'New Blog Section added.';
                }
                else {
                    $d_action = 'Blog Section updated.';
                    
                    $data['modified'] = time();
                    
                }
                
                $id = $this->data['ThisModule']->saveWithLang($data, $data_lang, $id);

                $d_action .= ' <a href="'.$this->data['_cancel'].'/edit/'.$c_id.'/'.$id.'" class="fs-6 text-gray-800 text-hover-primary fw-bold">View</a>';		
                $logged_in = $this->data['adminDetails'];
                $employeeid = $logged_in->employee_id;
                $insertactivity['employee'] = $employeeid;
                $insertactivity['d_action'] = $d_action;
                $insertactivity['created']  = date("Y-m-d H:i:s");
                activitylogs($insertactivity,'insert');
                
                            
                $this->data['session']->setFlashdata('success',$message);
                
                return redirect()->to($this->data['_return_url']);
                
            }
            
            else {
                
                return redirect()->back()->withInput()->with('error', $this->data['validation']->listErrors());
                
            }
            
        }
        
        $this->data['subview'] = $this->_subView.'edit';
        
        echo view('admin/_layout_main', $this->data);
    }



    //delete data
    public function delete($c_id=false,$id=false){
        if(!$c_id){
            return redirect()->to(base_url().'/'.$this->data['_m_cancel']);
        }
        $this->data['_cancel'] = $this->data['_cancel'].'/l/'.$c_id;
        if($this->data['adminDetails']->default=='0'){
            $this->data['session']->setFlashdata('error','Sorry ! You have no permission.');
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }

        $this->data['ThisModule']->deleteData($id);
        return redirect()->to(base_url().'/'.$this->data['_cancel']);
    }

}
