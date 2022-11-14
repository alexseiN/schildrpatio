<?php

namespace App\Controllers\Manage; 

use App\Core\Admincontroller;


class Dashboard extends Admincontroller {

	public $_redirect = '/dashboard';			//set controller link
    public function __construct(){
        parent::__construct();
        $this->data['active'] = 'dashboard';
        $this->data['_cancel']  = $this->data['admin_link'].$this->_redirect;
    }

    public function index() {
        $dataall = $this->data;
        $this->data['title'] = 'Dashboard';
        $adminrole = $dataall['adminDetails']->role;        
        $is_show = false;
        if($adminrole == "Global Admin") {
            $is_show = true;
        }		
        $username = $dataall['adminDetails']->username;
        $userid = $dataall['adminDetails']->id;
        $emp_id = $dataall['adminDetails']->employee_id;

        $this->data['pastsevenday'] =  strtotime(datetoday().'-7 days');
		$this->data['currentdate']  =  strtotime(datetoday());     

		$this->data['gettasks'] =  $this->CommanModel->get_emp_tasks_filter('tasks',$this->data['blank_array'],$this->data['blank_array'],$this->data['blank_array'],'updated',0,5,false,$this->data['adminDetails']->employee_id);
        $this->data['pdcats'] = $this->CommanModel->get_lang('pdcats',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);
        $this->data['branches'] = $this->CommanModel->get_lang('branches',false,false,array(),'connlang_id',FALSE);
        $this->data['subview'] = 'admin/dashboard/index';
        $this->data['all_data'] = $this->data;
        echo view('admin/_layout_main',$this->data);
    }

    function ajaxchart(){
		error_reporting(0);
		$row = 0;
		$total_array = array();		
		if(!empty($this->postdata)){
			$postdata = $this->postdata;	
			$buyer 		= $postdata['buyer'];
			$phone 		= $postdata['phone'];
			$product 	= $postdata['product'];
			$from 		= $postdata['from'];
			$branch 	= $postdata['branch'];
			$sent 		= $postdata['sent'];
			$sender 	= $postdata['sender'];
			$id 		= $postdata['id'];
			$date_1 	= strtotime(date("Y-m-d",strtotime($postdata['date_1']))." 00:00:00");
			$date_2 	= strtotime(date("Y-m-d",strtotime($postdata['date_2']))." 23:59:59");

			$period_inv = date_range(date("Y-m-d",$date_1), date("Y-m-d",$date_2),'+1 day','Y-m-d' );

			$where_inv = array(
				'parent_id'=>0,
				'created >= '=> $date_1,
				'created <= '=> $date_2
			);
				
			$bsenders = $this->CommanModel->get_lang('employees',false,false,array('branch_id'=>$branch,'rep'=>1),'connlang_id',FALSE);
			
			
			
			$adminDetails = $this->data['adminDetails'];
			$loggedinuseremp = $this->data['adminDetails']->employee_id;
			if($adminDetails->role == 'Branch Admin'){				
				$where_inv['employee']=$loggedinuseremp;      
			}
			else {
				if ($from) {$where_inv['employee']=$from;} else {unset($where_inv['employee']);}
			}
			
			
			
			if ($id) {$where_inv['id']=$id;} else {unset($where_inv['id']);}
			if ($product) {$where_inv['product_category']=$product;} else {unset($where_inv['product_category']);}
			if ($sender) {$where_inv['sender']=$sender;} else {unset($where_inv['sender']);}
			if ($sent == 'd') {$where_inv['sendtime']=null;} else
			if ($sent == 's') {$where_inv['sendtime <>']=null;} else {unset($where_inv['sendtime']);}
			
			$like_inv = array(
				'buyer'=>$buyer,
				'phone'=>$phone
			);
			
			if($branch){ 
				foreach($bsenders as $bsend) {
					array_push($havingIn_inv,$bsend->id);
				}
			}
			else {
				$havingIn_inv = false;
			}

			//pp($where_inv);
			
			$invoices = $this->CommanModel->getDatamwithlimit('setproject',$where_inv,$havingIn_inv,$like_inv,'created',$row,'all');
			$total_inv_array = array();
			foreach($invoices as $invoice){
				$created = date("Y-m-d",$invoice->created);			
				if(in_array($created,$period_inv)){
					$total_inv_array[$created] += 1;
				}
			}
			foreach($period_inv as $row){
				if(isset($total_inv_array[$row])){
					$total_array['INVOICE']['Invoices']['data'][] = [$total_inv_array[$row]];
				}
				else {
					$total_array['INVOICE']['Invoices']['data'][] = [0];
				}
			}   
			
		}



		$date_1 	= strtotime(date("Y-m-d",strtotime($_POST['date_CRM_1']))." 00:00:00");
		$date_2 	= strtotime(date("Y-m-d",strtotime($_POST['date_CRM_2']))." 23:59:59");



		//$pastsevenday = date("Y-m-d",strtotime(datetoday().'-7 days'))." 00:00:00";
		//$currentdate = datetoday()." 23:59:59";
		
		//$date_1 = strtotime($pastsevenday);
		//$date_2 = strtotime($currentdate);
				
		$where = array(
			'parent_id'=>0,
			'created >= '=> $date_1,
			'created <= '=> $date_2
		);
		$where_2 = array(
			'created >= '=> $date_1,
			'created <= '=> $date_2
		);
		$where_3 = array(
			'created_at >= '=> date("Y-m-d H:i:s",$date_1),
			'created_at <= '=> date("Y-m-d H:i:s",$date_2)
		);
		$havingIn = array();
		$like = array();

		if($adminDetails->role == 'Branch Admin'){
			$thisEmployee = get_langer('employees',false,$loggedinuseremp);
			$thisbranch = get_langer('branches',$this->data['admin_lang'],$thisEmployee->branch_id);          	
			$where['branch_id']=$thisbranch->id;
			$where_2['branch']=$thisbranch->id;
			$where_3['branch_id']=$thisbranch->id;      
		}
		

		$period = date_range(date("Y-m-d",$date_1), date("Y-m-d",$date_2),'+1 day','Y-m-d' );
					
		$quotes = $this->CommanModel->getDatamwithlimit('quotes',$where,$havingIn,$like,'created',$row,'all');
		
		if($adminDetails->role == 'Branch Admin'){
			$becomedealer = array();			
		}
		else {
			$becomedealer = $this->CommanModel->getDatamwithlimit('becomedealer',$where,$havingIn,$like,'created',$row,'all');
		}
		
		$fromcontact = $this->CommanModel->getDatamwithlimit('fromcontact',$where,$havingIn,$like,'created',$row,'all');
		$fromhome = $this->CommanModel->getDatamwithlimit('fromhome',$where_2,$havingIn,$like,'created',$row,'all');
		$supportvisitors = $this->CommanModel->getDatamwithlimit('supportvisitors',$where_3,$havingIn,$like,'created_at',$row,'all');
		
		
		$total_q_array = array();
		foreach($quotes as $quote){
			$created = date("Y-m-d",$quote->created);
			if(in_array($created,$period)){
				$total_q_array[$created] += 1;
			}
		}

		$total_bd_array = array();
		if(count($becomedealer)>0){
			foreach($becomedealer as $bdealer){
				$created = date("Y-m-d",$bdealer->created);
				if(in_array($created,$period)){
					$total_bd_array[$created] += 1;
				}
			}
		}

		$total_fc_array = array();
		foreach($fromcontact as $fcontact){
			$created = date("Y-m-d",$fcontact->created);
			if(in_array($created,$period)){
				$total_fc_array[$created] += 1;
			}
		}

		$total_fh_array = array();
		foreach($fromhome as $frhome){
			$created = date("Y-m-d",$frhome->created);
			if(in_array($created,$period)){
				$total_fh_array[$created] += 1;
			}
		}

		$total_sv_array = array();
		foreach($supportvisitors as $supportvisitor){
			$created = date("Y-m-d",strtotime($supportvisitor->created_at));
			if(in_array($created,$period)){
				$total_sv_array[$created] += 1;
			}
		}

		foreach($period as $row){
			$total_array['CRM']['Get_Quote']['name'] = 'Get Quote';
			
			if($adminDetails->role != 'Branch Admin'){
				$total_array['CRM']['Become_a_Dealer']['name'] = 'Become a Dealer';
			}
			
			$total_array['CRM']['Contact_Us']['name'] = 'Contact Us';
			$total_array['CRM']['Footer_Subscribers']['name'] = 'Footer Subscribers';
			$total_array['CRM']['Online_Chat_History']['name'] = 'Online Chat History';
			$total_array['INVOICE']['Invoices']['name'] = 'Invoices';
			
			if(isset($total_q_array[$row])){
				$total_array['CRM']['Get_Quote']['data'][] = [$total_q_array[$row]];
			}
			else {
				$total_array['CRM']['Get_Quote']['data'][] = [0];
			}
			
			if($adminDetails->role != 'Branch Admin'){
				if(isset($total_bd_array[$row])){
					$total_array['CRM']['Become_a_Dealer']['data'][] = [$total_bd_array[$row]];
				}
				else {
					$total_array['CRM']['Become_a_Dealer']['data'][] = [0];
				}
			}
			
			if(isset($total_fc_array[$row])){
				$total_array['CRM']['Contact_Us']['data'][] = [$total_fc_array[$row]];
			}
			else {
				$total_array['CRM']['Contact_Us']['data'][] = [0];
			}
			
			if(isset($total_fh_array[$row])){
				$total_array['CRM']['Footer_Subscribers']['data'][] = [$total_fh_array[$row]];
			}
			else {
				$total_array['CRM']['Footer_Subscribers']['data'][] = [0];
			}
			
			if(isset($total_sv_array[$row])){
				$total_array['CRM']['Online_Chat_History']['data'][] = [$total_sv_array[$row]];
			}
			else {
				$total_array['CRM']['Online_Chat_History']['data'][] = [0];
			}
		}

		
		
		$main_array = array("implodedates_inv"=>$period_inv,"implodedates"=>$period,"CRM"=>array_values($total_array['CRM']),"INVOICE"=>array_values($total_array['INVOICE']));
		//pp($main_array);
		$jsonrerurn = json_encode($main_array);
		echo $jsonrerurn;die;
	}

	public function modal() {
        echo view('admin/_layout_modal', $this->data);
    }
}
