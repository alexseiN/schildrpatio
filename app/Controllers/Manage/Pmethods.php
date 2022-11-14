<?php

namespace App\Controllers\Manage;
use App\Core\Admincontroller;
use App\Models\backend\Pmethodsmodel;

class Pmethods extends Admincontroller {
    public $_table_names = 'pmethods';
    public $_subView = 'admin/pmethods/';
    public $_redirect = '/pmethods';
    public $_current_revision_id;
    protected $PmethodsModel;

    public function __construct(){
        parent::__construct();
        $this->PmethodsModel = new Pmethodsmodel();
        $this->data['ThisModule'] = $this->PmethodsModel;
        $this->data['CommanModel'] = $this->CommanModel;

        $this->data['active'] = 'General Settings';
        $this->data['withoutlang'] = 1;

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
                        "view_folder"=>"pmethods",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"no",
                        "default_sort"=>"order",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/pmethods/edit'),
                        "order_link"=>"yes"
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List

        $this->data['postarrayelements'] = array('name','username','password','currency','signature','sandbox');
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
            'username'  =>  [
                            "label"          => "Username",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'username',
                                'id'    => '',
                            ]
                        ],
            'password'  =>  [
                            "label"          => "Password",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'password',
                                'id'    => '',
                            ]
                        ],
            'currency'  =>  [
                            "label"          => "Currency",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'currency',
                                'id'    => '',
                            ]
                        ],
            'signature'  =>  [
                            "label"          => "Signature",
                            "label_required" => "",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'signature',
                                'id'    => '',
                            ]
                        ],
            'sandbox'  =>  [
                            "label"          => "Is sandbox",
                            "label_required" => "",
                            "labelclass"     => "form-check-label mx-2",
                            "type"           => "checkbox",
                            "type_data"      => [
                                'name'       => 'sandbox',
                                'class'      => 'form-check-input',
                                'style'      => 'margin:10px'
                            ]
                        ]
        );

    }

    public function index()
    {
        $this->data['name'] = 'Payment methods';
        $this->data['title'] = $this->data['name'];
        echo view('admin/_layout_main',$this->data);
    }


    public function edit($id = NULL)
    {
        // Fetch a data or set a new one
        if($id)
        {
            $this->data['name'] = 'Edit Payment methods';
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
            $this->data['name'] = 'Create Payment methods';
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
                    $d_action = 'New Payment method added.';
                }
                else {
                    $d_action = 'Payment method updated.';
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
