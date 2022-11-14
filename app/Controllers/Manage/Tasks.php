<?php

namespace App\Controllers\Manage;

use App\Core\Admincontroller;
use App\Models\backend\Tasksmodel;

class Tasks extends Admincontroller {
    public $_table_names = 'tasks';			//set table name
    public $_subView = 'admin/tasks/';		//set subview
    public $_redirect = '/tasks';				//set controller link
    

    public function __construct(){
        parent::__construct();

        $this->TasksModel = new Tasksmodel();

        $this->data['ThisModule'] = $this->TasksModel;
        $this->data['CommanModel'] = $this->CommanModel;

        //set left menu active on admin dashboard
        $this->data['active'] = 'Important';
        $this->data['withoutlang'] = 1;
        
        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';


        $this->data['_table_names'] = $this->_table_names;
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Intranet';
        $loggedinuseremp = $this->data['adminDetails']->employee_id;
        $get_emp_tasks = $this->CommanModel->get_emp_tasks($loggedinuseremp,'all','all');
        
        $n_by_array = array();$n_assigned_array = array();
        if(count($get_emp_tasks)>0){
            $by_array = array($loggedinuseremp);$assigned_array = array($loggedinuseremp);
            foreach($get_emp_tasks as $emp_task){
                if(($emp_task->by != $loggedinuseremp) && ($emp_task->assigned == $loggedinuseremp)){
                    array_push($by_array,$emp_task->by);
                }
                if(($emp_task->by == $loggedinuseremp) && ($emp_task->assigned != $loggedinuseremp)){
                    array_push($assigned_array,$emp_task->assigned);
                }                
            }
            $n_by_array = array_unique($by_array);
            $n_assigned_array = array_unique($assigned_array);
        }        

        $this->data['get_emp_tasks'] = $get_emp_tasks;
        
        $this->data['n_by_array'] = $n_by_array;
        $this->data['n_assigned_array'] = $n_assigned_array;
        

        $this->data['employees'] = $this->CommanModel->get_lang('employees',false,false,array(),'connlang_id',FALSE);
        
        foreach($this->data['employees'] as $employee) { $optiondata[$employee->id] = $employee->first_name.' '.$employee->last_name; }

        $typedata = getarray('type');
        $statusdata = getarray('status');

        $this->data['typedata'] = $typedata;
        $this->data['statusdata'] = $statusdata;

        $this->data['adminId'] = $loggedinuseremp;

        $this->data['loggedinuser'] = $loggedinuseremp;
        $this->data['loggedinusername'] = $optiondata[$loggedinuseremp];
        $this->data['optiondata'] = $optiondata;

        // for Global List
        $Statusoptions = array("0"=>"Normal","1"=>"Problem");
        $columns_with_filteroptions = array(
                "ID" => array(
                        "name"=>"id_TYPElike",
                        "type"=>"text",
                        "events"=>array(
                        "onkeyup"=>"getData('no')"
                        )
                    ),
                "Title" => array(
                            "name"=>"title_TYPElike",
                            "type"=>"text",
                            "events"=>array(
                                "onkeyup"=>"getData('no')"
                            )					
                        ),
                "By" => array(
                                "name"=>"by_TYPEwhere",
                                "type"=>"selectwithcondition",
                                "options"=>$optiondata,
                                "condition"=>$n_by_array,
                                "events"=>array(
                                    "onchange"=>"getData('no',this)"
                                )
                            ),
                "Assigned" => array(
                                "name"=>"assigned_TYPEwhere",
                                "type"=>"selectwithcondition",
                                "options"=>$optiondata,
                                "condition"=>$n_assigned_array,
                                "events"=>array(
                                    "onchange"=>"getData('no',this)"
                                )
                            ),
                "Type" => array(
                                "name"=>"type_TYPEwhere",
                                "type"=>"select",
                                "options"=>$typedata,
                                "events"=>array(
                                    "onchange"=>"getData('no',this)"
                                )
                            ),
                "Status" => array(
                            "name"=>"status_TYPEwhere",
                            "type"=>"select",
                            "options"=>$statusdata,
                            "events"=>array(
                                "onchange"=>"getData('no',this)"
                            )
                        ),
                "Deadline" => array(),
                "Action" => array(),
                );
                
        //$blank_array = array();
        //$total_count = $this->CommanModel->get_emp_tasks_filter($this->_table_names,$where,$havingIn,$like,'updated',$row,'all',$loggedinuseremp);
        
        $total_count = count($get_emp_tasks);
        
        $main_array_view = array(
                            "view_data"=>array(
                                "view_folder"=>"tasks",
                                "columns_with_filteroptions"=>$columns_with_filteroptions,
                                "total_count"=>$total_count,
                                "is_filter"=>"yes",
                                "default_sort"=>"updated",
                                "default_sort_type"=>"DESC",
                                "add_link"=>array("status"=>"yes","link"=>"javascript:","id"=>"addtablerow")
                            )
                        );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List

    }


    public function updatetaskrow(){
        if(!empty($this->postdata)){
            $postdata = $this->postdata;
            $name = $postdata['name'];
            $value = $postdata['value'];
            $pk = $postdata['pk'];
            $n_by_array = array();$n_assigned_array = array();$optionset = '';
            $taskdata = $this->data['ThisModule']->get($pk, FALSE);
            $deadline = $taskdata->created + intval($taskdata->deadline)*24*3600;
            if((!empty($value)) || $name == 'deadline') {
                $status = 'success';
                $data[$name] = $value;
                $data['updated'] = time();
                $this->data['ThisModule']->saveData($data, $pk);

                $d_action = 'Task updated. <a href="'.$this->data['_cancel'].'/edit/'.$pk.'" class="fs-6 text-gray-800 text-hover-primary fw-bold">View Task</a>';		
                $logged_in = $this->data['adminDetails'];
                $employeeid = $logged_in->employee_id;
                $insertactivity['employee'] = $employeeid;
                $insertactivity['d_action'] = $d_action;
                $insertactivity['created']  = date("Y-m-d H:i:s");
                activitylogs($insertactivity,'insert');
                
                if($name == "deadline" && !empty($value)){
                    $deadline = $taskdata->created + intval($value)*24*3600;
                }
                else if($name == "deadline" && empty($value)){
                    $deadline = '';
                }
                $loggedinuseremp = $this->data['adminDetails']->employee_id;
                $get_emp_tasks = $this->CommanModel->get_emp_tasks($loggedinuseremp,'all','all');
                $employees = $this->CommanModel->get_lang('employees',false,false,array(),'connlang_id',FALSE);
                foreach($employees as $employee) { $optiondata[$employee->id] = $employee->first_name.' '.$employee->last_name; }
                if(count($get_emp_tasks)>0){
                    $by_array = array($loggedinuseremp);$assigned_array = array($loggedinuseremp=>$optiondata[$loggedinuseremp]);
                    foreach($get_emp_tasks as $emp_task){
                        if(($emp_task->by != $loggedinuseremp) && ($emp_task->assigned == $loggedinuseremp)){
                            array_push($by_array,$emp_task->by);
                        }
                        if(($emp_task->by == $loggedinuseremp) && ($emp_task->assigned != $loggedinuseremp)){
                            $assigned_array[$emp_task->assigned] = $optiondata[$emp_task->assigned];
                        }                
                    }
                    $n_by_array = array_unique($by_array);
                    $n_assigned_array = array_unique($assigned_array);
                    $optionset = create_select_options($n_assigned_array);
                }
                
                          
            } else {
                $status = 'error';
            }
            $showdeadline = branchtime($deadline,false,'M d,Y');
            $jsonrerurn = json_encode(array(
                "status" => $status,
                "n_assigned_array"=>$n_assigned_array,
                "name"=>$name,
                "optionset" =>$optionset,
                "showdeadline" => $showdeadline,
                "pk"=>$pk
            ));
            echo $jsonrerurn;
        }
    }
    public function index() {
        $this->data['name'] = 'Task management';
        $this->data['title'] = $this->data['name'];
        echo view('admin/_layout_main',$this->data);
    }

    public function edit($id = NULL)
    {
        $blank_array = array();
        if($id){
            $this->data['name'] = 'Edit Task';
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
            $this->data['name'] = 'Create Task';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
            $this->data['thisItems']->image = '';
            $message = 'Data has successfully created';
        }
        $this->data['id'] = $id;
        $this->data['employees'] = $this->CommanModel->get_lang('employees',false,false,array(),'connlang_id',FALSE);
        // Process the form
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;            
            $input = $this->validate($this->data['ThisModule']->getAllRules());
            if($input) {
                $data = $this->data['ThisModule']->arrayFromPost(array('by','assigned','title','type','status','deadline','explanation'));
                if(is_null($id)) {
                    $data['created'] = time();
                    $d_action = 'New Task added.';
                }
                else {
                    $data['updated'] = time();
                    $d_action = 'Task updated.';
                }
                $id = $this->data['ThisModule']->saveData($data, $id);

                $d_action .= ' <a href="'.$this->data['_cancel'].'/edit/'.$id.'" class="fs-6 text-gray-800 text-hover-primary fw-bold">View Task</a>';		
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
    
    public function save_ajax($id = NULL) {
        if($this->postdata){
            $input = $this->validate($this->data['ThisModule']->getAllRules());
            if($input) {
                $data = $this->data['ThisModule']->arrayFromPost(array('by','assigned','title','type','status','deadline','explanation'));
                        
                $data['updated'] = time();
                $data['created'] = time();
                $id = $this->data['ThisModule']->saveData($data, $id);
                
                $d_action = 'New Task added. <a href="'.$this->data['_cancel'].'/edit/'.$id.'" class="fs-6 text-gray-800 text-hover-primary fw-bold">View Task</a>';		
                $logged_in = $this->data['adminDetails'];
                $employeeid = $logged_in->employee_id;
                $insertactivity['employee'] = $employeeid;
                $insertactivity['d_action'] = $d_action;
                $insertactivity['created']  = date("Y-m-d H:i:s");
                activitylogs($insertactivity,'insert');
                         
                //$this->data['session']->setFlashdata('success','Data has successfully created');

            }
        }
    }  
}