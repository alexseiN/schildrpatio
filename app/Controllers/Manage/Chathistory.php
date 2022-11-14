<?php

namespace App\Controllers\Manage; 
use App\Core\Admincontroller;
use App\Models\backend\Chathistorymodel;

class Chathistory extends Admincontroller {
    public $_table_names = 'supportvisitors';			//set table name
    public $_subView = 'admin/chathistory/';		//set subview
    public $_redirect = '/chathistory';				//set controller link
    

    protected $CurrencyModel;

    public function __construct(){
        parent::__construct();

        $this->ChathistoryModel = new Chathistorymodel();

        $this->data['ThisModule'] = $this->ChathistoryModel;
        $this->data['CommanModel'] = $this->CommanModel;

        //set left menu active on admin dashboard
        $this->data['active'] = 'From Website';
        $this->data['withoutlang'] = 1;
        
        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';

	$this->data['branches'] = $this->CommanModel->get_lang('branches',false,false,array(),'connlang_id',FALSE);

	foreach($this->data['branches'] as $branch){
	    $branches[$branch->id] = $branch->name;
	}
	// for Global List
	$this->data['_table_names'] = $this->_table_names;
	$this->data['_subView'] = $this->_subView;
	$this->data['_parent_folder'] = 'CRM';
	$Statusoptions = array("1"=>"Viewed","0"=>"Waiting");

	$adminDetails = $this->data['adminDetails'];
	if($adminDetails->role == 'Branch Admin'){
	    $setarray = array();
	}
	else {
	    $setarray = array(
						"name"=>"branch_id_TYPEwhere",
						"type"=>"select",
						"options"=>$branches,
						"events"=>array(
						    "onchange"=>"getData('no')"
						)
					    );
	}
	
	$columns_with_filteroptions = array(
			"IP" => array(
				    "name"=>"ipaddress_TYPElike",
				    "type"=>"text",
				    "events"=>array(
					"onkeyup"=>"getData('no')"
				    )
				),
			"Name" => array(
					"name"=>"c_name_TYPElike",
					"type"=>"text",
					"events"=>array(
					    "onkeyup"=>"getData('no')"
					)					
				    ),
			"Branch" => $setarray,
			"Email" => array(
						"name"=>"c_email_TYPElike",
					"type"=>"text",
					"events"=>array(
					    "onkeyup"=>"getData('no')"
					)
					    ),
			"Phone" => array(
						"name"=>"c_phone_TYPElike",
					"type"=>"text",
					"events"=>array(
					    "onkeyup"=>"getData('no')"
					)
					    ),
			"Received Time" => array(
						"name"=>"created_at_TYPEwheredaterange",
						"type"=>"datetimerange",
						"events"=>array(
						    "onkeyup"=>"getData('no')"
						)
					    ),
			"View Messages" => array(),
		    );
	$where = array();
        $blank_array = array();
        $adminDetails = $this->data['adminDetails'];
        if($adminDetails->role == 'Branch Admin'){
            $loggedinuseremp = $this->data['adminDetails']->employee_id;
	    $thisEmployee = get_langer('employees',false,$loggedinuseremp);
	    $thisbranch = get_langer('branches',$this->data['admin_lang'],$thisEmployee->branch_id);          
            $where = array("branch_id"=>$thisbranch->id);
        }
	$total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$blank_array,$blank_array,'',0,'all',true);

	$main_array_view = array(
			    "view_data"=>array(
				"view_folder"=>"chathistory",
				"columns_with_filteroptions"=>$columns_with_filteroptions,
				"total_count"=>$total_count,
				"is_filter"=>"yes",
				"default_sort"=>"created_at",
				"default_sort_type"=>"DESC",
				"add_link"=>array("status"=>"no","link"=>"")
			    )
			);
			
	$this->data['viewdata'] = $main_array_view;
	// end for Global List
	$this->data['_title_call'] = 'Chat History';
    }

    
     
    
     public function index()
    {
        //set title
        $this->data['name'] = 'Chat History';
        $this->data['title'] = $this->data['name']; 
        echo view('admin/_layout_main',$this->data);
    }
    
    function messages($id) {
	error_reporting(1);
	$this->data['name'] = 'View '.$this->data['_title_call'];
	$this->data['title'] = $this->data['name'];

	$dataall = $this->data;
        $adminrole = $dataall['adminDetails']->role;
        $mainadminempid = $dataall['adminDetails']->employee_id;
        $receiver_id = $id;
        $last_id = '0';
        $is_show = false;
        if($adminrole == "Global Admin") {
            $is_show = true;
        }
        $username = $dataall['adminDetails']->username;
        $userid = $dataall['adminDetails']->id;
        $emp_id = $dataall['adminDetails']->employee_id;

	

        $lasttime = '';
	$limitset = 'all';

        $get_localchat = $this->CommanModel->get_visitorschat($receiver_id,$limitset,$last_id,'fromadmin','chathistory');
	$visitordetails = $this->CommanModel->get_supportvisitors('id',$id,'chathistory');
	if(count($visitordetails)<=0){
	    return redirect()->to($dataall['_cancel']);
	}
	//$this->data['visitordetails'] = $visitordetails[0];
	$this->data['cname'] = "Chat with ".$visitordetails->c_name;

	$chat_data_array = array();
	
	if(count($get_localchat)>0) {
            $get_localchat = array_values(array_reverse($get_localchat));
            foreach($get_localchat as $chat){
                $timeset = get_time_ago(strtotime($chat->created_at));
                if($chat->sender_id != '0'){
                    $get_user = $this->CommanModel->get_supportvisitors('id',$chat->sender_id,'chathistory');
                    $userdata = $get_user[0];                    
                    $addclass= 'justify-content-start';
                    $showusername = $userdata->c_name;
		    $setimage = '<span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">'.$showusername[0].'</span>';
                }
                else {
                    $get_user = $this->CommanModel->get_user($chat->sender_admin);
                    $userdata = $get_user[0];
		    $admin_role = $userdata->role;
                    $setimage = '';
                    if($userdata->imageurl != '' && file_exists($_SERVER['DOCUMENT_ROOT'].'/assets/uploads/employees/small/'.$userdata->imageurl)) {
                        $setimage = '<img alt="Pic" src="/assets/uploads/employees/small/'.$userdata->imageurl.'">';
		    }
                    $addclass= 'justify-content-start';
                    if($chat->sender_admin == '0'){
                        $addclass= 'justify-content-start';
                        $showusername = 'BOT ( Auto Reply )';
                    }
                    else if($chat->sender_admin == $emp_id){
			
                        $addclass= 'justify-content-end';
                        $showusername = 'You';
                    }
                    else if($admin_role == "Global Admin"){
                        $showusername = $userdata->UserName." ( Main Admin )";
                    }
                    else {
                        $showusername = $userdata->UserName;
                        if($is_show){
                            $showusername = $userdata->UserName.' ( '.$userdata->b_name.' )';
                        }
                    }
		    if($setimage == ''){
			$setimage = '<span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">'.$showusername[0].'</span>';
		    }
                }		
		$chat_data_array[] = array(
		    "id" => $chat->id,
		    "addclass" => $addclass,
		    "data-user" => $chat->sender_id,
		    "image" => $setimage,
		    "showusername" => $showusername,
		    "time" => strtotime($chat->created_at),
		    "body" => makeUrltoLink($chat->s_content)
		);
                $lasttime = date("d M, H:iA",strtotime($chat->created_at));
            }
        }
	
	$this->data['receiver_id'] = $receiver_id;
	$this->data['is_view'] = true;
	$this->data['chat_data_array'] = $chat_data_array;
	
	if(!empty($this->postdata)) {            
            $postdata = $this->postdata;
	    if($postdata['is_ajax'] == 'yes'){
		$this->data['chathtml'] = view('admin/includes/common/chatbodyinner',$this->data);
		$jsonrerurn = json_encode(array(
			    "status" => 'success',
			    "html" => $this->data['chathtml'],
			    "lasttime"=>$lasttime
			));
		$json_pretty = json_encode(json_decode($jsonrerurn), JSON_PRETTY_PRINT);
		echo $json_pretty;die;
	    }
	}
	else {
	    $this->data['chathtml'] = view('admin/includes/common/chatbody',$this->data);
	    if(count($chat_data_array)<=0){
		$this->data['session']->setFlashdata('error',"No data found.");    
		return redirect()->to($dataall['_cancel']);
	    }
	    $this->data['subview'] = $this->_subView.'messages'; 
	    echo view('admin/_layout_main',$this->data);
	}        
    }  
}
