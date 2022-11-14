<?php

namespace App\Models; 

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class Commanmodel extends Model {
	protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
	protected $_timestamps = TRUE;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    } 
    
    
    public function sendmail($id,$to,$fields) {
    
    
    //Send mail


			    
			   
				$email_data = $this->get_by('email',array('id'=>$id),false,false,true);
				
				if ($fields) {
				    foreach ($fields as $key=>$field) {
				
				      $email_data->subject = str_replace('{'.$key.'}', $field, $email_data->subject);
				      $email_data->message = str_replace('{'.$key.'}', $field, $email_data->message);
				    }
				
				}
		
				$email = \Config\Services::email();
				
        
                $email->setFrom('info@schildr.com', 'Schildr Information Center','info@schildr.com');
                $email->setTo($to); 
                
               
                
                $email->setSubject($email_data->subject);
                $email->setMessage($email_data->message);
                
                
                		
				 if ($email->send()) 
		{
            echo 'Email successfully sent';
        } 
		else 
		{
            $data = $email->printDebugger();
            print_r($data);
        }
                
    
    
    
}


public function calculation($projection,$width,$frontheight,$backheight,$pillar) { 
	    
	    
	    $projection = $projection/1000;
	    $width = $width/1000;
	    $frontheight = $frontheight/1000;
	    $backheight = $backheight/1000;
	    
	 //   echo '<hr>';
	    
	    
	    
	    if ($backheight < 3.3) {$height = 3;} else {$height = 6;}
	        
	        $g7 = $height; 
	        $h7 = ceil($width) +1;
	        
	        $i7 = 1;
	        $j7 = $projection * $width * $i7;
	    
	        $products =  $this->get_lang('locproducts', 8 , NULL, array(), 'connlang_id', false);
	    
	        $alltotalprice = 0;
	        $alltotalweight = 0;
	    
	    
	        foreach ($products as $product) {
	        
	        
	        $quantity = $g7*$pillar*$i7;
	        if($product->code == '560-6001' || $product->code == '560-6003' || $product->code == '560-6105' || $product->code == '560-6201' || $product->code == '560-6104' || $product->code == '560-6106' || $product->code == '560-5102' || $product->code == '3202137') {$quantity = $width*$i7;}
	        if($product->code == '560-1101' || $product->code == '560-6101' || $product->code == '560-6102' || $product->code == '560-6107') {$quantity = $h7*$projection*$i7;}
	        if($product->code == 'SD-9664') {$quantity = $projection*2;}
	        if($product->code == '560-5101' || $product->code == '7523901') {$quantity = $width*2;}
	        if($product->code =='3202220') { $quantity = ($width*$i7*3)+($h7*$projection*$i7*4); }
	        if($product->code == '1609706' || $product->code == '1609707') {$quantity = $i7*2;}
	        if($product->code == '9524301' || $product->code == '8003601') {$quantity = $i7*$pillar;}
	        
	        
	        $totalkg = $quantity*$product->mtkg;
	     
	        if($product->mtkg == '') {$totalkg = $quantity;}
	        
	        
	        
	        
	        
	        
	        $totalprice = $product->nprice*$totalkg;
	        
	        //$datax['price_'.$product->code] = $totalprice;
	        
	        $alltotalprice = $alltotalprice + round($totalprice, 2);
	        
	        if($product->code == '1609706' || $product->code == '1609707' || $product->code == '9524301' || $product->code == '8003601' || $product->code == '7523901') {$totalkg = 0;} 
	        $alltotalweight = $alltotalweight + $totalkg;
	        

	        
	        
	        
	    }
	    
	    

	 
	    
	    
	    
	    
	    $glassing = $projection * $width * $i7 * 10.8 * 3.5; //echo $glass.'<br>';
                        
        $sqft = $j7*10.8;
                        
        $pandp = $sqft * 1; //echo $pandp.'<br>';
        $woodbox = 0; //echo $woodbox.'<br>';
        $transport = 250; //echo $woodbox.'<br>';
        $manufacturing = $j7*10.8*2;
                        
        $alltotalprice13 = $alltotalprice*1.3 ;
                        
        $extra = ($alltotalprice13 + $glassing + $pandp + $manufacturing) * 0.03; //echo $extra.'<br>'; 
        $extra = round($extra,2);
                        
        $income = ($alltotalprice13 + $glassing + $pandp + $manufacturing + $extra) * 0.7; //echo $income.'<br>';
        $income = round($income,2);
        $office = ($alltotalprice13 + $glassing + $pandp + $manufacturing + $transport + $income) * 0.03;
        $office = round($office,2);
        
        if ($projection>3.5) {$galvanized = $h7*30;} else {$galvanized = 0;}

        $grandtotal = $alltotalprice13 + $glassing + $pandp + $woodbox + $transport + $manufacturing + $galvanized + $extra + $income + $office;
	    
	    
	    
	    $datax['gt'] = $grandtotal;
	    
	    $datax['p'] = $alltotalprice13;
	    $datax['w'] = $alltotalweight;
	    
	    $datax['led'] = ($h7-2)*2*35+220;
	    
	    $install[4]=1150;
	    $install[5]=1300;
	    $install[6]=1450;
        $install[7]=1750;
        $install[8]=1950;
        $install[9]=2250;
        $install[10]=2450;
        $install[11]=2650;
        $install[12]=2850;
        $install[13]=3100;

        $datax['install'] =  $install[$h7];
 

	    
	    
	    
	    return $datax;
	    
	}




    public function updateloginsts($from,$id){
	$db = db_connect();
	$buildquery = "select * from `login_status` where `user_id` = '".$id."' && `from` = '".$from."'";		
	$query = $db->query($buildquery);
	$rows_counter = $query->getNumRows();
	$output = array();
	$timenowzone = timenowzone();
	if($rows_counter>0){
	    $builneqquery = 'update `login_status` set `updated_time` = "'.$timenowzone.'" where `user_id` = "'.$id.'" && `from` = "'.$from.'"';
	    $db->query($builneqquery);
	    $output = $query->getResult();
	    return $output;
	}
	else {
	    $data = array("user_id"=>$id,"from"=>$from,"updated_time"=>$timenowzone);
	    $builneqquery = $this->db->table('login_status');
	    $uid = $builneqquery->insert($data);
	    return $uid;
	}
    }

    public function addfeatures($data){
	$db = db_connect();
	$builneqquery = $this->db->table('features');
	$uid = $builneqquery->insert($data);
	return $this->db->insertID();
    
    }

    public function getonlineusers(){
	$db = db_connect();
	$timenowzone = strtotime(timenowzone());
	$buildquery = "select `user_id`,`from` from `login_status` where `updated_time` > now() - interval 5 minute";
	$query = $db->query($buildquery);
	$rows_counter = $query->getNumRows();
	$output = array();	
	if($rows_counter>0){
	    $output = $query->getResult();	    
	}
	return $output;
    }
    
    public function get_localchat($limitset,$lastid=0){
	$db = db_connect();

	/*if($receiver > '0'){
	    $builneqquery = 'update `localchat` set `is_read` = "1" where 1';
	    $db->query($builneqquery);
	}*/

	
	if($lastid > 0) {
	    $buildquery = "select * from `localchat` where `id` > '".$lastid."' order by id DESC limit ".$limitset;
	}
	else {
	    $buildquery = "select * from `localchat` order by id DESC limit ".$limitset;
	}	
	$query = $db->query($buildquery);
	$rows_counter = $query->getNumRows();
	$output = array();
	if($rows_counter>0){
	    $output = $query->getResult();
	}
	return $output;
    }

    public function get_localonetoone($sender,$receiver,$last_id = '0',$limit){
	$db = db_connect();
	if($receiver > '0'){
	    $builneqquery = 'update `localontoonechat` set `is_read` = "1" where `receiver_id` = "'.$sender.'"';
	    $db->query($builneqquery);
	}
	
	if($last_id > '0') {
	    $buildquery = "select * from `localontoonechat` where ((`sender_id` = '".$sender."' && `receiver_id` = '".$receiver."') || (`receiver_id` = '".$sender."' && `sender_id` = '".$receiver."')) && `id` > '".$last_id."' order by id DESC limit ".$limit;
	}
	else {
	    $buildquery = "select * from `localontoonechat` where ((`sender_id` = '".$sender."' && `receiver_id` = '".$receiver."') || (`receiver_id` = '".$sender."' && `sender_id` = '".$receiver."')) order by id DESC limit ".$limit;
	}	
	//pp($buildquery);	
	$query = $db->query($buildquery);
	$rows_counter = $query->getNumRows();
	$output = array();
	if($rows_counter>0){
	    $output = $query->getResult();
	}
	return $output;
    }
    

    public function searchcontent_chat($checkinputsearch){
	$db = db_connect();
	$buildquery = "select * from `localchat` where `s_content` like '%".$checkinputsearch."%' order by id DESC";	
	$query = $db->query($buildquery);
	$rows_counter = $query->getNumRows();
	$output = array();
	if($rows_counter>0){
	    $output = $query->getResult();
	}
	return $output;
    }

    public function search_visitor_content_chat($receiver_id,$checkinputsearch){
	$db = db_connect();
	$buildquery = "select * from `visitorschat` where `s_content` like '%".$checkinputsearch."%' && ((`receiver_id` = '".$receiver_id."' && `sent_from` = '0') || (`sender_id` = '".$receiver_id."' && `sent_from` = '1')) order by id DESC";	
	$query = $db->query($buildquery);
	$rows_counter = $query->getNumRows();
	$output = array();
	if($rows_counter>0){
	    $output = $query->getResult();
	}
	return $output;
    }
    

    public function search_onetoone_content_chat($sender,$receiver,$checkinputsearch){
	$db = db_connect();
	$buildquery = "select * from `localontoonechat` where ((`sender_id` = '".$sender."' && `receiver_id` = '".$receiver."') || (`receiver_id` = '".$sender."' && `sender_id` = '".$receiver."')) && `s_content` like '%".$checkinputsearch."%' order by id DESC";	
	$query = $db->query($buildquery);
	$rows_counter = $query->getNumRows();
	$output = array();
	if($rows_counter>0){
	    $output = $query->getResult();
	}
	return $output;
    }

    public function supportvisitors($data){		
	$builder = $this->db->table('supportvisitors');
	$id = $builder->insert($data);
	//$id = $builder->getInsertID();
	return $id;
    }

    public function get_supportvisitors($type,$value,$purpose = ''){
	$db = db_connect();
	$today_start = date("Y-m-d ")."00:00:00";
	$today_end =  date("Y-m-d ")."23:59:59";
	$betweenwhere = ' && sv.created_at between "'.$today_start.'" and "'.$today_end.'"';
	$buildquery = "select sv.*,brn.name as b_name from `supportvisitors` as sv left join `branches` as brn on brn.id = sv.branch_id where ";
	if($type == 'ip'){
	    $buildquery .= 'sv.ipaddress = "'.$value.'"';
	}
	if($type == 'id'){
	    $buildquery .= 'sv.id = "'.$value.'"';
	}
	if($purpose == '') {
	    $buildquery .= $betweenwhere;
	}
	
	$query = $db->query($buildquery);
	$rows_counter = $query->getNumRows();
	$output = array();
	if($rows_counter>0){
	    $output = $query->getResult();
	}
	return $output;
    }


    public function get_supportvisitorsin_chat($type,$value){
	$db = db_connect();
	$today_start = date("Y-m-d ")."00:00:00";
	$today_end =  date("Y-m-d ")."23:59:59";
	//$betweenwhere = ' && sv.created_at between "'.$today_start.'" and "'.$today_end.'"';

	$buildquery = "select sv.*,brn.name as b_name from `supportvisitors` as sv left join `branches` as brn on brn.id = sv.branch_id where ";
	if($type == 'ip'){
	    $buildquery .= 'sv.ipaddress = "'.$value.'"';
	}
	if($type == 'id'){
	    $buildquery .= 'sv.id = "'.$value.'"';
	}
	///$buildquery .= $betweenwhere; 
	$query = $db->query($buildquery);
	$rows_counter = $query->getNumRows();
	$output = array();
	if($rows_counter>0){
	    $output = $query->getResult();
	}
	return $output;
    }

    public function get_support_visitor_by_sessionid($array){
	$db = db_connect();
	date_default_timezone_set("Asia/Baku");
	$today_start = date("Y-m-d ")."00:00:00";
	$today_end =  date("Y-m-d ")."23:59:59";
	$count = 0;
	$addwhere = ' ( ';
	foreach($array as $key=>$value){
	    $addwhere .= 'sv.'.$key.' = "'.$value.'"';	    
	    $count++;
	    if($count<count($array)){
		$addwhere .= ' && ';
	    }
	}
	$addwhere .= ' ) ';
	
	$betweenwhere = ' && sv.created_at between "'.$today_start.'" and "'.$today_end.'"';
	$buildquery = "select sv.*,brn.name as b_name from `supportvisitors` as sv left join `branches` as brn on brn.id = sv.branch_id where ".$addwhere.$betweenwhere;
	//echo $buildquery;die;
	$query = $db->query($buildquery);
	$rows_counter = $query->getNumRows();
	$output = array();
	if($rows_counter>0){
	    $output = $query->getResult();
	}
	return $output;
    }

    public function add_visitorchat($data){
	$builder = $this->db->table('visitorschat');
	$builder->insert($data);
    }

    public function get_visitorschat($receiver_id,$limitset,$lastid=0,$checkadmin = 'front',$purpose = ''){
	$db = db_connect();

	if($receiver_id > '0' && $checkadmin == 'fromadmin'){
	    $builneqquery = 'update `visitorschat` set `is_read` = "1" where `sender_id` = "'.$receiver_id.'"';
	    $db->query($builneqquery);
	}

	
	$today_start = date("Y-m-d ")."00:00:00";
	$today_end =  date("Y-m-d ")."23:59:59";
	$betweenwhere = ' && `created_at` between "'.$today_start.'" and "'.$today_end.'"';
	if($lastid > '0') {
	    $buildquery = "select * from `visitorschat` where  `id` > '".$lastid."' ".$betweenwhere." && ((`receiver_id` = '".$receiver_id."' && `sent_from` = '0') || (`sender_id` = '".$receiver_id."' && `sent_from` = '1')) order by id DESC limit ".$limitset;
	}
	else if($lastid == '0' && $purpose == 'chathistory') {
	    $buildquery = "select * from `visitorschat` where  ((`receiver_id` = '".$receiver_id."' && `sent_from` = '0') || (`sender_id` = '".$receiver_id."' && `sent_from` = '1')) order by id DESC";
	}
	else {
	    $buildquery = "select * from `visitorschat` where ((`receiver_id` = '".$receiver_id."' && `sent_from` = '0') || (`sender_id` = '".$receiver_id."' && `sent_from` = '1')) ".$betweenwhere."  order by id DESC limit ".$limitset;
	}
	
	//pp($buildquery);
	$query = $db->query($buildquery);
	$rows_counter = $query->getNumRows();
	$output = array();
	if($rows_counter>0){
	    $output = $query->getResult();
	}
	return $output;
    }

    public function typingstatus($from,$to,$checktype = 'no'){
	$db = db_connect();
	$buildquery = "select `id`,`t_status` from `typeStatus` where `from` = '".$from."' && `to` = '".$to."'";
	if($checktype == 'yes'){
	    $buildquery .= ' && `updated_at` > now() - interval 1 minute';
	}
	$query = $db->query($buildquery);
	$rows_counter = $query->getNumRows();
	$output = array();
	if($rows_counter>0){
	    $output = $query->getResult();
	}
	return $output;
    }


    public function settyping($id,$typeset,$data){
	$table = 'typeStatus';
	$builder = $this->db->table($table);
	if($typeset == 'update'){	    
	    $builder->set($data)->where('id', $id)->update();
	}
	else {
	    $builder->insert($data);
	}
    }
    
    public function add_localchat($data){		
	$builder = $this->db->table('localchat');
	$builder->insert($data);
    }
    
    public function add_localontoonechat($data){		
	$builder = $this->db->table('localontoonechat');
	$builder->insert($data);
    }


    public function batchupdatedata($tablename,$data,$key){		
	$builder = $this->db->table($tablename);
	$builder->updateBatch($data, $key);
    }

    

    public function get_user($id){
	$db = db_connect();
	$buildquery = "select ad.*,emp.image as imageurl,CONCAT(emp.first_name,' ', emp.last_name) as UserName,brnch.name as b_name from `admin` as ad left join `employees` as emp on emp.id = ad.employee_id left join `branches` as brnch on brnch.id = emp.branch_id where ad.employee_id = '".$id."'";
	$query = $db->query($buildquery);
	$rows_counter = $query->getNumRows();
	$output = array();
	if($rows_counter>0){
	    $output = $query->getResult();
	}
	return $output;
    }



    function findunreadmessage($table,$chatid,$e_emp_id,$e_branch_id,$chattype){
	$previousdate = date("Y-m-d H:i:s",strtotime(timenowzone(). ' -1 days'));

	$today_start = datetoday()." 00:00:00";
	$today_end =  datetoday()." 23:59:59";
	//$betweenwhere = ' && sv.created_at between "'.$today_start.'" and "'.$today_end.'"';
	
	
	$db = db_connect();
	if($table == 'localchat'){
	    $buildquery = "select `id`,`created_at` from $table where `is_read` = '0'";
	}
	else if($table == 'localontoonechat'){
	    if($chattype == 'adminlocal' && $chatid != 'Groupchat') {
		$buildquery = "select `sender_id`,`created_at` from $table where `sender_id` != '".$chatid."' && `receiver_id` = '".$e_emp_id."' && `is_read` = '0'";
	    }
	    else {
		$buildquery = "select `sender_id`,`created_at` from $table where `receiver_id` = '".$e_emp_id."' && `is_read` = '0'";
	    }
	}
	else if($table == 'visitorschat'){
	    if($chattype == 'visitor') {
		if($e_branch_id == '0'){
		    $buildquery = "select `sender_id`,`created_at` from $table where `sender_id` != '".$chatid."' && `is_read` = '0' && `sent_from` = '1'";
		}
		else {
		    $buildquery = "select `sender_id`,`created_at` from $table where `sender_id` != '".$chatid."' && `branch_id` = '".$e_branch_id."' && `is_read` = '0' && `sent_from` = '1'";
		}
	    }
	    else {
		if($e_branch_id == '0'){
		    $buildquery = "select `sender_id`,`created_at` from $table where `is_read` = '0' && `sent_from` = '1'";
		}
		else {
		    $buildquery = "select `sender_id`,`created_at` from $table where `branch_id` = '".$e_branch_id."' && `is_read` = '0' && `sent_from` = '1'";
		}
	    }
	    $buildquery .= ' && `created_at` between "'.$today_start.'" and "'.$today_end.'"';
	    //$buildquery .= " && `created_at` >= '".$previousdate."'"; 
	}
	$buildquery .= " order by `created_at` DESC";

	//echo $buildquery; echo "<br>";
	$query = $db->query($buildquery);
	$rows_counter = $query->getNumRows();
	$output = array();
	if($rows_counter>0){
	    $output = $query->getResult();
	}
	return $output;
    }
    

    public function get_max_order($table){
        // get max order
        $builder = $this->db->table($table);
        return $builder->selectMax('order');
    }
    
    public function getNestedThis($table) 
    {
        $builder = $this->db->table($table);
    //    $builder->orderBy($this->_order_by);
        $pages = $builder->get()->getResultArray();

        $array = array();
        foreach ($pages as $page) {
            if (! $page['parent_id']) {
                // This page has no parent
                $array[$page['id']] = $page;
            }
            else {
                // This is a child page
                $array[$page['parent_id']]['children'][] = $page;
            }
        }
        return $array;
    }
    
    
     //save data order by and this function has set many model for that table
    public function saveOrder ($pages)
    {
        if (count($pages)) {
            foreach ($pages as $order => $page) {
                if ($page['item_id'] != '') {
                    $data = array('parent_id' => (int) $page['parent_id'], 'order' => $order);

                    $builder = $this->db->table($this->_table_name);
                    $builder->set($data)->where($this->_primary_key, $page['item_id'])->update();
                }
            }
        }
    }
    
    public function getProductsForCategory($categoryId) {
		$builder = $this->db->table("product as p");
		$builder->select('p.*, pl.*');
		$builder->join('product_lang as pl', 'p.id = pl.connlang_id');
		$builder->where('p.category', $categoryId);
		$builder->where('pl.language_id', 8);

		$products = $builder->get()->getResult();

		return $products;
	}

	public function addSelProducts($table, $data) {
	    /*$sproduct       = ($data['sproduct'] != '')?$data['sproduct']:'';
	    $dimension      = ($data['dimension'] != '')?$data['dimension']:'';
	    $qty            = ($data['qty'] > 0)?$data['qty']:'';
	    $scolor         = ($data['scolor'] > 0)?$data['scolor']:'';
	    $fcolor         = ($data['fcolor'] > 0 )?$data['fcolor']:0;
	    $motorauto      = ($data['motorauto'] != '')?$data['motorauto']:'No';
	    $uprice         = ($data['uprice'] != '')?$data['uprice']:0;*/	    $db 	    = db_connect('default'); 	    $builder 	    = $db->table("selproducts");
	    $builder->insert($data);
	    $id 	    = $this->db->insertID();
	    $errors = $this->db->error();	    return $id;
	}
	
		public function addSelProject($data) {
	/*	$sproduct       = $data['sproduct'];
		$dimension      = $data['dimension'];
		$qty            = $data['qty'];
		$scolor         = $data['scolor'];
		$fcolor         = $data['fcolor'];
		$motorauto      = $data['motorauto'];
		$uprice         = $data['uprice']; */
		
		$db 		= db_connect('default'); 
		$builder 	= $db->table("setproject");
		$builder->insert($data);
		$id 		= $this->db->insertID();
		
		$errors = $this->db->error();
		
		return $id;
	}

	public function updateSelProducts($table, $id, $field, $value) {
		$data 		= array($field => $value);
		$builder 	= $this->db->table($table);
		$builder->set($data)->where('id', $id)->update();
	}
	
    function updateProductCategoryForOrder($table, $orderNum, $product_category) {
		$data 		= array('product_category' => $product_category);
		$builder 	= $this->db->table($table);
		$builder->set($data)->where('id', $orderNum)->update();
    }


	//fetch data with no lang data
    public function get_no_lang($table_name,$where=false,$parent_id,$single = FALSE){
        // $this->db->select('*');
        // $this->db->from($table_name);
        // $this->db->join($table_name.'_lang', $table_name.'.id = '.$table_name.'_lang.'.$parent_id);


        $builder = $this->db->table($table_name);
        $builder->join($table_name.'_lang', $table_name.'.id = '.$table_name.'_lang.'.$parent_id);
        
		if($where){
	        $builder->where($where);
		}
        
        if($single == TRUE){
            $method = 'row';
        }
        else
        {
            $method = 'result';
        }
        
        return $builder->$method();
	} 

	//get fetch data with lang id and where clause
/*	-get_lang function for get video lang data by join table
		1 parameter : table name
		2 parameter : lang id
		3 parameter : video id set default 'NULL'
		4 parameter : where clause by array
		5 parameter : for join field name like 'videos_id' field in videos_lang table
		6 parameter : get single or multi data
*/	
	
    public function get_lang($table_name,$lang_id=2, $id=NULL, $where=false,$parent_id,$single = FALSE){
        
        error_reporting(1);


		$session = \Config\Services::session();
		$detail = $session->get();
		$router = service('router');
		$controller  = $router->controllerName();
		$explodecontroller = explode("\\",$controller);

		$builder = $this->db->table($table_name);
		
	if (isset($detail['adminSession']['id']) && $explodecontroller[3] == 'Manage') {
		$getuserrole = getuserrole();
	    $table = $table_name;
	    if($getuserrole == 'Region Admin' || $getuserrole == 'Region SubAdmin'){
		$loadsession = loadsession();
		
		if(isset($loadsession['totalbranches_region'])){
		    //pp($loadsession,false);
		    $totalbranches = $loadsession['totalbranches_region'];
		    $totalemployees = $loadsession['totalemployees_region'];
		    $total_regions = $loadsession['total_regions']; 
		    if($table == 'branches'){
			$name = $table.'.region_id';
			$adddata = $total_regions;
			$builder->whereIn($name,$adddata);
		    }
		    else if($table == 'employees'){
			$name = $table.'.branch_id';
			$adddata = $totalbranches;
			$builder->whereIn($name,$adddata);
		    }
		    
		}
		
		
	    }
	    else if($getuserrole == 'Branch Group Admin'){
		$loadsession = loadsession();
		
		if(isset($loadsession['totalemployees_region'])){
		    $totalbranches = $loadsession['totalbranches_region'];
		    $totalemployees = $loadsession['totalemployees_region'];
		    
		    if($table == 'branches'){
			$name = $table.'.id';
			$adddata = $totalbranches;
			$builder->whereIn($name,$adddata);
		    }
		    else if($table == 'employees'){
			$name = $table.'.branch_id';
			$adddata = $totalbranches;
			$builder->whereIn($name,$adddata);
		    }
		    
		}
	    }

	}
	    
		if ($lang_id) {
		$builder->join($table_name.'_lang', $table_name.'.id = '.$table_name.'_lang.'.$parent_id);
		$builder->where('language_id', $lang_id);
		}
		$builder->orderBy('order', 'ASC');
		if($where){
			$builder->where($where);
		}
		if($id != NULL) {
			$builder->where($table_name.'.id', $id);
		}
		$query  = $builder->get();
		if($single == TRUE) {
			$output = $query->getRow();
		}
		else {
			$output = $query->getResult();
		}

		return $output;
	}
	
	public function get_lang_desc($table_name,$lang_id=2, $id=NULL, $where=false,$parent_id,$single = FALSE){
        
        
		$builder = $this->db->table($table_name);
		if ($lang_id) {
		$builder->join($table_name.'_lang', $table_name.'.id = '.$table_name.'_lang.'.$parent_id);
		$builder->where('language_id', $lang_id);
		}
		$builder->orderBy('date', 'DESC');
		if($where){
			$builder->where($where);
		}
		if($id != NULL) {
			$builder->where($table_name.'.id', $id);
		}
		$query  = $builder->get();
		if($single == TRUE) {
			$output = $query->getRow();
		}
		else {
			$output = $query->getResult();
		}

		return $output;
	}
	
	
	public function get_bycat($table_name,$lang_id=2, $id=NULL, $where=false,$parent_id,$single = FALSE){
        
        
		$builder = $this->db->table($table_name);
		$builder->join($table_name.'_lang', $table_name.'.id = '.$table_name.'_lang.'.$parent_id);
		$builder->where('language_id', $lang_id);
		$builder->orderBy('category_id', 'ASC');
		if($where){
			$builder->where($where);
		}
		if($id != NULL) {
			$builder->where($table_name.'.id', $id);
		}
		$query  = $builder->get();
		if($single == TRUE) {
			$output = $query->getRow();
		}
		else {
			$output = $query->getResult();
		}

		return $output;
	}
	
	 public function projects_rand6 ($table_name,$lang_id=2, $id=NULL, $where=false,$parent_id,$single = FALSE){
        
        
		$builder = $this->db->table($table_name);
		$builder->join($table_name.'_lang', $table_name.'.id = '.$table_name.'_lang.'.$parent_id);
		$builder->where('language_id', $lang_id);
		$builder->orderBy('order', 'random');
		$builder->limit(6);
		if($where){
			$builder->where($where);
		}
		if($id != NULL) {
			$builder->where($table_name.'.id', $id);
		}
		$query  = $builder->get();
		if($single == TRUE) {
			$output = $query->getRow();
		}
		else {
			$output = $query->getResult();
		}

		return $output;
	}
	
	public function getSearch($table_name,$where,$like) { 
	    
	    $builder = $this->db->table($table_name);
        if($where){
			$builder->where($where);
		}
		if($like){
    			$builder->like('first_name',$like)->orLike('last_name',$like);
            }
            
        
        
        $builder->orderBy('order', 'asc');
		$query  = $builder->get();
		$output = $query->getResult();
		return $output;
	}
	
	public function getDatam($table_name,$where,$havingIn,$like,$order,$is_count=false) {

	    $builder = $this->db->table($table_name);
	    if($where){$builder->where($where);}
	    if($like){$builder->like($like);}
	    if ($havingIn) { $builder->havingIn('employee', $havingIn); }
	    $builder->orderBy($order, 'desc');    
	    
	    if($is_count){
		return $num_results = $builder->countAllResults();
	    }
	    else {
		$query  = $builder->get();
		$output = $query->getResult();
		return $output;
	    } 
	    
	}

    public function getDatam2($table_name,$where,$lang_id,$like,$order,$multi) {  
	    
	    $builder = $this->db->table($table_name);
	    if ($lang_id) { 
            $builder->join($table_name.'_lang', $table_name.'.id = '.$table_name.'_lang.connlang_id');
		    $builder->where('language_id', $lang_id);
        }
	    
	    
        if($where){$builder->where($where);}
		if($like){$builder->like($like);}
		
        
        
        $builder->orderBy($order, 'desc'); 
        
		$query  = $builder->get();
		$output = $query->getResult();
		
		
		if($multi) {
		    
		    foreach($multi as $key=>$value) { 
    
                $select[$key] = array();
                
                
                foreach ($output as $thisis) {
                    
                    $exploded[$key]= explode(',',$thisis->{$key});
                    
                    foreach ($exploded[$key] as $cat[$key]) {
                        
                        if ($cat[$key] == $value) {
                            
                            array_push($select[$key],$thisis);
                            
                        } 
                        
                    }
                    
                }
		        
		         $output = $select[$key];
		        
		    }
		    
		   
		    
		} 
		
		
		
		return $output;
		
		
	}


	public function getDatamwithlimit($table_name,$where,$havingIn,$like,$order,$row,$rowperpage,$is_count=false,$lang = '',$langcondition = array()) {  
	    $builder = $this->db->table($table_name);
	    //error_reporting(0);
	    if ($lang != '') { 
		$builder->join($table_name.'_lang', $table_name.'.id = '.$table_name.'_lang.connlang_id');
		if(count($langcondition)>0){
		    $builder->like($langcondition);
		}
	    }


	    $getuserrole = getuserrole();
	    $table = $table_name;
	    if($getuserrole == 'Region Admin' || $getuserrole == 'Region SubAdmin' || $getuserrole == 'Branch Group Admin'){
		$loadsession = loadsession();
		
		if(isset($loadsession['totalbranches_region'])){
		    $totalbranches = $loadsession['totalbranches_region'];
		    $totalemployees = $loadsession['totalemployees_region'];
		    if($table == 'quotes' || $table == 'fromcontact' || $table == 'supportvisitors'){
			$name = 'branch_id';
			$adddata = $totalbranches;
			$builder->whereIn($name,$adddata);
		    }
		    else if($table == 'fromhome'){
			$name = 'branch';
			$adddata = $totalbranches;
			$builder->whereIn($name,$adddata);
		    }
		    else if($table == 'setproject'){
			$name = 'employee';
			$adddata = $totalemployees;
			$builder->whereIn($name,$adddata);
		    }
		    else if($table == 'employees'){
			$name = 'id';
			$adddata = $totalemployees;
			$builder->whereIn($name,$adddata);
		    }
		    else if($table == 'activitylogs'){
			$name = 'employee';
			$adddata = $totalemployees;
			$builder->whereIn($name,$adddata);
		    }
		    else if($table == 'locorders'){
			$name = 'ordered_user';
			$adddata = $totalemployees;
			$builder->whereIn($name,$adddata);
		    }
		    
		}
	    }
	    else if($getuserrole == 'Branch Group Admin'){
		$loadsession = loadsession();
		
		if(isset($loadsession['totalbranches_region'])){
		    $totalbranches = $loadsession['totalbranches_region'];
		    $totalemployees = $loadsession['totalemployees_region'];
		    if($table == 'quotes' || $table == 'fromcontact' || $table == 'supportvisitors'){
			$name = 'branch_id';
			$adddata = $totalbranches;
			$builder->whereIn($name,$adddata);
		    }
		    else if($table == 'fromhome'){
			$name = 'branch';
			$adddata = $totalbranches;
			$builder->whereIn($name,$adddata);
		    }
		    else if($table == 'setproject'){
			$name = 'employee';
			$adddata = $totalemployees;
			$builder->whereIn($name,$adddata);
		    }
		    else if($table == 'employees'){
			$name = 'id';
			$adddata = $totalemployees;
			$builder->whereIn($name,$adddata);
		    }
		    else if($table == 'activitylogs'){
			$name = 'employee';
			$adddata = $totalemployees;
			$builder->whereIn($name,$adddata);
		    }
		    else if($table == 'locorders'){
			$name = 'ordered_user';
			$adddata = $totalemployees;
			$builder->whereIn($name,$adddata);
		    }
		    
		}
	    }
	    
	    	
	    if(count($where)>0){
		$builder->where($where);
	    }
	    if(count($like)>0){
		$builder->like($like);
	    }
	    if(!empty($havingIn) && count($havingIn)>0){
		$builder->whereIn('employee', $havingIn);
	    }

	    if($order != '') {
		$builder->orderBy($order);
	    }
	    
	    if($is_count){
		return $num_results = $builder->countAllResults();
	    }
	    else {
		if($rowperpage != 'all') {
		    $query  = $builder->get($rowperpage,$row);
		}
		else {		    
		    $query  = $builder->get();
		}
		$output = $query->getResult();
		return $output;
	    }
	    
	}

	public function get_emp_tasks_filter($table_name,$where,$havingIn,$like,$order,$row,$rowperpage,$is_count=false,$empid) {  	    
	    $builder = $this->db->table($table_name);
	    $wheresent = '';
	    
	    $getuserrole = getuserrole();
	    $table = $table_name;
	    if($getuserrole == 'Region Admin'){
		$loadsession = loadsession();		
		if(isset($loadsession['totalbranches_region'])){
		    $totalbranches = $loadsession['totalbranches_region'];
		    $totalemployees = implode(",",$loadsession['totalemployees_region']);
		    if($table == 'tasks'){
			$wheresent .= "(`by` IN (".$totalemployees.") OR `assigned` IN (".$totalemployees."))";
		    }
		}		
	    }
	    else if($getuserrole == 'Region SubAdmin'){
		$loadsession = loadsession();		
		if(isset($loadsession['totalbranches_region'])){
		    $totalbranches = $loadsession['totalbranches_region'];
		    $totalemployees = implode(",",$loadsession['totalemployees_region']);
		    if($table == 'tasks'){
			$wheresent .= "(`by` IN (".$totalemployees.") OR `assigned` IN (".$totalemployees."))";
		    }
		}
	    }
	    else if($getuserrole == 'Branch Group Admin'){
		$loadsession = loadsession();
		if(isset($loadsession['totalemployees_region'])){
		    $totalbranches = $loadsession['totalbranches_region'];
		    $totalemployees = implode(",",$loadsession['totalemployees_region']);
		    if($table == 'tasks'){
			$wheresent .= "(`by` IN (".$totalemployees.") OR `assigned` IN (".$totalemployees."))";
		    }
		}
		//pp($loadsession);
	    }
	    else {
		$wheresent .= "(`by`='".$empid."' OR `assigned`='".$empid."')";
	    }

	    //echo $wheresent;die;
	    if(count($where)>0){
		foreach($where as $key=>$valueset){
		    $wheresent .= ' AND ( `'.$key.'` = "'.$valueset.'")';
		}
		
		$builder->where($wheresent);
	    }
	    else {
		$builder->where($wheresent);
	    }
	    if($like){$builder->like($like);}
	    $builder->orderBy($order, 'desc');


	    if($is_count){
		return $num_results = $builder->countAllResults();
	    }
	    else {
		if($rowperpage != 'all') {
		    $query  = $builder->get($rowperpage,$row);
		}
		else {		    
		    $query  = $builder->get();
		}
		$output = $query->getResult();
		//pp($this->db->getLastQuery());
		return $output;
	    }
	    
	}

	function get_emp_tasks($empid,$row,$rowperpage){
	    $where = "by='".$empid."' OR assigned='".$empid."'";
	    $builder = $this->db->table("tasks");
	    $builder->where($where);
	    $builder->orderBy('id', 'desc');
	    if($rowperpage != 'all') {
		$query  = $builder->get($rowperpage,$row);
	    }
	    else {
		$query  = $builder->get();
	    }
	    $output = $query->getResult();
	    return $output;
	}
	
	
	public function get_attibute($table_name,$lang_id=2, $where=false,$single = FALSE){
        // $this->db->select('*');
        // $this->db->from($table_name);
        // $this->db->where('language_id', $lang_id);
        
        $builder = $this->db->table($table_name);
        $builder->where('language_id', $lang_id);
        
        
        if($where){
	        $builder->where($where);
		}
		
        if($single == TRUE){
            $method = 'row';
        }
        else
        {
            $method = 'result';
        }

        return $query = $builder->get()->$method();

	} 
	


	
    public function get_no_parents($table_name,$where){
       

        $builder = $this->db->table($table_name);
        $sizes = $builder->where($where)->get()->getResult();

        
        // Return key => value pair array
        $array = array();
        //$array = array(0 => lang('No parent'));
        if(count($sizes))
        {
            foreach($sizes as $n)
            {
                $array[$n->id] = $n->name;
            }
        }
        return $array;
	}
    
	
	//create or update data
    /*
    save function is insert or update data of any table
    1 parameter : table name
    2 parameter : save data with field=>value in array
    3 parameter : update to id default id NULL is insert

    */	
	
	public function saveData($table,$data, $id = NULL){    
		// Set timestamps
		if ($this->_timestamps == TRUE) {
			$now = time();
			$id || $data['created'] = $now;
			
		}
		
		// Insert
		if ($id === NULL) {
			!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;

            $db = db_connect('default');
            $builder = $db->table($table);
            $builder->insert($data);
			$id = $this->db->insertID();
		}
		// Update
		else {
			$filter = $this->_primary_filter;
			$id = $filter($id);

            $builder = $this->db->table($table);
            $builder->set($data);
            $builder->where($this->_primary_key, $id);
            $builder->update();
		}

	    return $id;
    }

	//create or update data with lang data
	public function save_with_lang($table,$data, $id = NULL){    
		// Set timestamps
		if ($this->_timestamps == TRUE) {
			$now = time();
			$id || $data['created'] = $now;
			$data['modified'] = $now;
		}
		
		// Insert
		if ($id === NULL) {
			!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
			// $this->db->set($data);
			// $this->db->insert($table);
			// $id = $this->db->insert_id();
            $db = db_connect('default'); 
            $builder = $db->table($table);
            $builder->insert($data);
			$id = $this->db->insertID();

	        $curr_data_lang['product_id'] = $id;
            $language =  $this->get('language',false);
			if($language){
				foreach($language as  $set_value){
					$curr_data_lang['language_id'] = $set_value->id;
                    $this->db->table($table.'_lang')->insert($curr_data_lang);
					// $this->db->set($curr_data_lang);
					// $this->db->insert($table.'_lang');
				}
			}
		}
		// Update
		else {
			$filter = $this->_primary_filter;
			$id = $filter($id);
			// $this->db->set($data);
			// $this->db->where($this->_primary_key, $id);
			// $this->db->update($table);

            $this->db->table($table)->set($data)->where($this->_primary_key, $id);
		}
		//echo $this->db->last_query();die;
	    return $id;
    }
	
/*
updat function 
1 parameter : table name
2 parameter : save data with field=>value in array
3 parameter : update to id 

*/	

	public function updateData($table,$data, $id = NULL){    
		// Set timestamps
		// $this->db->set($data);
		// $this->db->where($id);
		// $this->db->update($table);

        $this->db->table($table)->set($data)->where($id);

		//echo $this->db->last_query();die;
	   //return $id;
    }

    public function get_query_by_array($string){
		$query = $this->db->query($string);		
		//echo $this->db->last_query();die;
		return $query->getResultArray(); 
	}
	

    public function get_query($string,$single=false){
		$query = $this->db->query($string);		
      	if($single == TRUE) {
            $result = $query->getRow();
        }
        else {
            $result = $query->getResult();
        }
		return $result;
	}

//fetch data from any table 
/*
1 parameter : table name
2 parameter : where clause with array
3 parameter : where like clause
4 parameter : order by with array like array('id'=>'desc')
5 parameter : return single or multi data
*/	
    public function get_by_only_id($table,$where, $like = false,$order = false, $single = FALSE){

        $db = \Config\Database::connect();
	$ids = array();

        if ($db->tableExists($table)) {

            $builder = $this->db->table($table);

    		if($like){

    			$builder->like($like);

            }

    		if($order){

                //$order = array($order);

    			foreach($order as $set =>$value){				

    	            $builder->orderBy($set,$value);

    			}

    		}

            $builder->where($where);

    

    		if($single) {
		    $result = $builder->get()->getRow();

    		} else {
		    $result = $builder->get()->getResult();
		}

		foreach ($result as $row)
		{
			$ids[] = $row->id;
		}
		    

        }

	
		if(count($ids)>0){
		    return implode(",",$ids);
		}
		else {
		    return '';
		}

    }

    
    public function cloneproject($product_id) {
	$db = \Config\Database::connect();		
	$db->query('INSERT INTO `setproject`(`parent_id`, `category`, `employee`, `sendtime`, `buyer`, `email`, `phone`, `address`, `notes`, `tax`, `shipping`, `transportation`, `insurance`, `extra`, `install`, `incomen`, `created`, `enabled`, `product_category`, `total_price`, `quote_id`, `link`) SELECT `parent_id`, `category`, `employee`, `sendtime`, `buyer`, `email`, `phone`, `address`, `notes`, `tax`, `shipping`, `transportation`, `insurance`, `extra`, `install`, `incomen`, `created`, `enabled`, `product_category`, `total_price`, `quote_id`, `link` FROM `setproject` WHERE `id` =  "'.$product_id.'"');
	return $db->insertID();
    }

    public function cloneproducts($product_id) {
	$db = \Config\Database::connect();		
	$db->query('INSERT INTO `selproducts`(`parent_id`, `category_id`, `sproduct`, `qty`, `scolor`, `fcolor`, `dimensions`, `uprice`, `description`, `additional`, `motorauto`, `status`, `order`, `on_date`, `created`, `modified`, `enabled`) SELECT `parent_id`, `category_id`, `sproduct`, `qty`, `scolor`, `fcolor`, `dimensions`, `uprice`, `description`, `additional`, `motorauto`, `status`, `order`, `on_date`, `created`, `modified`, `enabled` FROM `selproducts` WHERE `id` = "'.$product_id.'"');	
	return $db->insertID();
    }

    public function get_by($table,$where, $like = false,$order = false, $single = FALSE){
        $db = \Config\Database::connect();
        if ($db->tableExists($table)) {
            $builder = $this->db->table($table);
    		if($like){
    			$builder->like($like);
            }
    		if($order){
                //$order = array($order);
    			foreach($order as $set =>$value){				
    	            $builder->orderBy($set,$value);
    			}
    		}
            $builder->where($where);
    
    		if($single)
    			$result = $builder->get()->getRow();
    		else
    			$result = $builder->get()->getResult();
        }

	//echo $this->db->getLastQuery();die;
		return $result;
    }

//fetch data from any table 
/*
1 parameter : table name
5 parameter : return single or multi data
*/
	public function get($table ,$single = FALSE){
		$this->_table_name = $table;
		$builder = $this->db->table($table);

      	if($single == TRUE) {
      		$result = $builder->get()->getRow();
        }
        else {
        	$result = $builder->get()->getResult();
        }

        return $result;
    }

//get post data 
	public function array_from_post($fields){
        $data = array();
        foreach ($fields as $field) {
			$request = \Config\Services::request();
            $data[$field] = $request->getPost($field);
        }
        return $data;
    }

	//upload image with path with 3 type of img store small full thumbnails
	function do_upload($file_name,$path){
	    
	    $website_settings = $this->get('l_settings', true); 
	    
	    
		$data = array();
		$validated = $this->validate([
			$file_name => [
				'uploaded['.$file_name.']',
				'mime_in['.$file_name.',image/gif,image/jpg,image/png,image/jpeg,image/bmp,image/GIF,image/JPG,image/JPEG,image/BMP]', 
				'max_size['.$file_name.',60000]',
				'max_dims['.$file_name.',5000,5000]',
			],
		]);

		if ($validated) {
			$request = \Config\Services::request();
			$avatar = $request->getFile($file_name);
			$newname = $website_settings->keyname.$avatar->getRandomName(); 
			$avatar->move($path.'/full/',$newname);

			$image1 = \Config\Services::image()
				->withFile($path.'/full/'.$avatar->getName())
				->fit(750, 450, 'center')
				->save($path.'/thumbnails/'.$avatar->getName());

			$image2 = \Config\Services::image()
				->withFile($path.'/full/'.$avatar->getName())
				->fit(150, 150, 'center')
				->save($path.'/small/'.$avatar->getName());

			$data['product_image'] = $avatar->getName();
			$data['status'] = 'success';
		} else {
			$data['status'] = 'error';
			$data['message'] = 'Invalid file for upload!';
		}
		return $data;
	}
	

    function upload_filem($file_name,$path){
	    
	    $website_settings = $this->get('l_settings', true); 
	    
	    
		$data = array();
		$validated = $this->validate([
			$file_name => [
				'uploaded['.$file_name.']',
				'mime_in['.$file_name.',image/gif,image/jpg,image/png,image/jpeg,image/bmp,image/GIF,image/JPG,image/JPEG,image/BMP]',
				'max_size['.$file_name.',60000]',
				'max_dims['.$file_name.',5000,5000]',
			],
		]);

		if ($validated) {
			$request = \Config\Services::request();
			$avatar = $request->getFile($file_name);
			$newname = $website_settings->keyname.$avatar->getRandomName(); 
			$avatar->move($path,$newname);

			

			$data['filem_name'] = $avatar->getName();
			$data['status'] = 'success';
		} else {
			$data['status'] = 'error';
			$data['message'] = 'Invalid file for upload!';
		}
		return $data;
	}

	//insert data
	function add($table,$array){
        $db = db_connect('default'); 
        $builder = $db->table($table)->insert($array);
		return $db->insertID();
	}
	
	//record_count data
	function record_count($table) {
        return $this->db->table($table)->countAll();
    }
	
	//for query data
	function query_result($query){
		$query = $this->db->query($query);
		return $query->result_array(); 
	}

	//for delete
    public function deleteData($table,$where){
		$this->db->table($table)->delete($where);
    }

    public function deleterowdata($table,$id){
	$db = \Config\Database::connect();
	$db->query('DELETE FROM `'.$table.'` WHERE `id` = "'.$id.'"');		
    }
    public function deleteoptions($table,$id){
	$db = \Config\Database::connect();
	$db->query('DELETE FROM `'.$table.'` WHERE `category_id` = "'.$id.'"');		
    }
		
	function delete_by_id($table,$where)
	{		
		$this->db->table($table)->delete($where);
	}
		
	//for update by id
	function update_by_id($table_Name,$updatequery, $id){
		$this->db->table($table_Name)->where('id', $id);
		$this->db->table($table_Name)->update($updatequery);	
	}

	//for update
	function update_by($table_Name,$updatequery,$condition){
        $builder = $this->db->table($table_Name);
        $builder->where($condition);
        $builder->update($updatequery);
	}

	//for update
	function update_data_by_id($table_Name,$updatequery, $field_name,$value){
        $builder = $this->db->table($table_Name);
        $builder->where($value);
        $builder->update($updatequery);
	}

	public function savemanually($table,$data, $id = NULL, $is_lang = false)
	{   
	    
	    $builder = $this->db->table($table);
	    if(!$id)
	    {
		$builder->insert($data);
		$id = $this->db->insertID();
	    }
	    else
	    {
		$askme = 'id';
		$builder->set($data);
		if($is_lang){
		    $askme = 'lid';
		}
		$builder->where($askme, $id);            
		$builder->update();
	    }     

	    return $id;
	}
    					
}



/* End of file super_admin_model.php */
/* Location: ./system/application/models/super_admin_model.php */
?>
