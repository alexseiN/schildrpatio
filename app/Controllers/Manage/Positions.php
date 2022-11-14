<?php

namespace App\Controllers\Manage;   

use App\Core\Admincontroller;
use App\Models\backend\Positionsmodel; 

class Positions extends Admincontroller {
    public $_table_names = 'positions';			//set table name
    public $_subView = 'admin/positions/';		//set subview
    public $_redirect = '/positions';				//set controller link
    
    

    protected $PositionsModel;

    public function __construct(){
        parent::__construct();

        $this->PositionsModel = new Positionsmodel();

        $this->data['ThisModule'] = $this->PositionsModel;
        $this->data['CommanModel'] = $this->CommanModel;
        

        //set left menu active on admin dashboard
        $this->data['active'] = 'Organisation';
        $this->data['withoutlang'] = 1;
        
        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';


        // for Global List
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Organisation';
        $this->data['_table_names'] = $this->_table_names;
        $columns_with_filteroptions = array(
                    "Title" => array(),
                    "Position" => array(),
                    "Action" => array(),
                );
        $blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);
        $main_array_view = array(
                    "view_data"=>array(
                        "view_folder"=>"positions",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"no",
                        "default_sort"=>"order",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/positions/edit'),
                        "order_link"=>"yes"
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List        
        $this->data['postarrayelements'] = array('title','ex','about');
        $this->data['postarrayelementswithinputs'] = array(
            'title'  =>  [
                            "label"          => "Title",
                            "label_required" => "required",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'title',
                                'id'    => '',
                            ]
                        ],
            'ex'  =>  [
                            "label"          => "Position",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'ex',
                                'id'    => '',
                            ]
                        ],
            'about'  =>  [
                            "label"          => "Responsibilities",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'about',
                                'id'    => '',
                            ]
                        ]
        );
    }

    public function index()
    {
        //set title
        $this->data['name'] = 'Positions';
        $this->data['title'] = $this->data['name'];

        echo view('admin/_layout_main',$this->data);
    }


    public function edit($id = NULL) 
    {
        if($id)
        {
            $this->data['name'] = 'Edit Positions';
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
            $this->data['name'] = 'Create Positions';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
            $message = 'Data has successfully created';
        }
        $this->data['id'] = $id;
        // Process the form
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;            
            $input = $this->validate($this->data['ThisModule']->getAllRules());
            if($input) {
                $data = $this->data['ThisModule']->arrayFromPost($this->data['postarrayelements']);
                if(is_null($id)) {
                    $data['order'] = $this->data['ThisModule']->maxOrder()+1;
                    $d_action = 'New Position added.';
                }
                else {
                    $d_action = 'Position updated.';
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
