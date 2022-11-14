<?php

namespace App\Controllers\Manage;

use App\Core\Admincontroller;
use App\Models\backend\Branchesmodel;
use App\Models\Detectmodel;

class Branches extends Admincontroller {
    public $_table_names 	= 'branches';		//set table
    public $_subView = 'admin/branches/';			//set subview
    public $_mainView = 'admin/_layout_main';		//set mainview
    public $_redirect = '/branches';	 			//set controller link

    protected $BranchesModel;

    public function __construct(){
        parent::__construct(); 
        
        $this->BranchesModel = new Branchesmodel();
        $this->DetectModel = new Detectmodel();
        $this->data['ThisModule'] = $this->BranchesModel;
        
        $this->data['uploadFolder'] = 'assets/uploads/branches'; 

        //set left menu active on admin dashboard
        $this->data['active'] = 'Organisation';
        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';

        $this->data['regions'] = $this->CommanModel->get_lang('regions', $this->data['admin_lang'], NULL, array(), 'connlang_id', false);
                // for Global List
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Organisation';
        $this->data['_table_names'] = $this->_table_names;
        $columns_with_filteroptions = array(
                    "Name" => array(),
                    "Region" => array(),
                    "Type" => array(),
                    "Action" => array(),
                );
        $blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);
        $main_array_view = array(
                    "view_data"=>array(
                        "view_folder"=>"branches",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"no",
                        "default_sort"=>"order",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/branches/edit'),
                        "order_link"=>"yes"
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List
        $this->data['_lang_table_names'] = $this->data['_table_names'].'_lang';
    }

    public function index(){
        $this->data['name'] = 'Branches';
        $this->data['title'] = $this->data['name'];
        
        echo view('admin/_layout_main',$this->data);
    }



    public function edit($id = NULL){
	error_reporting(0);
        if($id){
            $this->data['name'] = 'Edit Branch';
            $this->data['title'] = $this->data['name'];
            $blank_array = array();
            $where['id'] = $id;
            $this->data['thisItems'] = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$blank_array,$blank_array,'',0,'all',false);
            if(count($this->data['thisItems'])<=0){
                return redirect()->to($this->data['_cancel']);
            }
            $message = 'Data has successfully updated';
        }
        else{
            // set title
            $this->data['name'] = 'Create Branch';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
	    $this->data['thisItems']->image = '';
	    $this->data['thisItems']->region_id = '';
	    $message = 'Data has successfully created';
        }
	$this->data['id'] = $id;
        $region_list = $this->CommanModel->get_lang('regions',$this->data['admin_lang'],NULL,array(),'connlang_id',false);
	foreach($region_list as $regions){
	    $treearray[] = array("id"=>$regions->id,"parent_id"=>$regions->parent_id,"title"=>$regions->title);
	}
	$this->data['region_list'] = buildTree($treearray);
	//pp($this->data['region_list']);

        // Process the form
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;
	         
            $input = $this->validate($this->data['ThisModule']->getAllRules(), array('required' => '%s field required'));
            if($input) {
		if($id){
		    $previousdata = $this->data['thisItems'][0];
		}
                $data = $this->data['ThisModule']->arrayFromPost(array('region_id','gps','name','bname','code','reg','city','requisite','email','ortype','metric','diff','currency'));
                if(is_null($id)) {
                    $data['order'] = $this->data['ThisModule']->maxOrder()+1;
		    $d_action = 'New Branch added.';
                }
                else {
                    $d_action = 'Branch updated.';
                }
                $data_lang = $this->data['ThisModule']->arrayFromPost($this->data['ThisModule']->getLangPostFields());
                if($id == NULL){
                    $latlong = explode(', ',$data['gps']); 
                    if($data['gps']) {
			$compound = $this->DetectModel->get_compound(trim($latlong[0]),trim($latlong[1]));
			$data['city'] = trim($compound[1]);
			$data['reg'] = trim($compound[2]);
                    }
                }
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
		$data['phones'] = $postdata['phones'];
		$data['zipranges'] = $postdata['zipranges']; 
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

    public function orderAjax ()
    {
        // Save order from ajax call
        if (isset($_POST['sortable'])) {
            $this->data['ThisModule']->saveOrder($_POST['sortable']);
        }

        // Fetch all pages
        $this->data['thisItems'] = $this->data['ThisModule']->getNested($this->data['admin_lang'],$this->data['withoutlang'],array());
        
    
        $this->data['regions'] = $this->CommanModel->get_lang('regions', $this->data['admin_lang'], NULL, array(), 'connlang_id', false);
        
        

        // Load view
        echo view($this->_subView.'/order_ajax', $this->data);
    }
    
    function do_m(){
		$output = array();
		$output['status']= 'error';
		$output['message']= 'there is no data';
		$id = $this->request->getVar('id');
		
		
		if($id){
			$check_user = $this->CommanModel->get_by($this->_table_names,array('id'=>$id),false,false,true);
			if($check_user){
				$output['status']= 'ok';
				$output['message']= '';
				
				$builder = $this->db->table($this->_table_names);
				$builder->set('m',0);
				$builder->update();
				
				
				$builder = $this->db->table($this->_table_names);
				$builder->where('id', $check_user->id);
				
				if($check_user->m==1){
					$builder->set('m',0);
				}
				else{
					$builder->set('m',1);
				}
				$builder->update();
			}
		}
		echo json_encode($output);
	}
	
	function do_rm(){
		$output = array();
		$output['status']= 'error';
		$output['message']= 'there is no data';
		$id = $this->request->getVar('id');
		
		
		if($id){
			$check_user = $this->CommanModel->get_by($this->_table_names,array('id'=>$id),false,false,true);
			if($check_user){
				$output['status']= 'ok';
				$output['message']= '';
				
				$builder = $this->db->table($this->_table_names);
				$builder->where('region_id', $check_user->region_id);
				$builder->set('rm',0);
				$builder->update();
				
				
				$builder = $this->db->table($this->_table_names);
				$builder->where('id', $check_user->id);
				
				if($check_user->rm==1){
					$builder->set('rm',0);
				}
				else{
					$builder->set('rm',1);
				}
				$builder->update();
			}
		}
		echo json_encode($output);
	}

}
