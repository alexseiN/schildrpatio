<?php  

namespace App\Controllers; 
use App\Core\Maincontroller;


class Home extends Maincontroller
{
    public $_subView = 'main/';
	public function __construct(){
	    parent::__construct();
	    
		
		//helper('cookie');
		
		
		$this->data['mainimage'] = $this->CommanModel->get_lang('sliders', $this->data['curlangid'] , NULL, array(), 'connlang_id', true);
		
		        
     
		$this->data['ogimage'] = 'assets/uploads/sliders/thumbnails/'.$this->data['mainimage']->image;
		
		
		$this->data['sliders'] = $this->CommanModel->get_lang('sliders', $this->data['curlangid'] , NULL, array(), 'connlang_id', false);
        $this->data['projects'] = $this->CommanModel->projects_rand6('project', $this->data['curlangid'] , NULL, array('enabled'=>1), 'connlang_id', false);
        
		
	}

	public function index()
	{
	    $data = $this->data;
		
        echo view($this->_subView.'index',$data);
	}
	
	public function noprice()
	{
	    $data = $this->data;
		
        echo view($this->_subView.'noprice',$data);
	}
	
	
	

    public function startchat() {
	if ($this->request->getMethod() == "post") {
	    $dataall = $this->data;
	    $post_data = $this->request->getPost();
	    $randomstring = randomstring(16);
	    $ipinfo = $dataall['ipinfo'];
	    $branch = $dataall['nearbranch'];
	    $currenttime = timenowzone();
	    $current_visitor_stats = $dataall['current_visitor'];
	    
	    $send_data = array("ipaddress"=>$ipinfo->ip,"branch_id"=>$branch['id'],"c_name"=>$post_data['name'],"c_email"=>$post_data['emailaddress'],"c_phone"=>$post_data['phone'],"created_at"=>$currenttime,"randomstring"=>$randomstring);	    
	    if(count($current_visitor_stats)>0){
		$id = $current_visitor_stats[0]->id;
	    }
	    else {		
		$id = $this->CommanModel->supportvisitors($send_data);
		$_SESSION['randomstring_frontuser'] = $randomstring;
	    }
	    $jsonrerurn = json_encode(array(
		"status" => 'success',
		"data" => array("id"=>$id),
	    ));
	    $json_pretty = json_encode(json_decode($jsonrerurn), JSON_PRETTY_PRINT);
	    echo $json_pretty;
	}
    }
    public function send_front_chat_insert(){
	if ($this->request->getMethod() == "post") {
	    $dataall = $this->data;	    
	    $ipinfo = $dataall['ipinfo'];
	    $ipaddress = $ipinfo->ip;
	    $post_data = $this->request->getPost();
	    $text = isset($post_data['text'])?$post_data['text']:'0';
	    $current_visitor_stats = $dataall['current_visitor'];
	    if(count($current_visitor_stats)>0){
		$id = $current_visitor_stats[0]->id;
		$branchid = $current_visitor_stats[0]->branch_id;
		$currenttime = timenowzone();
		$send_data = array("sender_id"=>$id,"receiver_id"=>'0',"s_content"=>$text,"branch_id"=>$branchid,"is_read"=>'0',"sent_from"=>'1',"created_at"=>$currenttime);
		$checkvisitor = $this->CommanModel->add_visitorchat($send_data);
		$status = 'Success';
	    }
	    else {
		$status = 'Error';
	    }
	    
	    $jsonrerurn = json_encode(array(
		"status" => $status,
	    ));
	    $json_pretty = json_encode(json_decode($jsonrerurn), JSON_PRETTY_PRINT);
	    echo $json_pretty;    
	}
    }
    
    public function send_front_chat($limit) {
	if ($this->request->getMethod() == "post") {
	    $dataall = $this->data;	    
	    $ipinfo = $dataall['ipinfo'];
	    $branch = $dataall['nearbranch']['id'];
	    $ipaddress = $ipinfo->ip;
	    $post_data = $this->request->getPost();
	    $last_id = isset($post_data['lastid'])?$post_data['lastid']:'0';
	    $htmlshow = '';
	    
	    $current_visitor_stats = $dataall['current_visitor'];
	    if(count($current_visitor_stats)>0){
		$id = $current_visitor_stats[0]->id;
	    }
	    $ids = array();
	    $get_visitorschat = $this->CommanModel->get_visitorschat($id,$limit,$last_id,'fromfront');
	    if(count($get_visitorschat)>0) {
		$get_visitorschat = array_values(array_reverse($get_visitorschat));
		foreach($get_visitorschat as $chat){
		    
		    if($chat->sender_id == $id && $chat->sent_from == '1') {
			$htmlshow .= '<li class="is-user animation" data-sender-from="front" id="front_chat_'.$chat->id.'" data-id="'.$chat->id.'" data-sender="you_'.$chat->sender_id.'" >
					    <p class="chatbot__message">
						'.makeUrltoLink($chat->s_content).'
					    </p>
					    <span class="chatbot__arrow chatbot__arrow--right"></span>
					</li>';
		    }
		    else {
			$htmlshow .= '<li class="is-ai animation" data-sender-from="admin" id="front_chat_'.$chat->id.'" data-id="'.$chat->id.'" data-sender="ad_'.$chat->sender_id.'" >
			<div class="is-ai__profile-picture">
			    <i class="fas fa-user-tie icon-avatar"></i>
			</div>
			<span class="chatbot__arrow chatbot__arrow--left "></span>
			<p class="chatbot__message">'.makeUrltoLink($chat->s_content).'</p>
		    </li>';
		    }
		    $ids[] = $chat->id;
    
		}
	    }
	    $jsonrerurn = json_encode(array(
		"status" => 'success',
		"data" => array("html"=>$htmlshow,"rows"=>$ids),
	    ));
	    $json_pretty = json_encode(json_decode($jsonrerurn), JSON_PRETTY_PRINT);
	    echo $json_pretty; 
	}
    }


    public function send_front_chat_test($limit) {
	$dataall = $this->data;	    
	    $ipinfo = $dataall['ipinfo'];
	    $branch = $dataall['nearbranch']['id'];
	    $ipaddress = $ipinfo->ip;
	    $post_data = $this->request->getPost();
	    $last_id = isset($post_data['lastid'])?$post_data['lastid']:'0';
	    $htmlshow = '';
	    
	    $checkvisitor = $this->CommanModel->get_supportvisitors('ip',$ipinfo->ip);
	    if(count($checkvisitor)>0){
		$id = $checkvisitor[0]->id;
	    }
	    
	    $get_visitorschat = $this->CommanModel->get_visitorschat($id,$limit,$lastid,'fromfront');
	    
	    if(count($get_visitorschat)>0) {
		$get_visitorschat = array_values(array_reverse($get_visitorschat));
		foreach($get_visitorschat as $chat){
		    
		    if($chat->sender_id == $id && $chat->sent_from == '1') {
			$htmlshow .= '<li class="is-user animation" data-id="'.$chat->id.'" data-sender="you_'.$chat->sender_id.'" >
					    <p class="chatbot__message">
						'.$chat->sender_id.'
					    </p>
					    <span class="chatbot__arrow chatbot__arrow--right"></span>
					</li>';
		    }
		    else {
			$htmlshow .= '<li class="is-ai animation" data-id="'.$chat->id.'" data-sender="ad_'.$chat->sender_id.'" >
			<div class="is-ai__profile-picture">
			    <i class="fas fa-user-tie icon-avatar"></i>
			</div>
			<span class="chatbot__arrow chatbot__arrow--left "></span>
			<p class="chatbot__message">'.$chat->sender_id.'</p>
		    </li>';
		    }
    
		}
	    }
	    $jsonrerurn = json_encode(array(
		"status" => 'success',
		"data" => array("html"=>$htmlshow),
	    ));
	    $json_pretty = json_encode(json_decode($jsonrerurn), JSON_PRETTY_PRINT);
	    echo $json_pretty;
    }

    function checkbot(){
	if ($this->request->getMethod() == "post") {
	    $dataall = $this->data;	    
	    $ipinfo = $dataall['ipinfo'];
	    $ipaddress = $ipinfo->ip;
	    $post_data = $this->request->getPost();
	    $lastrowtext = strtolower(trim($post_data['lastrowtext']));

	    $curlangcode = ($dataall['curlangcode'] == 'home')?'tr':$dataall['curlangcode'];


	    
	    $botsarray = chtbotautoresponse($curlangcode);
	    $texttoshow = '';
	    $visitorid = 0;
	    if (array_key_exists($lastrowtext,$botsarray)){
		$texttoshow = $botsarray[$lastrowtext];
	    }
	    $status = 'Error';
	    if($texttoshow != ''){
		$current_visitor_stats = $dataall['current_visitor'];
		if(count($current_visitor_stats)>0){
		    $id = $current_visitor_stats[0]->id;
		    $branchid = $current_visitor_stats[0]->branch_id;
		    $currenttime = timenowzone();
		    $send_data = array("sender_id"=>'0',"receiver_id"=>$id,"branch_id"=>$branchid,"s_content"=>$texttoshow,"is_read"=>'0',"sent_from"=>'0',"sender_admin"=>'0',"created_at"=>$currenttime);
		    $visitorid = $this->CommanModel->add_visitorchat($send_data);
		    $status = 'Success';
		}
		else {
		    $status = 'Error';
		}
	    }	
	    
	    $jsonrerurn = json_encode(array(
		"status" => $status,
		"visitorid"=>$visitorid,
		"curlangcode"=>$curlangcode,
		"ipinfo" => $ipinfo
	    ));
	    $json_pretty = json_encode(json_decode($jsonrerurn), JSON_PRETTY_PRINT);
	    echo $json_pretty;
	}
    }
}
