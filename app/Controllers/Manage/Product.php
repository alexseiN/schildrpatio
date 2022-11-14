<?php

namespace App\Controllers\Manage;
use App\Core\Admincontroller;
use App\Models\backend\Productsmodel;

class Product extends Admincontroller {
    public $_table_names 	= 'product';					//set table 	
    public $_subView		= 'admin/product/';			//set subview
    public $_mainView 		= 'admin/_layout_main';		//set mainview
    public $_redirect		= '/product';					//set controller link

    protected $PagesModel;

    public function __construct(){
        parent::__construct();

        $this->ProductsModel = new Productsmodel();
        $this->data['ThisModule'] = $this->ProductsModel;
        $this->data['CommanModel'] = $this->CommanModel;
        
        $this->data['uploadFolder'] = 'assets/uploads/products'; 

        //set left menu active on admin dashboard
        $this->data['active'] = 'Product Management';
        //set left menu active on admin dashboard
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';


        $this->data['all_categories'] = $this->CommanModel->get_lang('pdcats',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);
        
        $this->data['pdcats'] = $this->CommanModel->get_lang('pdcats',$this->data['admin_lang'],false,array('parent_id != '=>0),'connlang_id',FALSE);


        foreach($this->data['pdcats'] as $pdcat){
            $pdcats[$pdcat->id] = $pdcat->title;
        }
        // for Global List
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Product Management';
        $this->data['_table_names'] = $this->_table_names;
        $columns_with_filteroptions = array(
                    "Name" => array(),
                    "Type" => array(),
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
                        "default_sort"=>"order",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/product/edit'),
                        "is_main_filter" => array(
                                            "name"=>"category_TYPEfindinset",
                                            "type"=>"select",
                                            "options"=>$pdcats,
                                            "events"=>array(
                                                "onchange"=>"getData('no')"
                                            )
                                        ),
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List
        $this->data['_lang_table_names'] = $this->data['_table_names'].'_lang';
        $this->data['_lang_category'] = 'pdcats_lang';
        
    }

    public function index()
    {
        //set title
        $this->data['name'] = 'Products';
        $this->data['title'] = $this->data['name'];
        echo view('admin/_layout_main',$this->data);
    }

    public function edit($id = NULL){
        //error_reporting(1);
        $blank_array = array();
        if($id){
            $this->data['name'] = 'Edit Products';
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
            $this->data['name'] = 'Create Products';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
            $this->data['thisItems']->image = '';
            $message = 'Data has successfully created';
        }
        $this->data['id'] = $id;
        $all_categories = $this->CommanModel->get_lang('pdcats',$this->data['admin_lang'],NULL,array(),'connlang_id',false);
        foreach($all_categories as $regions){
            $treearray[] = array("id"=>$regions->id,"parent_id"=>$regions->parent_id,"title"=>$regions->title);
        }
        $this->data['all_categories'] = buildTree($treearray);
       
        // Process the form
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;
            $input = $this->validate($this->data['ThisModule']->getAllRules(), array('required' => '%s Field required'));
            if($input) {
                // get post data from form
                $data = $this->data['ThisModule']->arrayFromPost(array('type'));
                if($id){
                    $previousdata = $this->data['thisItems'][0];
                    //$data['modified'] = time();
                }
                if(is_null($id)) {
                    $data['order'] = $this->data['ThisModule']->maxOrder()+1;
                    $data['date'] = date('Y-m-d H:i:s');
                    $d_action = 'New Product added.';
                }
                else {
                    $d_action = 'Product updated.';
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
                $data['category']  = implode(",",$postdata['category']);
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
        $this->data['subview'] = 'admin/product/edit';
        echo view('admin/_layout_main', $this->data);
    }

    
    public function orderAjax ()
    {
        // Save order from ajax call
        if (isset($_POST['sortable'])) {
            $this->data['ThisModule']->saveOrder($_POST['sortable']);
        }

        // Fetch all pages
        $this->data['thisItems'] = $this->data['ThisModule']->getNested($this->data['admin_lang'],$this->data['withoutlang'],array());
        
        
        $this->data['pdcats'] = $this->CommanModel->get_lang('pdcats', $this->data['admin_lang'], NULL, array(), 'connlang_id', false);
    
        // Load view
        echo view($this->_subView.'/order_ajax', $this->data);
    }
    
    
      public function searchAjax ()
    {
        $where =array();
        
        $category_id = $this->request->getVar('cat');
        
        if($category_id) {
            
            $where = array('category'=>$category_id);
        }
        
        
        // Save order from ajax call
        if (isset($_POST['sortable'])) {
            $this->data['ThisModule']->saveOrder($_POST['sortable']);
        }
        
         

        // Fetch all pages
       // $this->data['thisItems2'] = $this->data['ThisModule']->getNested($this->data['admin_lang'],$this->data['withoutlang'],$where);
        
        $object =  multiproduct ($category_id , 8, array());
        
        
        $this->data['thisItems'] = json_decode(json_encode($object), true);
        
        $this->data['pdcats'] = $this->CommanModel->get_lang('pdcats', $this->data['admin_lang'], NULL, array(), 'connlang_id', false);
        
        
        // Load view
        echo view($this->_subView.'/order_ajax', $this->data);
    }

}
