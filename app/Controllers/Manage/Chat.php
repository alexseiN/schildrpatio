<?php

namespace App\Controllers\Manage; 

use App\Core\Admincontroller;



class Chat extends Admincontroller {
    public function __construct(){
        parent::__construct();
        $this->data['active'] = 'chat';
    }

    public function index() {

        $dataall = $this->data;
        $adminrole = $dataall['adminDetails']->role;
        //pp($dataall['adminDetails']);
        $is_show = false;
        if($adminrole == "Global Admin") {
            $is_show = true;
        }

        $username = $dataall['adminDetails']->username;
        $userid = $dataall['adminDetails']->id;
        $emp_id = $dataall['adminDetails']->employee_id;
        $limitset = '20';
        $lasttime = '';
        $chat_data_array = array();
        $get_localchat = $this->CommanModel->get_localchat($limitset);        
        if(count($get_localchat)>0) {
            $get_localchat = array_values(array_reverse($get_localchat));
            foreach($get_localchat as $chat){
                $timeset = get_time_ago(strtotime($chat->created_at));
                $get_user = $this->CommanModel->get_user($chat->sender_id);
                $userdata = $get_user[0];
                $admin_role = $userdata->role;
                $setimage = '';
                if($userdata->imageurl != '' && file_exists($_SERVER['DOCUMENT_ROOT'].'/assets/uploads/employees/small/'.$userdata->imageurl)) {
                    $setimage = '<img alt="Pic" src="/assets/uploads/employees/small/'.$userdata->imageurl.'">';
                }
                $addclass= 'justify-content-start';
                if($chat->sender_id == '0'){
                    $addclass= 'justify-content-start';
                    $showusername = 'BOT ( Auto Reply )';
                }
                else if($chat->sender_id == $emp_id){
                    $addclass= 'justify-content-end';
                    //$showusername = ($is_show)?$userdata->UserName.' ( '.$userdata->b_name.' )':'You';
                    $showusername = 'You';
                }
                else {
                    $showusername = ($is_show)?$userdata->UserName.' ( '.$userdata->b_name.' )':$userdata->UserName;
                }
                if($setimage == ''){
                    $setimage = '<span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">'.$showusername[0].'</span>';
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
        //pp($chat_data_array);
        $this->data['name'] = 'Chat';
        $this->data['title'] = $this->data['name'];
        $this->data['is_view'] = false;
        $this->data['cname'] = 'Group chat ( All )';
        $this->data['chat_data_array'] = $chat_data_array;
        $this->data['chathtml'] = view('admin/includes/common/chatbody',$this->data);
        $this->data['subview'] = 'admin/chat';
        $this->data['lasttime'] = $lasttime;
        $this->data['all_data'] = $this->data;
        echo view('admin/_layout_main',$this->data);
    }

    public function loadlocalchat($limitset = 20) {
        error_reporting(0);
        $dataall = $this->data;
        $adminrole = $dataall['adminDetails']->role;
        $post_data = $this->request->getPost();
        $last_id = isset($post_data['lastid'])?$post_data['lastid']:'0';

        if($last_id == 'new'){
            $last_id = '0';
        }
        
        $is_show = false;
        if($adminrole == "Global Admin") {
            $is_show = true;
        }

        $username = $dataall['adminDetails']->username;
        $userid = $dataall['adminDetails']->id;
        $emp_id = $dataall['adminDetails']->employee_id;
        $chat_data_array = array();
        $lasttime = '';
        $get_localchat = $this->CommanModel->get_localchat($limitset,$last_id);
        if(count($get_localchat)>0) {
            $get_localchat = array_values(array_reverse($get_localchat));
            foreach($get_localchat as $chat){
                $timeset = get_time_ago(strtotime($chat->created_at));
                $get_user = $this->CommanModel->get_user($chat->sender_id);
                $userdata = $get_user[0];
                $admin_role = $userdata->role;
                $setimage = '';
                if($userdata->imageurl != '' && file_exists($_SERVER['DOCUMENT_ROOT'].'/assets/uploads/employees/small/'.$userdata->imageurl)) {
                    $setimage = '<img alt="Pic" src="/assets/uploads/employees/small/'.$userdata->imageurl.'">';
                }
                $addclass= 'justify-content-start';
                if($chat->sender_id == '0'){
                    $addclass= 'justify-content-start';
                    $showusername = 'BOT ( Auto Reply )';
                }
                else if($chat->sender_id == $emp_id){
                    $addclass= 'justify-content-end';
                    //$showusername = ($is_show)?$userdata->UserName.' ( '.$userdata->b_name.' )':'You';
                    $showusername = 'You';
                }
                else {
                    $showusername = ($is_show)?$userdata->UserName.' ( '.$userdata->b_name.' )':$userdata->UserName;
                }
                

                if($setimage == ''){
                    $setimage = '<span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">'.$showusername[0].'</span>';
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
        $this->data['is_view'] = false;
        $this->data['chat_data_array'] = $chat_data_array;
        $this->data['chathtml'] = view('admin/includes/common/chatbodyinner',$this->data);
        //pp($this->data['chathtml']);
		$jsonrerurn = json_encode(array(
			    "status" => 'success',
			    "html" => $this->data['chathtml'],
			    "lasttime"=>$lasttime
		));        
		$json_pretty = json_encode(json_decode($jsonrerurn), JSON_PRETTY_PRINT);
		echo $json_pretty;        
    }
    
        
    public function loadlocalonetoone($limitset = 20) {
        $dataall = $this->data;
        $adminrole = $dataall['adminDetails']->role;
        $post_data = $this->postdata;
        $receiver_id = $post_data['receiver_id'];
        $last_id = isset($post_data['lastid'])?$post_data['lastid']:'0';

        if($last_id == 'new'){
            $last_id = '0';
        }
        
        $is_show = false;
        if($adminrole == "Global Admin") {
            $is_show = true;
        }

        $username = $dataall['adminDetails']->username;
        $userid = $dataall['adminDetails']->id;
        $emp_id = $dataall['adminDetails']->employee_id;
        $chat_data_array = array();
        $lasttime = '';
        //pp($post_data);
        $get_localchat = $this->CommanModel->get_localonetoone($emp_id,$receiver_id,$last_id,$limitset);
        //pp($receiver_id);
        if(count($get_localchat)>0) {
            $get_localchat = array_values(array_reverse($get_localchat));
            foreach($get_localchat as $chat){
                $timeset = get_time_ago(strtotime($chat->created_at));
                $get_user = $this->CommanModel->get_user($chat->sender_id);
                $userdata = $get_user[0];
                $admin_role = $userdata->role;
                $setimage = '';
                if($userdata->imageurl != '' && file_exists($_SERVER['DOCUMENT_ROOT'].'/assets/uploads/employees/small/'.$userdata->imageurl)) {
                    $setimage = '<img alt="Pic" src="/assets/uploads/employees/small/'.$userdata->imageurl.'">';
                }
                $addclass= 'justify-content-start';
                if($chat->sender_id == '0'){
                    $addclass= 'justify-content-start';
                    $showusername = 'BOT ( Auto Reply )';
                }
                else if($chat->sender_id == $emp_id){
                    $addclass= 'justify-content-end';
                    //$showusername = ($is_show)?$userdata->UserName.' ( '.$userdata->b_name.' )':'You';
                    $showusername = 'You';
                }
                else {
                    $showusername = ($is_show)?$userdata->UserName.' ( '.$userdata->b_name.' )':$userdata->UserName;
                }
                

                if($setimage == ''){
                    $setimage = '<span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">'.$showusername[0].'</span>';
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

        $this->data['is_view'] = false;
            $this->data['chat_data_array'] = $chat_data_array;
            $this->data['chathtml'] = view('admin/includes/common/chatbodyinner',$this->data);
        
        //pp($this->data['chathtml']);
		$jsonrerurn = json_encode(array(
			    "status" => 'success',
			    "html" => $this->data['chathtml'],
			    "lasttime"=>$lasttime
		));        
		$json_pretty = json_encode(json_decode($jsonrerurn), JSON_PRETTY_PRINT);
		echo $json_pretty;        
    }
    
    public function localchatpost() {
        if ($this->admin_request->getMethod() == "post") {
            $post_data = $this->postdata;
            $content = $post_data['text'];
            $loadedchat = $post_data['loadedchat'];
            $dataall = $this->data;
            $adminrole = $dataall['adminDetails']->role;
            $is_show = false;
            if($adminrole == "Global Admin") {
                $is_show = true;
            }
            $username = $dataall['adminDetails']->username;
            $userid = $dataall['adminDetails']->id;
            $emp_id = $dataall['adminDetails']->employee_id;
            $currenttime = timenowzone();
            if($loadedchat == 'Groupchat'){
                $send_data = array("sender_id"=>$emp_id,"s_content"=>$content,"created_at"=>$currenttime);
                $this->CommanModel->add_localchat($send_data);
            }
            else {
                $send_data = array("sender_id"=>$emp_id,"receiver_id"=>$loadedchat,"s_content"=>$content,"created_at"=>$currenttime);
                $this->CommanModel->add_localontoonechat($send_data);
            }
        }             
    }


    public function visitorchatpost() {
        if ($this->admin_request->getMethod() == "post") {
            $post_data = $this->postdata;
            $content = $post_data['text'];
            $loadedchat = $post_data['loadedchat'];
            $dataall = $this->data;
            $adminrole = $dataall['adminDetails']->role;
            $is_show = false;
            if($adminrole == "Global Admin") {
                $is_show = true;
            }
            $username = $dataall['adminDetails']->username;
            $userid = $dataall['adminDetails']->id;
            $emp_id = $dataall['adminDetails']->employee_id;
            $currenttime = timenowzone();

            $visitorresult = get_support_visitor_by_id($loadedchat);
            
            $send_data = array("sender_id"=>'0',"receiver_id"=>$loadedchat,"branch_id"=>$visitorresult[0]->branch_id,"sender_admin"=>$emp_id,"sent_from"=>'0',"s_content"=>$content,"created_at"=>$currenttime);
            $this->CommanModel->add_visitorchat($send_data);
        }             
    }

    public function searchcontent() {
        if ($this->admin_request->getMethod() == "post") {
            $post_data = $this->postdata;
            $checkinputsearch = $post_data['checkinputsearch'];
            $loadedchat = $post_data['loadedchat'];
            $dataall = $this->data;
            $adminrole = $dataall['adminDetails']->role;
            $is_show = false;
            if($adminrole == "Global Admin") {
                $is_show = true;
            }
            $username = $dataall['adminDetails']->username;
            $userid = $dataall['adminDetails']->id;
            $emp_id = $dataall['adminDetails']->employee_id;
            $chat_data_array = array();
            if($loadedchat == 'Groupchat'){
                $searchresult = $this->CommanModel->searchcontent_chat($checkinputsearch);
            }
            else {
                $searchresult = $this->CommanModel->search_onetoone_content_chat($emp_id,$loadedchat,$checkinputsearch);
            }
            if(count($searchresult)>0){               
                $get_localchat = array_values(array_reverse($searchresult));
                foreach($get_localchat as $chat){
                    $timeset = get_time_ago(strtotime($chat->created_at));
                    $get_user = $this->CommanModel->get_user($chat->sender_id);
                    $userdata = $get_user[0];
                    $setimage = '';
                    if($userdata->imageurl != '' && file_exists($_SERVER['DOCUMENT_ROOT'].'/assets/uploads/employees/small/'.$userdata->imageurl)) {
                        $setimage = '<img alt="Pic" src="/assets/uploads/employees/small/'.$userdata->imageurl.'">';
                    }
                    $addclass= 'justify-content-start';
                    if($chat->sender_id == '0'){
                        $addclass= 'justify-content-start';
                        $showusername = 'BOT ( Auto Reply )';
                    }
                    else if($chat->sender_id == $emp_id){
                        $addclass= 'justify-content-end';
                        //$showusername = ($is_show)?$userdata->UserName.' ( '.$userdata->b_name.' )':'You';
                        $showusername = 'You';
                    }
                    else {
                        $showusername = ($is_show)?$userdata->UserName.' ( '.$userdata->b_name.' )':$userdata->UserName;
                    }
                    if($setimage == ''){
                        $setimage = '<span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">'.$showusername[0].'</span>';
                    }
                    $text = makeUrltoLink($chat->s_content);
                    $keyword = $checkinputsearch;
                    $s_content = $this->highlightText($text, $keyword);

                    $chat_data_array[] = array(
                        "id" => $chat->id,
                        "addclass" => $addclass,
                        "data-user" => $chat->sender_id,
                        "image" => $setimage,
                        "showusername" => $showusername,
                        "time" => strtotime($chat->created_at),
                        "body" => $s_content
                    );
                }
                
            }
            //$this->data['receiver_id'] = $receiver_id;
            $this->data['is_view'] = false;
            $this->data['chat_data_array'] = $chat_data_array;
            $this->data['chathtml'] = view('admin/includes/common/chatbodyinner',$this->data);
            
            
            $jsonrerurn = json_encode(array(
                "status" => 'success',
                "html" => $this->data['chathtml'],
            ));
            $json_pretty = json_encode(json_decode($jsonrerurn), JSON_PRETTY_PRINT);
            echo $json_pretty; 
        }             
    }


    public function searchcontentvisitor() {
        if ($this->admin_request->getMethod() == "post") {
            $post_data = $this->postdata;
            $checkinputsearch = $post_data['checkinputsearch'];
            $loadedchat = $post_data['loadedchat'];
            $dataall = $this->data;
            $adminrole = $dataall['adminDetails']->role;
            $is_show = false;
            if($adminrole == "Global Admin") {
                $is_show = true;
            }
            $username = $dataall['adminDetails']->username;
            $userid = $dataall['adminDetails']->id;
            $emp_id = $dataall['adminDetails']->employee_id;
            $chat_data_array = array();
            $searchresult = $this->CommanModel->search_visitor_content_chat($loadedchat,$checkinputsearch);
            if(count($searchresult)>0){               
                $get_localchat = array_values(array_reverse($searchresult));
                
                foreach($get_localchat as $chat){                    
                    $timeset = get_time_ago(strtotime($chat->created_at));                    
                    if($chat->sender_id != '0'){
                        $get_user = $this->CommanModel->get_supportvisitors('id',$chat->sender_id);
                        $userdata = $get_user[0];
                        $addclass= 'justify-content-start';
                        $showusername = $userdata->c_name;
                        $setimage = '<span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">'.$showusername[0].'</span>';
                    }
                    else {
                        $setimage = '';
                        $get_user = $this->CommanModel->get_user($chat->sender_admin);
                        if($get_user){
                            $userdata = $get_user[0];
                            if($userdata->imageurl != '' && file_exists($_SERVER['DOCUMENT_ROOT'].'/assets/uploads/employees/small/'.$userdata->imageurl)) {
                                $setimage = '<img alt="Pic" src="/assets/uploads/employees/small/'.$userdata->imageurl.'">';
                            }
                        }                        
                        $addclass= 'justify-content-start';
                        if($chat->sender_id == '0'){
                            $addclass= 'justify-content-start';
                            $showusername = 'BOT ( Auto Reply )';
                        }
                        else if($chat->sender_id == $emp_id){
                
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
                    
                    $text = makeUrltoLink($chat->s_content);
                    $keyword = $checkinputsearch;
                    $s_content = $this->highlightText($text, $keyword);
                    $chat_data_array[] = array(
                        "id" => $chat->id,
                        "addclass" => $addclass,
                        "data-user" => $chat->sender_id,
                        "image" => $setimage,
                        "showusername" => $showusername,
                        "time" => strtotime($chat->created_at),
                        "body" => $s_content
                    );
                    $lasttime = date("d M, H:iA",strtotime($chat->created_at));
                }
                
            }
            $this->data['receiver_id'] = $loadedchat;
                $this->data['chat_data_array'] = $chat_data_array;
                $this->data['chathtml'] = view('admin/includes/common/chatbodyinner',$this->data);
           
            $jsonrerurn = json_encode(array(
                "status" => 'success',
                "html" => $this->data['chathtml'],
            ));
            $json_pretty = json_encode(json_decode($jsonrerurn), JSON_PRETTY_PRINT);
            echo $json_pretty; 
        }             
    }


    function highlightText($text, $keyword) {
       $color = "red";
       $background = "yellow";
       $keyword = explode(" ", trim($keyword));
       foreach($keyword as $word) {
        $highlightWord =  "<i style='background:".$background.";color:".$color."'>" . $word . "</i>";
        $text = preg_replace ("/" . trim($word) . "/i", $highlightWord, $text);
      }
      return $text;
    }
    
    public function modal() {
        echo view('admin/_layout_modal', $this->data);
    }


    public function loadsvisitorchat($limitset = 200) {
        $dataall = $this->data;
        $adminrole = $dataall['adminDetails']->role;
        $mainadminempid = $dataall['adminDetails']->employee_id;
        $post_data = $this->postdata;
        $receiver_id = $post_data['receiver_id'];
        //$receiver_id = 5;
        $last_id = isset($post_data['lastid'])?$post_data['lastid']:'0';
        $is_show = false;
        if($adminrole == "Global Admin") {
            $is_show = true;
        }

        $username = $dataall['adminDetails']->username;
        $userid = $dataall['adminDetails']->id;
        $emp_id = $dataall['adminDetails']->employee_id;
        $chat_data_array = array();
        $lasttime = '';
        //pp($post_data);
        $get_localchat = $this->CommanModel->get_visitorschat($receiver_id,$limitset,$last_id,'fromadmin');
        //pp($get_localchat);
        if(count($get_localchat)>0) {
            $get_localchat = array_values(array_reverse($get_localchat));
            foreach($get_localchat as $chat){
                $timeset = get_time_ago(strtotime($chat->created_at));
                if($chat->sender_id != '0'){
                    $get_user = $this->CommanModel->get_supportvisitors('id',$chat->sender_id);
                    $userdata = $get_user[0];
                    $addclass= 'justify-content-start';
                    $showusername = $userdata->c_name;
                    $setimage = '<span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">'.$showusername[0].'</span>';
                }
                else {
                    $get_user = $this->CommanModel->get_user($chat->sender_admin);
                    $userdata = $get_user[0];
                    $admin_role = $userdata->role;
                    //pp($userdata);
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
        $this->data['is_view'] = false;
        $this->data['chat_data_array'] = $chat_data_array;
        $this->data['chathtml'] = view('admin/includes/common/chatbodyinner',$this->data);
        $jsonrerurn = json_encode(array(
		    "status" => 'success',
		    "html" => $this->data['chathtml'],
            "lasttime"=>$lasttime
		));
		$json_pretty = json_encode(json_decode($jsonrerurn), JSON_PRETTY_PRINT);
		echo $json_pretty;        
    }

	function msgunreadcounter(){
        $checkdata = msgunreadcounterhelper();        
        $jsonrerurn = json_encode(array(
			"status" => 'success',
			"total" => $checkdata
		));
		echo $jsonrerurn;die;
	}
	
    function checkunreadmessage(){
        if ($this->admin_request->getMethod() == "post") {
            error_reporting(0);
            $post_data = $this->postdata;            
            $chatid = $post_data['chatid'];
            $chattype = $post_data['chattype'];
            $e_emp_id = $post_data['e_emp_id'];
            $e_branch_id = $post_data['e_branch_id'];
            
            $dataall = $this->data;
            $adminrole = $dataall['adminDetails']->role;
            $mainadminempid = $dataall['adminDetails']->employee_id;

            $is_show = false;
            if($adminrole == "Global Admin") {
                $is_show = true;
                $e_branch_id = '0';
            }
            
            
            
            $groupunread = $this->CommanModel->findunreadmessage('localchat',$chatid,$e_emp_id,$e_branch_id,$chattype);
            $adminunread = $this->CommanModel->findunreadmessage('localontoonechat',$chatid,$e_emp_id,$e_branch_id,$chattype);
            $frontunread = $this->CommanModel->findunreadmessage('visitorschat',$chatid,$e_emp_id,$e_branch_id,$chattype);
            


            $totalgroup = count($groupunread);
            $grouptimelatest = '';
            if($totalgroup>0){
                $grouptimelatest = date("d M, H:iA",strtotime($groupunread[0]->created_at));
            }

            $admincount = array();
            
            $admincount_time = array();
            
            if(count($adminunread)>0){
                foreach($adminunread as $r_unread){
                    $admincount[$r_unread->sender_id] += 1;
                    if (!array_key_exists($r_unread->sender_id,$admincount_time)){
                        $admincount_time[$r_unread->sender_id] = date("d M, H:iA",strtotime($r_unread->created_at));
                    }
                }              
            }
            //$total_back = $totalgroup+array_sum($admincount);
            $total_back = array_sum($admincount);


            $frontcount = array();
            $frontcount_time = array();
            $previousdate = strtotime(timenowzone(). ' -1 days');
            //pp($frontunread,false);
            if(count($frontunread)>0){
                foreach($frontunread as $f_unread){
                    if(strtotime($f_unread->created_at)>$previousdate){
                        $sender = $f_unread->sender_id;
                        $frontcount[$sender] += 1;
                        if (!array_key_exists($f_unread->sender_id,$frontcount_time)){
                            $frontcount_time[$f_unread->sender_id] = date("d M, H:iA",strtotime($f_unread->created_at));
                        }
                    }
                }
            }
            $total_front = array_sum($frontcount);

            $total_back_array_flip = array();
            $total_back_array_flip_time = array();
            $total_back_array_flip_time_new = array();
            $username = array();
            if(count($adminunread)>0){
                $adminunreadflip = array_values(array_reverse($adminunread));
                foreach($adminunreadflip as $rr_unread){
                    $total_back_array_flip["userli_".$rr_unread->sender_id] += 1;                    
                    if (!array_key_exists($rr_unread->sender_id,$total_back_array_flip_time)){
                        $getuser = $this->CommanModel->get_user($rr_unread->sender_id);
                        if(count($getuser)>0){
                            $total_back_array_flip_time["userli_".$rr_unread->sender_id] = strtotime($rr_unread->created_at);
                            $total_back_array_flip_time_new["userli_".$rr_unread->sender_id] = date("d M, H:iA",strtotime($rr_unread->created_at));
                            $username["userli_".$rr_unread->sender_id] = $getuser[0];
                        }
                    }
                }           
                
            }



            $total_front_array_flip = array();
            $total_front_array_flip_time = array();
            $total_front_array_flip_time_new = array();
            $username_front = array();
            
            if(count($frontunread)>0){
                $frontunreadflip = array_values(array_reverse($frontunread));
                foreach($frontunreadflip as $rr_unread){
                    $total_front_array_flip["frontuserli_".$rr_unread->sender_id] += 1;                    
                    if (!array_key_exists($rr_unread->sender_id,$total_front_array_flip_time)){
                        $getuser_front = $this->CommanModel->get_supportvisitorsin_chat("id",$rr_unread->sender_id);
                        ///$getuser_front = $this->CommanModel->get_supportvisitors("id",$rr_unread->sender_id);
                        $total_front_array_flip_time["frontuserli_".$rr_unread->sender_id] = strtotime($rr_unread->created_at);
                        $total_front_array_flip_time_new["frontuserli_".$rr_unread->sender_id] = date("d M, H:iA",strtotime($rr_unread->created_at));
                        $username_front["frontuserli_".$rr_unread->sender_id] = $getuser_front[0];
                    }
                } 
            }


            
            $jsonrerurn = json_encode(array(
                "status" => 'success',
                "total_front" => $total_front,
                "total_back" => $total_back,
                "total_front_array" => $frontcount,
                "total_back_array" => $admincount,
                "total_back_array_flip" => $total_back_array_flip,
                "total_back_array_flip_time" => $total_back_array_flip_time,
                "total_back_array_flip_time_new" => $total_back_array_flip_time_new,
                "total_front_time" => $frontcount_time,
                "total_back_time" => $admincount_time,
                "totalgroup"=>$totalgroup,
                "grouptimelatest"=>$grouptimelatest,
                "username"=>$username,
                "total_front_array_flip" => $total_front_array_flip,
                "total_front_array_flip_time" => $total_front_array_flip_time,
                "total_front_array_flip_time_new" => $total_front_array_flip_time_new,
                "username_front"=>$username_front,
                //"previousdate"=> date("Y-m-d H:i:s",strtotime(timenowzone(). ' -1 days'))             
            ));
            echo $jsonrerurn; 
        } 
    }


    function checkunreadmessagetest(){

            $post_data = $this->request->getPost();            
            $chatid = $post_data['chatid'];
            $chattype = $post_data['chattype'];
            $e_emp_id = $post_data['e_emp_id'];
            $e_branch_id = $post_data['e_branch_id'];

            $chatid = "Groupchat";
            $chattype = "adminlocal";
            $e_branch_id = "21";
            $e_emp_id = "26";

            
            $dataall = $this->data;
            $adminrole = $dataall['adminDetails']->role;
            $mainadminempid = $dataall['adminDetails']->employee_id;

            $is_show = false;
            if($adminrole == "Global Admin") {
                $is_show = true;
                $e_branch_id = '0';
            }
            
            
            
            $groupunread = $this->CommanModel->findunreadmessage('localchat',$chatid,$e_emp_id,$e_branch_id,$chattype);
            $adminunread = $this->CommanModel->findunreadmessage('localontoonechat',$chatid,$e_emp_id,$e_branch_id,$chattype);
            $frontunread = $this->CommanModel->findunreadmessage('visitorschat',$chatid,$e_emp_id,$e_branch_id,$chattype);
            


            $totalgroup = count($groupunread);
            $grouptimelatest = '';
            if($totalgroup>0){
                $grouptimelatest = date("d M, H:iA",strtotime($groupunread[0]->created_at));
            }

            $admincount = array();
            
            $admincount_time = array();
            
            if(count($adminunread)>0){
                foreach($adminunread as $r_unread){
                    $admincount[$r_unread->sender_id] += 1;
                    if (!array_key_exists($r_unread->sender_id,$admincount_time)){
                        $admincount_time[$r_unread->sender_id] = date("d M, H:iA",strtotime($r_unread->created_at));
                    }
                }              
            }
            //$total_back = $totalgroup+array_sum($admincount);
            $total_back = array_sum($admincount);


            $frontcount = array();
            $frontcount_time = array();
            
            if(count($frontunread)>0){
                foreach($frontunread as $f_unread){
                    $frontcount[$f_unread->sender_id] += 1;
                    if (!array_key_exists($f_unread->sender_id,$frontcount_time)){
                        $frontcount_time[$f_unread->sender_id] = date("d M, H:iA",strtotime($f_unread->created_at));
                    }
                }
            }
            $total_front = array_sum($frontcount);

            $total_back_array_flip = array();
            $total_back_array_flip_time = array();
            $total_back_array_flip_time_new = array();
            $username = array();
            if(count($adminunread)>0){
                $adminunreadflip = array_values(array_reverse($adminunread));
                foreach($adminunreadflip as $rr_unread){
                    $total_back_array_flip["userli_".$rr_unread->sender_id] += 1;                    
                    if (!array_key_exists($rr_unread->sender_id,$total_back_array_flip_time)){
                        $getuser = $this->CommanModel->get_user($rr_unread->sender_id);
                        $total_back_array_flip_time["userli_".$rr_unread->sender_id] = strtotime($rr_unread->created_at);
                        $total_back_array_flip_time_new["userli_".$rr_unread->sender_id] = date("d M, H:iA",strtotime($rr_unread->created_at));
                        $username["userli_".$rr_unread->sender_id] = $getuser[0];
                    }
                }           
                
            }



            $total_front_array_flip = array();
            $total_front_array_flip_time = array();
            $total_front_array_flip_time_new = array();
            $username_front = array();
            
            if(count($frontunread)>0){
                $frontunreadflip = array_values(array_reverse($frontunread));
                foreach($frontunreadflip as $rr_unread){
                    $total_front_array_flip["frontuserli_".$rr_unread->sender_id] += 1;                    
                    if (!array_key_exists($rr_unread->sender_id,$total_front_array_flip_time)){
                        $getuser_front = $this->CommanModel->get_supportvisitors("id",$rr_unread->sender_id);
                        $total_front_array_flip_time["frontuserli_".$rr_unread->sender_id] = strtotime($rr_unread->created_at);
                        $total_front_array_flip_time_new["frontuserli_".$rr_unread->sender_id] = date("d M, H:iA",strtotime($rr_unread->created_at));
                        $username_front["frontuserli_".$rr_unread->sender_id] = $getuser_front[0];
                    }
                } 
            }


            
            $jsonrerurn = json_encode(array(
                "status" => 'success',
                "total_front" => $total_front,
                "total_back" => $total_back,
                "total_front_array" => $frontcount,
                "total_back_array" => $admincount,
                "total_back_array_flip" => $total_back_array_flip,
                "total_back_array_flip_time" => $total_back_array_flip_time,
                "total_back_array_flip_time_new" => $total_back_array_flip_time_new,
                "total_front_time" => $frontcount_time,
                "total_back_time" => $admincount_time,
                "totalgroup"=>$totalgroup,
                "grouptimelatest"=>$grouptimelatest,
                "username"=>$username,
                "total_front_array_flip" => $total_front_array_flip,
                "total_front_array_flip_time" => $total_front_array_flip_time,
                "total_front_array_flip_time_new" => $total_front_array_flip_time_new,
                "username_front"=>$username_front,              
            ));
            echo $jsonrerurn; 
        
    }


    function checkonline(){
        if ($this->admin_request->getMethod() == "post") {       
            $post_data = $this->postdata;               
            $chatid = $post_data['chatid'];
            $chattype = ($post_data['chattype'] == "adminlocal")?"0":"1";
            $e_emp_id = $post_data['e_emp_id'];
            $e_branch_id = $post_data['e_branch_id'];
            
            $getonlineusers = $this->CommanModel->getonlineusers($chattype);
            $all_users = array();
            $from_array = array();
            //pp($getonlineusers);
            if(count($getonlineusers)>0){
                foreach($getonlineusers as $users){
                    if($e_emp_id != $users->user_id){
                        array_push($all_users,$users->user_id);
                        array_push($from_array,$users->from);
                    }
                }
            }
            

            $jsonrerurn = json_encode(array(
                "status" => 'success',
                "all_users" => $all_users,
                "from_array" => $from_array,
                "total_online" => count($all_users)                          
            ));
            echo $jsonrerurn;
        }
    }

    function typeStatus(){
        if ($this->admin_request->getMethod() == "post") {
            $post_data = $this->postdata;
            $chatid = $post_data['loadedchat'];
            $chattype = ($post_data['loadedchattype'] == "adminlocal")?"0":"1";
            $e_emp_id = $post_data['e_emp_id'];
            $e_branch_id = $post_data['e_branch_id'];
            $action = ($post_data['action'] == "startedTyping")?"0":"1";

            $dataall = $this->data;
            $adminrole = $dataall['adminDetails']->role;
            $mainadminempid = $dataall['adminDetails']->employee_id;

            $to = $post_data['loadedchat'];
            $timenow = timenowzone();
            if($chattype == '0' && $chatid != 'Groupchat') {
                $typingstatus = $this->CommanModel->typingstatus($e_emp_id,$to);                
                if(count($typingstatus)>0){
                    $typeset = "update";
                    $id = $typingstatus[0]->id;
                    $data = array("t_status"=>$action,"updated_at"=>$timenow);                   
                }
                else {
                    $typeset = "insert";
                    $id = 0;
                    $data = array("from"=>$e_emp_id,"to"=>$to,"typefrom"=>$chattype,"t_status"=>$action,"created_at"=>$timenow);
                }                
                $this->CommanModel->settyping($id,$typeset,$data);
            }
        }
    }

    function checktypestatus(){
        if ($this->admin_request->getMethod() == "post") {
            $post_data = $this->postdata;
            $chatid = $post_data['chatid'];
            $chattype = ($post_data['chattype'] == "adminlocal")?"0":"1";
            $e_emp_id = $post_data['e_emp_id'];
            $e_branch_id = $post_data['e_branch_id'];

            $output = array();

            $tstatus = 'Stoppedtyping';
            $typingstatus = $this->CommanModel->typingstatus($chatid,$e_emp_id,'yes');                
            if(count($typingstatus)>0){
                //pp($typingstatus);
                $t_status = $typingstatus[0]->t_status;
                if($t_status == '0') {
                    $tstatus = 'Startedtyping';
                }
            }
            $jsonrerurn = json_encode(array(
                "status" => 'success',
                "tstatus" => $tstatus                    
            ));
            echo $jsonrerurn;            
        }
    }

}
