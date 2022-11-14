<?php

namespace App\Controllers\Manage;

use App\Core\Admincontroller;
use App\Models\backend\Socialsmodel;

class Socials extends Admincontroller {
    public $_table_names = 'socials';			//set table name
    public $_subView = 'admin/socials/';		//set subview
    public $_redirect = '/socials';				//set controller link

    protected $SocialsModel;

    public function __construct(){
        parent::__construct();

        $this->SocialsModel = new SocialsModel();
        $this->data['ThisModule'] = $this->SocialsModel;
        $this->data['CommanModel'] = $this->CommanModel;
        $this->data['withoutlang'] = 1;
        
        $this->data['uploadFolder'] = 'assets/uploads/socials';

        //set left menu active on admin dashboard
        $this->data['active'] = 'General Settings';
        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';

        // for Global List
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Base';
        $this->data['_table_names'] = $this->_table_names;
        $columns_with_filteroptions = array(
                    "Name" => array(),
                    "Image" => array(),
                    "Link" => array(),
                    "Action" => array(),
                );
        $blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);
        $main_array_view = array(
                    "view_data"=>array(
                        "view_folder"=>"socials",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"no",
                        "default_sort"=>"order",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/socials/edit'),
                        "order_link"=>"yes"
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List
        $this->data['postarrayelements'] = array('name','link','class');
        $this->data['postarrayelementswithinputs'] = array(
            'name'  =>  [
                            "label"          => "Name",
                            "label_required" => "required",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'name',
                                'id'    => '',
                            ]
                        ],
            'link'  =>  [
                            "label"          => "Link",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'link',
                                'id'    => '',
                            ]
                        ],
            'class'  =>  [
                            "label"          => "Class",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'class',
                                'id'    => '',
                            ]
                        ],
        );
    }

    public function index()
    {
        //set title
        $this->data['name'] = 'Social networks';
        $this->data['title'] = $this->data['name'];

        //set load view
        echo view('admin/_layout_main',$this->data);
    }




    public function edit($id = NULL)
    {
        // Fetch a data or set a new one
        if($id)
        {
            $this->data['name'] = 'Edit Social networks';
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
            $this->data['name'] = 'Create Social networks';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
            $this->data['thisItems']->image = '';
            $message = 'Data has successfully created';
        }
        $this->data['id'] = $id;
        // Process the form
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;            
            $input = $this->validate($this->data['ThisModule']->getAllRules());
            if($input) {
                if($id) {
                    $previousdata = $this->data['thisItems'][0];
                }
                $data = $this->data['ThisModule']->arrayFromPost($this->data['postarrayelements']);
                if(is_null($id)) {
                    $data['order'] = $this->data['ThisModule']->maxOrder()+1;
                    $d_action = 'New Social network added.';
                }
                else {
                    $d_action = 'Social network updated.';
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
                $id = $this->data['ThisModule']->saveData($data, $id);

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
