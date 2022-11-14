<?php

namespace App\Controllers\Manage; 

use App\Core\Admincontroller;
use App\Models\backend\Emailmodel;

class Email extends Admincontroller {
    public $_table_names = 'email';			//set table name
    public $_subView = 'admin/email/';		//set subview
    public $_redirect = '/email';				//set controller link
    public $_current_revision_id;
    

    protected $CurrencyModel;

    public function __construct(){
        parent::__construct();

        $this->EmailModel = new Emailmodel();

        $this->data['ThisModule'] = $this->EmailModel;
        $this->data['CommanModel'] = $this->CommanModel;

        //set left menu active on admin dashboard
        $this->data['active'] = 'General Settings';
        $this->data['withoutlang'] = 1;
        
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
                    "Receiver" => array(),
                    "Action" => array(),
                );
        $blank_array = array();
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',true);
        $main_array_view = array(
                    "view_data"=>array(
                        "view_folder"=>"email",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"no",
                        "default_sort"=>"order",
                        "default_sort_type"=>"ASC",
                        "add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/email/edit'),
                        "order_link"=>"yes"
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List
        $this->data['postarrayelements'] = array('name','subject','receive','message');
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
            'subject'  =>  [
                            "label"          => "Subject",
                            "label_required" => "required",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'subject',
                                'id'    => '',
                            ]
                        ],
            'receive'  =>  [
                            "label"          => "Receive",
                            "label_required" => "required",
                            "type"           => "input",
                            "type_data"      => [
                                'type'  => 'text',
                                'name'  => 'receive',
                                'id'    => '',
                            ]
                        ],
            'message'  =>  [
                            "label"          => "Message",
                            "label_required" => "required",
                            "type"           => "textarea",
                            "type_data"      => [
                                'name'  => 'message',
                                'id'    => 'form_editor_0',
                                'class' => 'form-control form-control-solid form_editor form_editor_0',
                                'rows'  => '10',
                                'data-counter'  => 0,
                                'is_quill'  => true,
                            ]
                        ]
        );
    }

    public function index()
    {
        //set title
        $this->data['name'] = 'Document templates';
        $this->data['title'] = $this->data['name'];

        //set load view
        echo view('admin/_layout_main',$this->data);
    }


    public function edit($id = NULL)
    {
        // Fetch a data or set a new one
        if($id)
        {
            $this->data['name'] = 'Edit Document templates';
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
            $this->data['name'] = 'Create Document templates';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
            $this->data['thisItems']->image = '';
            $message = 'Data has successfully created';
        }
        $this->data['id'] = $id;
        // Process the form
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;
            //pp($this->data['ThisModule']->getAllRules());   
            $input = $this->validate($this->data['ThisModule']->getAllRules());
            if($input) {
                $data = $this->data['ThisModule']->arrayFromPost($this->data['postarrayelements']);
                if(is_null($id)) {
                    $data['order'] = $this->data['ThisModule']->maxOrder()+1;
                    $d_action = 'New Document template added.';
                }
                else {
                    $d_action = 'Document template updated.';
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
