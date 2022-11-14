<?php

namespace App\Controllers\Manage;

use App\Core\Admincontroller;
use App\Models\backend\Locproductsmodel;

class Locproducts extends Admincontroller { 
    public $_table_names 	= 'locproducts';					//set table 	
    public $_subView		= 'admin/locproducts/';			//set subview
    public $_mainView 		= 'admin/_layout_main';		//set mainview
    public $_redirect		= '/locproducts';					//set controller link

    protected $PagesModel;

    public function __construct(){
        parent::__construct();

        $this->LocproductsModel = new Locproductsmodel();
        $this->data['ThisModule'] = $this->LocproductsModel;
        $this->data['CommanModel'] = $this->CommanModel;
        
        $this->data['uploadFolder'] = 'assets/uploads/locproducts'; 

        //set left menu active on admin dashboard
        $this->data['active'] = 'Local Store';
        //set left menu active on admin dashboard
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';


        $this->data['colors'] = $this->CommanModel->get_lang('loccolor',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);
        foreach($this->data['colors'] as $gender){
            $locgenders[$gender->id] = $gender->title;
        }
        foreach($this->data['all_categories'] as $loccat){
            $loccats[$loccat->id] = $loccat->title;
        }

        // for Global List
        $this->data['_table_names'] = $this->_table_names;
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Local Store';
        $Statusoptions = array("0"=>"Normal","1"=>"Problem");
        $enabledoptions = array("1"=>"Enabled","0"=>"Disabled");
        $columns_with_filteroptions = array(
                "Code" => array(
                            "name"=>"code_TYPElike",
                            "type"=>"text",
                            "events"=>array(
                                "onkeyup"=>"getData('no')"
                            )
                        ),
                "Image" => array(
                            
                        ),
                "Name" => array(
                            "name"=>"title_TYPEjoinlike",
                            "type"=>"text",
                            "events"=>array(
                                "onkeyup"=>"getData('no')"
                            )					
                        ),
                "Category" => array(
                                "name"=>"category_TYPEfindinset",
                                "type"=>"select",
                                "options"=>$loccats,
                                "events"=>array(
                                    "onchange"=>"getData('no')"
                                )
                            ),
                "Color" => array(
                                "name"=>"color_TYPEfindinset",
                                "type"=>"select",
                                "options"=>$locgenders,
                                "events"=>array(
                                    "onchange"=>"getData('no')"
                                )
                            ),
                "New Price" => array(
                        "name"=>"nprice_TYPElike",
                        "type"=>"text",
                        "events"=>array(
                        "onkeyup"=>"getData('no')"
                        )
                    ),
                "Action" => array(
                            "name"=>"enabled_TYPEwhere",
                            "type"=>"select",
                            "options"=>$enabledoptions,
                            "events"=>array(
                                "onchange"=>"getData('no')"
                            )
                        ),
                );
        $blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);
        $main_array_view = array(
                    "view_data"=>array(
                        "view_folder"=>"locproducts",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"yes",
                        "default_sort"=>"order",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"yes","link"=>$this->data['_cancel'].'/edit'),
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
        $this->data['name'] = 'Products';
        $this->data['title'] = $this->data['name']; 
        echo view('admin/_layout_main',$this->data);
    }
    
    
    function ajax_list(){
		
		
		$where= array();
		$multi=array();
       
        
        $id = $this->request->getPost('id');
        $title = $this->request->getPost('title');
        $nprice = $this->request->getPost('nprice');
        $category = $this->request->getPost('pdcat');
        $gender = $this->request->getPost('gender');
        $enabled = $this->request->getPost('enabled');
        
        
            
    
		
	
		if ($enabled == '1') {$where['enabled']=1;} else
		if ($enabled == '0') {$where['enabled']=0;} else {unset($where['enabled']);}
		    
        $like = array(
            'id'=>$id,
            'title'=>$title,
            'nprice'=>$nprice
            
            );
   
   
        if($gender) { $multi['gender']=$gender; } else {unset($multi['gender']);}
        if($category) { $multi['category']=$category; } else {unset($multi['category']);}
        
   
       

			
			
			
			
		$this->items['objects'] = $this->CommanModel->getDatam2('locproducts',$where,9,$like,'id',$multi);  

		
		
		//set load view
        $this->data['subview'] = 'locproducts/index';
        $html = view('admin/locproducts/ajax_list', $this->items);
        
		return $html;
		
		
		
	}
    
    
    function productview($id){
        $data = array();
        
        $thisItems = $this->CommanModel->get_lang('locproducts',$this->data['admin_lang'],false,array('enabled'=>1,'id'=>$id),'connlang_id',FALSE);
                
        if(!$thisItems) {
            $this->data['session']->setFlashdata('error','Product not found.');
            return redirect()->to($this->data['_cancel']);
        }

        $this->data['thisItems'] = $thisItems[0];        
        $this->data['name'] = $this->data['thisItems']->title;
        $this->data['title'] = 'Product Details';

        $this->data['moreFiles'] = $this->CommanModel->get_by('files',array('section'=>$this->_table_names,'connfile_id'=>$id),false,array('order'=>'asc'),false);

        $this->data['subview'] = $this->_subView.'view'; 
        echo view('admin/_layout_main',$this->data);
        
    }
    public function edit($id = NULL){
        $blank_array = array();
        if($id){
            $this->data['name'] = 'Edit Product';
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
            $this->data['name'] = 'Create Product';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
            $this->data['thisItems']->image = '';
            $message = 'Data has successfully created';
        }
        $this->data['id'] = $id;

        $this->data['all_genders'] = $this->CommanModel->get_lang('locgender',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);
        $this->data['all_products'] = $this->CommanModel->get_lang('locproducts',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);
        // Process the form
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;
            $input = $this->validate($this->data['ThisModule']->getAllRules(), array('required' => '%s Field required'));
            if($input) {
                $data = $this->data['ThisModule']->arrayFromPost(array('nprice','code','unitboy','mtkg'));    
               // $fields = $this->data['ThisModule']->arrayFromPost(array('categorytag_id','sizetag_id','gendertag_id','colorstag_id'));
                $data_lang = $this->data['ThisModule']->arrayFromPost($this->data['ThisModule']->getLangPostFields());
                $data['oprice'] = 0;
                
                if($id){
                    $previousdata = $this->data['thisItems'][0];
                }
                if(is_null($id)) {
                    $data['order'] = $this->data['ThisModule']->maxOrder()+1;
                    $data['date'] = date('Y-m-d H:i:s');
                    $d_action = 'New Store product added.';
                }
                else {
                    $d_action = 'Store product updated.';
                }
                $data['category']  = implode(",",$postdata['category']);
               // $data['size']  = implode(",",$postdata['size']);
                $data['colors']  = implode(",",$postdata['colors']);
            //    $data['gender']  = implode(",",$postdata['gender']);
                //pp($data);
                //create or update data
                
               // echo '<pre>';print_r($data);
            //    echo '<hr>';
             //   echo '<pre>';print_r($data_lang);die();
                
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
        $this->data['subview'] = 'admin/locproducts/edit';
        echo view('admin/_layout_main', $this->data);
    }


    //delete data
    public function delete($id)
    {
        if($this->data['adminDetails']->default=='0'){
            $this->data['session']->setFlashdata('error','Sorry ! You have no permission.');
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }


        //delete more images
        $path_img = $this->data['uploadFolder'].'/';
        $get_data = $this->CommanModel->get_by($this->_table_names.'_files', array('connfile_id'=>$id),false,false,false);
        if($get_data){
            foreach($get_data  as $set_v){
                $db = \Config\Database::connect();
                $db->table($this->_table_names.'_files')->delete(array('id'=>$set_v->id));
                if(!empty($set_v->image)){
                    $file1= $path_img.$set_v->image;
                    if(is_file($file1)){
                        unlink($file1);
                    }
                }
            }
        }
        //die;
        $this->data['ThisModule']->deleteData($id);
        return redirect()->to(base_url().'/'.$this->data['_cancel']);
    }
    
   

}
