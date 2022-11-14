<?php
use App\Models\CommanModel;
use App\Models\backend\Languagemodel;
use App\Models\backend\Adminsmodel;

function globalmenu(){
    $qu=print_count('quotes',array('view'=>0));
    $bd=print_count('storedata',array('view'=>0));
    $cu=print_count('fromcontact',array('view'=>0)); 
    $tot = $qu+$bd+$cu;
    
    $main_menu_array = array(
        "General Settings" => array(
            "name"=>"Base",
            "total"=>0,
            "icon"=>"fa fa-cog",
            "menuitems" =>  array(
                "settings"=>"Main","regions"=>"Countries","language"=>"Languages","statictext"=>"Static areas","currency"=>"Currencies","pmethods"=>"Payment methods","socials"=>"Social Networks","email"=>"Document Templates","allvisitors"=>"All Visitors"
            )
        ),
        "Organisation" => array(
            "name"=>"Organisation",
            "total"=>0,
            "icon"=>"fa fa-sitemap",
            "menuitems" =>  array(
                "branches"=>"Branches","positions"=>"Positions","employees"=>"Employees"
            )
        ),
        "Product Management" => array(
            "name"=>"Product Management",
            "total"=>0,
            "icon"=>"bi bi-cart",
            "menuitems" =>  array(
                "pdcats"=>"Categories","applications"=>"Applications","product"=>"Products"
            )
        ),
        "Our Projects" => array(
            "name"=>"Project Management",
            "total"=>0,
            "icon"=>"bi bi-patch-check",
            "menuitems" =>  array(
                "pjcats"=>"Categories","project"=>"Projects"
            )
        ),
        "Content management" => array(
            "name"=>"Content Management",
            "total"=>0,
            "icon"=>"bi bi-sticky",
            "menuitems" =>  array(
                "banner"=>"Banners","page"=>"Page","slider"=>"Slider","partners"=>"Partners","reviews"=>"Reviews & Ratings","videos"=>"Videos","faq"=>"Faq","blog"=>"Blogs"
            )
        ),
        "From Website" => array(
            "name"=>"CRM",
            "total"=>$tot,
            "icon"=>"bi bi-layers",
            "menuitems" =>  array(
                "quotes"=>array("total"=>$qu,"name"=>"Get Quote"),
                "storedata"=>array("total"=>$bd,"name"=>"Store data"),
                
            )
        ),
        "Invoice management" => array(
            "name"=>"Invoice & Estimates",
            "total"=>0,
            "icon"=>"bi bi-hr",
            "menuitems" =>  array(
                "invoice"=>"Invoices","colorcats"=>"Color categories","colors"=>"Colors"
            )
        ),
        "User Management" => array(
            "name"=>"Account Management",
            "total"=>0,
            "icon"=>"bi bi-person",
            "menuitems" =>  array(
                "admins"=>"Admins"
            )
        ),
        "Important" => array(
            "name"=>"Intranet",
            "total"=>0,
            "icon"=>"bi bi-shield-check",
            "menuitems" =>  array(
                "staf"=>"Communication","mixed"=>"Product files","tasks"=>"Task management",
            )
        ),
        "Local Store" => array(
            "name"=>"Local Store",
            "total"=>0,
            "icon"=>"bi bi-cart",
            "menuitems" =>  array(
                "loccats"=>"Categories","locsize"=>"Size","loccolor"=>"Color","locgender"=>"Gender","locproducts"=>"Products","locstore"=>"Store","locorders"=>"Orders",
            )
        ),
        "Logs" => array(
            "name"=>"Logs",
            "total"=>0,
            "icon"=>"fas fa-history",
            "menuitems" =>  array(
                "activities"=>"Activity logs",
            )
        )        
    );
    return $main_menu_array;
}
function branchmenu($thisbranch,$Groupadmin = false){
    
    $qu=print_count('quotes',array('view'=>0,'branch_id'=>$thisbranch->id));
    $cu=print_count('fromcontact',array('view'=>0,'branch_id'=>$thisbranch->id)); 
    $tot = $qu+$cu;


    if($Groupadmin){

        
        
    }


    
    //$nee=print_count('needs',array('enabled'=>0));
    
    $main_menu_array = array(        
        "From Website" => array(
            "name"=>"CRM",
            "total"=>$tot,
            "icon"=>"bi bi-layers",
            "menuitems" =>  array(
                "quotes"=>array("total"=>$qu,"name"=>"Get Quote"),
                "fromcontact"=>array("total"=>$cu,"name"=>"Contact Us"),
                "fromhome"=>"Footer Subscribers","chathistory"=>"Online Chat History",
                "meeting"=>"Meeting Requests","meeting"=>"Meeting Requests"
            )
        ),
        "Invoice management" => array(
            "name"=>"Invoice & Estimates",
            "total"=>0,
            "icon"=>"bi bi-hr",
            "menuitems" =>  array(
                "invoice"=>"Invoices"
            )
        ),
        "Important" => array(
            "name"=>"Intranet",
            "total"=>0,
            "icon"=>"bi bi-shield-check",
            "menuitems" =>  array(
                "staf"=>"Communication","mixed"=>"Product files","tasks"=>"Task management",
            )
        ),
        "Local Store" => array(
            "name"=>"Local Store",
            "total"=>0,
            "icon"=>"bi bi-cart",
            "menuitems" =>  array(
                "locstore"=>"Store","locorders"=>"My Orders",
            )
        ),
        "Logs" => array(
            "name"=>"Logs",
            "total"=>0,
            "icon"=>"fas fa-history",
            "menuitems" =>  array(
                "activities"=>"Activity logs",
            )
        )
    );
    return $main_menu_array;
}


function msgunreadcounterhelper(){
	//if ($this->admin_request->getMethod() == "post") {
		error_reporting(0);
		//$Languagemodel = new Languagemodel();
		//$admin_lang = $Languagemodel->get_default_id();
		$getuserdata = getuserdata();   
		$thisEmployee = get_langer('employees',false,$getuserdata->employee_id);
	    $chatid = 'Groupchat';
		$chattype = 'adminlocal';
		$e_emp_id = $getuserdata->employee_id;
		$e_branch_id = $thisEmployee->branch_id;
		
		
		$is_show = false;
		if($adminrole == "Global Admin") {
			$is_show = true;
			$e_branch_id = '0';
		}
		
		$CommanModel = new CommanModel();
		
		//$groupunread = $CommanModel->findunreadmessage('localchat',$chatid,$e_emp_id,$e_branch_id,$chattype);
		$adminunread = $CommanModel->findunreadmessage('localontoonechat',$chatid,$e_emp_id,$e_branch_id,$chattype);
		$frontunread = $CommanModel->findunreadmessage('visitorschat',$chatid,$e_emp_id,$e_branch_id,$chattype);
		//pp($groupunread);
		return (count($adminunread)+count($frontunread));
		
	//}
}

function common_html_tags($label,$inputarray){
    $type = isset($inputarray['type'])?$inputarray['type']:array();
    $name_with_type = $inputarray['name'];
    $events = isset($inputarray['events'])?$inputarray['events']:array();
    $dvalue = isset($inputarray['value'])?$inputarray['value']:'';
    $tag = '';
    $extractname = explode("_TYPE",$name_with_type);
    $placeholder = trim($extractname[0]);
    $evt_html = '';
    if(count($events)>0){
        foreach($events as $e_key=>$e_value){
            $evt_html = $e_key.'="'.$e_value.'"';
        }
    }
    if($label == 'Action'){$label = 'Id';}
    if($type == 'text') {        
        $tag = '<input type="text" '.$evt_html.' class="form-control form-control-solid flatpickr-input" name="'.$name_with_type.'" placeholder="Search" id="form_input_'.$name_with_type.'" value="'.$dvalue.'"/>';
    }
    else if($type == 'select') {
        $options = $inputarray['options'];
        $tag = '<select '.$evt_html.' data-allow-clear="true" data-control="select2" data-placeholder="Please select" class="form-select form-select form-select-solid" name="'.$name_with_type.'" id="form_select_'.$name_with_type.'">';
        $tag .= '<option value="">Please select</option>';
        foreach($options as $key=>$value){
            if($dvalue != '' && $dvalue == $key){
                $optionvalue='selected';
            }
            else {
                $optionvalue = '';
            }
            $tag .= '<option value="'.$key.'" '.$optionvalue.' >'.$value.'</option>';
        }
        $tag .= '</select>';
    }
    else if($type == 'selectwithcondition') {
        $options = $inputarray['options'];
        $condition = $inputarray['condition'];
        $tag = '<select '.$evt_html.' data-allow-clear="true" data-control="select2" data-placeholder="Please select" class="form-select form-select form-select-solid" name="'.$name_with_type.'" id="form_select_'.$name_with_type.'">';
        $tag .= '<option value="">Please select</option>';
        foreach($options as $key=>$value){
            if($dvalue != '' && $dvalue == $key){
                $optionvalue='selected';
            }
            else {
                $optionvalue = '';
            }
            if(count($condition)>0){
                if(in_array($key,$condition)){
                    $tag .= '<option value="'.$key.'" '.$optionvalue.'>'.$value.'</option>';
                }
            }
            else {
                $tag .= '<option value="'.$key.'" '.$optionvalue.'>'.$value.'</option>';
            }            
        }
        $tag .= '</select>';
    }
    else if($type == 'selectwithoptiongroup') {
        $options = $inputarray['options'];
        $treeoptions = buildTree($options);
        $tag = '<select '.$evt_html.' data-allow-clear="true" data-control="select2" data-placeholder="Please select" class="form-select form-select form-select-solid"  name="'.$name_with_type.'" id="form_select_'.$name_with_type.'">';
        $tag .= '<option value="">Please select</option>';
        foreach($treeoptions as $mainvalue){
            $tag .= '<optgroup label="'.$mainvalue['title'].'">';
            if(isset($mainvalue['children'])){
                foreach($mainvalue['children'] as $value){
                    if($dvalue != '' && $dvalue == $value['id']){
                        $optionvalue='selected';
                    }
                    else {
                        $optionvalue = '';
                    }
                    $tag .= '<option value="'.$value['id'].'" '.$optionvalue.' >'.$value['title'].'</option>';
                }
            }
            $tag .= '</optgroup>';
            
        }
        $tag .= '</select>';
    }
    else if($type == 'datetimerange') {
        $tag = '<input type="text" '.$evt_html.' class="form-control form-control-solid flatpickr-input daterangepicker" name="'.$name_with_type.'" style="position: absolute;    top: 3px;    left: 0;    z-index: 9;" placeholder="Search" id="form_input_'.$name_with_type.'" value="'.$dvalue.'"/>';
    }
    return $tag;
}

function buildTree(array $elements, $parentId = 0) {
    $branch = array();

    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }

    return $branch;
}



function loadsession(){
    $session = \Config\Services::session();
    $detail = $session->get();
    return $detail;
}
function getuserdata(){
    $detail = loadsession();
    if (isset($detail['adminSession']['id'])) {
        $CommanModel = new CommanModel();
        $adminDetails =  $CommanModel->get_by('admin', array('id' => $detail['adminSession']['id']), FALSE, FALSE, TRUE);
        $returnarray = $adminDetails;
    }
    else {
        $returnarray = array();
    }
    return $returnarray; 
}

function getuserrole(){
    $Adminsmodel = new Adminsmodel();
    $roles = $Adminsmodel->getRoles();
    $getuserdata = getuserdata();    
    $role = '';
    if(isset($getuserdata->role)){
        $role = $getuserdata->role;
    }
    return $role;
}


function get_admin_conn_lang($table,$id,$lid){
    $db = \Config\Database::connect();
    $builder = $db->table($table);
    $builder->where('connlang_id', $id);
    $builder->where('language_id', $lid);
    $itemd = $builder->get()->getRow();
    return $itemd;
}
function readmorestring($string,$url,$counter){
    $string = strip_tags($string);
    if (strlen($string) > $counter) {

        // truncate string
        $stringCut = substr($string, 0, $counter);
        $endPoint = strrpos($stringCut, ' ');

        //if the string doesn't contain any space then it will cut without word basis.
        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
        if($url != ''){
            $string .= '... <a href="'.$url.'" class="btn-link">Read More</a>';
        }
        else {
            $string .= '...';
        }
    }
    return $string;
}

function html_form_tags($data){
    $html = '';
    if($data['label'] != ''){
        $labelclass = (isset($data['labelclass']))?$data['labelclass']:'form-label fw-bold fs-6';
        
        $label_attrs = ['class' => $labelclass,'style' => ''];
        $html .= form_label('<span class="'.$data['label_required'].'">'.$data['label'].'</span>', '', $label_attrs);
    }
    $data['type_data']['class'] = (isset($data['type_data']['class']))?$data['type_data']['class']:'form-control form-control-solid';
    if($data['type'] == 'input'){
        $html .= form_input($data['type_data']);
    }
    if($data['type'] == 'select'){
        $html .= form_dropdown($data['type_data']['name'], $data['type_data']['options'], $data['type_data']['value'] ,' aria-label="Please select" data-allow-clear="true" data-control="select2" data-placeholder="Please select..." class="form-select form-select-solid form-select-lg fw-bold" ');
    }
    if($data['type'] == 'selectmultiple'){
        $html .= form_dropdown($data['type_data']['name'], $data['type_data']['options'], $data['type_data']['value'] ,' aria-label="Please select" multiple="multiple" data-control="select2" data-placeholder="Please select..." class="form-select form-select-solid form-select-lg fw-bold" ');
    }
    if($data['type'] == 'textarea'){
        $html .= form_textarea($data['type_data']);
    }
    if($data['type'] == 'button'){
        $html .= form_button($data['type_data']);
    }
    if($data['type'] == 'checkbox'){
        $html .= form_checkbox($data['type_data']);
    }
    if($data['type'] == 'radio'){
        $html .= form_button($data['type_data']);
    }
    
    return $html;
}


function selected_items ($table,$lang,$seitem,$name = 'title') {
  
    if ($seitem) {
     
    $item= array();
    $seitems = explode(',',$seitem);
    
    $string= '';
    
    
    
    foreach ($seitems as $se) {
        
        
    $db = \Config\Database::connect();
    $builder = $db->table($table);
    
    if ($lang) {
    $builder->join($table.'_lang', $table.'.id = '.$table.'_lang.connlang_id');
    $builder->where('language_id', $lang);    
    }
    
    
    $builder->where('id', $se);
    $itemd = $builder->get()->getRow();
  
    array_push($item,$itemd->code);
   
    $string .= '<span class="badge-light-primary me-1 d-inline-block rounded-0 py-1 px-3" >'.$itemd->{$name}.'</span>';
   
    }
    
    

    return $string;
    
    } else {return false;}
    
    } 



    //Needs Review
    
    function ipinfo () {
        
        $table = 'visitors';
      
        $db = \Config\Database::connect();
        $builder = $db->table($table);
		
		$query  = $builder->get();
	
		$branches = $query->getRow();
		
		return $branches->count;
	
        
    }

    function front_format_currency_helper($price){
        return "$".$price;
    }



    function getDatamwithlimit($table_name,$where,$havingIn,$like,$order,$row,$rowperpage,$is_count=false,$lang = '',$langcondition = array()) {
        
        $db = \Config\Database::connect(); 
	    $builder = $db->table($table_name);

	    if ($lang != '') { 
		$builder->join($table_name.'_lang', $table_name.'.id = '.$table_name.'_lang.connlang_id');
		if(count($langcondition)>0){
		    $builder->like($langcondition);
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
    
    function get_by($table,$where, $like = false,$order = false, $single = FALSE){
        $db = \Config\Database::connect();
        if ($db->tableExists($table)) {
            $builder = $db->table($table);
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
		return $result;
    }

    function getDatam2($table_name,$where,$lang_id,$like,$order,$multi) {  
	    $db = \Config\Database::connect();
	    $builder = $db->table($table_name);
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
    
    
    //Needs Review
    
    function get_support_visitors($branchid) {        
        $table = 'supportvisitors';    
        date_default_timezone_set("Asia/Baku");
        $db = \Config\Database::connect();
        $today_start = date("Y-m-d ")."00:00:00";
        $today_end =  date("Y-m-d ")."23:59:59";
        $betweenwhere = ' && sv.created_at between "'.$today_start.'" and "'.$today_end.'"';
        $buildquery = "select sv.*,brn.name as b_name from `supportvisitors` as sv left join `branches` as brn on brn.id = sv.branch_id where ";
        $buildquery .= 'sv.branch_id = "'.$branchid.'"';
        $buildquery .= $betweenwhere; 
        $query = $db->query($buildquery);
        $rows_counter = $query->getNumRows();
        $output = array();
        if($rows_counter>0){
            $output = $query->getResult();
        }
        return $output;        
    }

    


    function get_support_visitors_by_chat($branchid = '0') {        
        $table = 'visitorschat';
        date_default_timezone_set("Asia/Baku");
        $db = \Config\Database::connect();
        $today_start = date("Y-m-d ")."00:00:00";
        $today_end =  date("Y-m-d ")."23:59:59";
        $betweenwhere = ' `created_at` between "'.$today_start.'" and "'.$today_end.'" order by `created_at` DESC';
        if($branchid != '0'){
            $buildquery = "select `sender_id`,`receiver_id`,`created_at` from `visitorschat` where (`branch_id` = '".$branchid."') && ";
        }
        else {
            $buildquery = "select `sender_id`,`receiver_id`,`created_at` from `visitorschat` where ";
        }                
        $buildquery .= $betweenwhere;
        //echo $buildquery;die;
        $query = $db->query($buildquery);
        $rows_counter = $query->getNumRows();
        $output = array();
        if($rows_counter>0){
            $output = $query->getResult();
        }
        return $output;        
    }

    
    function activitylogs($data,$action){
        $table = 'activitylogs';
        $db = \Config\Database::connect();
        $builder = $db->table($table);
        if($action == 'insert'){            
            $builder->insert($data);
            return $db->insertID();
        }
        else if($action == 'fetch'){
            $where = $data['where'];
            $order = $data['order'];
            $is_count = $data['is_count'];
            $rowperpage = $data['rowperpage'];
            $row = $data['row'];

            $getuserrole = getuserrole();  
            if($getuserrole == 'Region Admin' || $getuserrole == 'Region SubAdmin' || $getuserrole == 'Branch Group Admin'){
                $loadsession = loadsession();
                $totalbranches = $loadsession['totalbranches_region'];
                $totalemployees = $loadsession['totalemployees_region'];
                $name = 'employee';
                $adddata = $totalemployees;
                $builder->whereIn($name,$adddata);
                //pp($adddata);
            
            }
            else if($getuserrole == 'Branch Group Admin'){
            
            }
            
            if(count($where)>0){
                $builder->where($where);
            }                   
            $builder->orderBy($order);            
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
                //pp($db->getLastQuery());
                return $output;
            }
        }
    }

    function get_support_visitor_by_id($id) {        
        $table = 'supportvisitors';      
        $db = \Config\Database::connect();
        //$today_start = date("Y-m-d ")."00:00:00";
        //$today_end =  date("Y-m-d ")."23:59:59";
       // $betweenwhere = ' && sv.created_at between "'.$today_start.'" and "'.$today_end.'"';
        $buildquery = "select sv.*,brn.name as b_name from `supportvisitors` as sv left join `branches` as brn on brn.id = sv.branch_id where ";
        $buildquery .= 'sv.id = "'.$id.'"';
        //$buildquery .= $betweenwhere; 
        $query = $db->query($buildquery);
        $rows_counter = $query->getNumRows();
        $output = array();
        if($rows_counter>0){
            $output = $query->getResult();
        }
        return $output;        
    }
    
    
    
    
    
function multiproduct ($thiscat,$lang,$where) {
    $db = \Config\Database::connect();
    
    $builder = $db->table('product');
    $builder->join('product_lang', 'product.id = product_lang.connlang_id');
    $builder->where('language_id', $lang);
    $builder->where($where);
    $builder->orderBy('order', 'asc');
    
    $query  = $builder->get();
    
    $all = $query->getResult();
    
    $select = array();
    
    
    foreach ($all as $thisis) {
        
        $cats= explode(',',$thisis->category);
        
        foreach ($cats as $cat) {
            
            if ($cat == $thiscat) {
                
                array_push($select,$thisis);
                
            }
            
        }
        
    }
    
    
    
    return $select;
    
    
}
    
  
    function select_branches($itemid,$selected_branch_id){ 
      
        $table = 'branches';
      
        $db = \Config\Database::connect();
        $builder = $db->table($table);
		$builder->orderBy('order', 'ASC');
		$query  = $builder->get();
	
		$branches = $query->getResult();
	
		$string = '<select data-control="select2" data-placeholder="Select" class="form-select rounded-0"  id="input_branch'.$itemid.'" onchange="change_branch('.$itemid.')">';
		
		$string .='<option>Branch not detected</option>';
		
		
		$selected = '';
		
		foreach($branches as $branch) {
		    
		    if($selected_branch_id == $branch->id) {$selected="selected";} else {$selected="";}
		    
		    $string .='<option '.$selected.' value="'.$branch->id.'">'.$branch->name.'</option>';
		    
		}
		
		
        $string .= '</select>';
        
        return $string;
       
}


 function select_status($itemid,$thisStatus){ 
      
        $allstatuses  = array(
        0 => 'Waiting',
        1 => 'Viewed',
        2 => 'Invoice sent',
        3 => 'Estimate sent',
        4 => 'Onsite visit',
        5 => 'Invited to',
        6 => 'Agreement sent',
        7 => 'Closed Sale',
        8 => 'Lost'
        );
	
		$string = '<select data-control="select2" data-placeholder="Select" class="form-select rounded-0 " style="width:130px;height:38px"  id="input_status'.$itemid.'" onchange="change_crm_status('.$itemid.')">';
		
		$string .='<option>Select Status</option>';
		
		
		$selected = '';
		
		foreach($allstatuses as $key=>$value) {
		    
		    if($thisStatus == $key) {$selected="selected";} else {$selected="";}
		    
		    $string .='<option '.$selected.' value="'.$key.'">'.$value.'</option>';
		    
		}
		
		
        $string .= '</select>';
        
        return $string;
       
}

function select_status2($itemid,$thisStatus){ 
      
        $allstatuses  = array(
        
            0 => 'Invoice Sent',
            1 => 'Not Answered',
            2 => 'Email problem',
            3 => 'Was Expensive',
            4 => 'Paid',
            5 => 'Followed Up',
            6 => 'Lost'

        );
	
		$string = '<select data-control="select2" data-placeholder="Select" class="form-select rounded-0 " style="width:130px;height:38px"  id="input_status'.$itemid.'" onchange="change_crm_status('.$itemid.')">';
		
		$string .='<option>Select Status</option>';
		
		
		$selected = '';
		
		foreach($allstatuses as $key=>$value) {
		    
		    if($thisStatus == $key) {$selected="selected";} else {$selected="";}
		    
		    $string .='<option '.$selected.' value="'.$key.'">'.$value.'</option>';
		    
		}
		
		
        $string .= '</select>';
        
        return $string;
       
}


    function select_existing_items($allitems,$field,$field_name,$optname,$extra){
        $string = '<div class="form-group">';
        $string .= '<label class="col-lg-2 control-label">'.$field_name.'</label>';
        $string .= '<div class="col-lg-10"><select name="'.$extra.'tag_id[]" class="tag_field" style="width:100%" multiple>';
        $setWeek = explode(',', $field);
        
        
        
        if (!empty($allitems)) {
                foreach ($allitems as $this_item) {
                    
                    
                        foreach ($allitems as $newitem) {
                    
                            if ($newitem->parent_id == $this_item->id) {$parent = '1';}   
                    
                        }
                    
                        if ($this_item->parent_id == 0 and $parent == 1) {
                    
                        $string .= '<optgroup label="'.$this_item->{$optname}.'">';
                    
                        } else {
                    
                            if (!empty($setWeek) && in_array($this_item->id, $setWeek)) {
                                $string .= '<option value="'.$this_item->id.'" selected="selected">'.$this_item->{$optname}.'</option>';
                            } else {
                                $string .= '<option value="'.$this_item->id.'">'.$this_item->{$optname}.'</option>';
                            }
                    
                        
                        }
                        
                        
                        if ($this_item->parent_id == 0) {                    

                        $string .= '</optgroup>';

                        }

        }
        $string .= '</select></div></div>';
        return $string;
    }
    
       
}

    
    function select_existing_without_ort($allitems,$field,$field_name,$optname){
        $string = '<div class="form-group">';
        $string .= '<label class="col-lg-2 control-label">'.$field_name.'</label>';
        $string .= '<div class="col-lg-10"><select name="tag_id[]" class="tag_field" style="width:100%" multiple>';
        $setWeek = explode(',', $field);
        
        
        
        if (!empty($allitems)) {
                foreach ($allitems as $this_item) {
                    
                    
                      
                    
                            if (!empty($setWeek) && in_array($this_item->id, $setWeek)) {
                                $string .= '<option value="'.$this_item->id.'" selected="selected">'.$this_item->{$optname}.'</option>';
                            } else {
                                $string .= '<option value="'.$this_item->id.'">'.$this_item->{$optname}.'</option>';
                            }
                    
                        
                      
        }
        $string .= '</select></div></div>';
        return $string;
    }
    
       
}    

    
    function nts($str) {
        if ($str == '') {
            
            $str = ' ';
            
        }
        
        return $str;
        
    }
    
    
    function getLnt($zip){ 
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zip)."&sensor=false&key=AIzaSyDPLi6vvwFFT3WbS1DJoU1PV6sTAFUOv2w";
    $result_string = file_get_contents($url);
    $result = json_decode($result_string, true);
    return $result['results'][0]['geometry']['location'];
    }
    
    
    function select_existing_only_with_ort ($ort,$list,$field,$field_name,$write) {
        
        
        $string = '<div class="form-group">';
        $string .= '<label class="col-lg-2 control-label">'.$field_name.'</label>';
        $string .= '<div class="col-lg-10">';
        $string .= '<select class="form-control rounded-0" name="'.$write.'" required>';
        $string .= '<option value="" >Select</option>'; 
                        
        if($ort){
                foreach($ort as $set_cat){ 
                                    
        $string .= '<optgroup label="'.$set_cat->title.'">';                            
                                  
                                    
                    foreach($list as $set_item){ 
                                            
                        $selected = '';
                        if($field){
                            if($set_item->id==$field){
                                        $selected = 'selected="selected"';
                            }
                        }
                                       
                                            
                                            if ($set_cat->id == $set_item->parent_id) {
                                            
                                        
        $string .= '<option value="'.$set_item->id.'" '.$selected.' >'.$set_item->title.'</option>';                                    
                                            
                                 }} 
                                            
        $string .= '</optgroup>';                                
                                        
                    }}
        
        $string .= '</select></div></div>';                        
                            
        
        
        return $string;
        
        
        
        
        
        
    }
    
    function select_for_invoice_with_id ($ort,$list,$field,$field_name,$write,$id) {

        

        

        

        $string = '<select data-control="select2" data-placeholder="Select" class=" mt-5 form-select rounded-0" id="'.$id.'" name="'.$write.'" required>';

        $string .= '<option value="" >Select</option>'; 

                        

        if($ort){

                foreach($ort as $set_cat){ 

                                    

        $string .= '<optgroup label="'.$set_cat->title.'">';                            

                                  

                                    

                    foreach($list as $set_item){ 

                                            

                        $selected = '';

                        if($field){

                            if($set_item->id==$field){

                                        $selected = 'selected="selected"';

                            }

                        }

                                       

                                            

                                            if ($set_cat->id == $set_item->parent_id) {

                                            

                                        

        $string .= '<option value="'.$set_item->id.'" '.$selected.' >'.$set_item->title.'</option>';                                    

                                            

                                 }} 

                                            

        $string .= '</optgroup>';                                

                                        

                    }}

        

        $string .= '</select>';                        

                            

        

        

        return $string;

        

        

        

        

        

        

    }

    function create_invoice_table($id,$admin_lang){
        $maincounter = 0;
        $CommanModel = new CommanModel();
        //$Languagemodel = new Languagemodel();

        //$admin_lang = $LanguageModel->get_default_id();

        
        $arrayadd = array();
        $arrayadd['main']             = $CommanModel->get_by('l_settings', array(), FALSE, FALSE, TRUE);
		$arrayadd['setproject']       = $CommanModel->get_by('setproject', array('id'=>$id), FALSE, FALSE, TRUE);
		$arrayadd['selprods']         = $CommanModel->get_by('selproducts', array('category_id'=>$id), FALSE, FALSE, FALSE);
        $arrayadd['allProducts']      = multiproduct ($arrayadd['setproject']->product_category, 8, array());
        
        $arrayadd['child_project']       = $CommanModel->get_by('setproject', array('parent_id'=>$id), FALSE, FALSE, FALSE);
        $ds = array();
        $kp = array();
        $slproids = array();
        $productssarray = array();

        $productssarray[$id] = $CommanModel->get_by('selproducts', array('category_id'=>$id), FALSE, FALSE, FALSE);        
        $slproids[$id] = $CommanModel->get_by_only_id('selproducts', array('category_id'=>$id), FALSE, FALSE, FALSE);
        
        foreach($arrayadd['child_project'] as $dts) {
            $productssarray[$dts->id] = $CommanModel->get_by('selproducts', array('category_id'=>$dts->id), FALSE, FALSE, FALSE);
            $ds[$dts->id] = $CommanModel->get_by('selproducts', array('category_id'=>$dts->id), FALSE, FALSE, FALSE);
            $kp[$dts->id] = multiproduct ($dts->product_category, 8, array());
            $slproids[$dts->id] = $CommanModel->get_by_only_id('selproducts', array('category_id'=>$dts->id), FALSE, FALSE, FALSE);
        }
        $arrayadd['child_pds'] = $ds;
        $arrayadd['main_project_id'] = $id;
        $arrayadd['product_options'] = $productssarray;
        $arrayadd['product_options_ids'] = $slproids;

        $arrayadd['child_projects'] = array();;
        

        $productOptions = "<option value=''>Select a product</option>";
        foreach($arrayadd['allProducts'] as $product) {
            $productOptions .= "<option value='".$product->id."'>".$product->title."</option>";
        }
    
		$arrayadd['coloritems'] = $CommanModel->get_lang('colors',$admin_lang,false,array('enabled'=>1),'connlang_id',FALSE);
		$arrayadd['coloritems2'] = $CommanModel->get_lang('colors',$admin_lang,false,array('category'=>15,'enabled'=>1),'connlang_id',FALSE);
        $arrayadd['productOptions']   = $productOptions;
        $arrayadd['child_pdty']   = $kp;
		$arrayadd['category_id']      = $id;
		$arrayadd['all_categories']   = $CommanModel->get_lang('pdcats',$admin_lang,false,array(),'connlang_id',FALSE);
		$pl = array();
        $arrayadd['main_categories']  = $CommanModel->get_lang('pdcats',$admin_lang,false,array('parent_id'=>0),'connlang_id',FALSE);

        
        //pp($arrayadd);
        $setproject = $arrayadd['setproject'];
        //$adminDetails = $arrayadd['adminDetails'];
        //$child_ids_set = $arrayadd['child_ids_set'];
        $child_ids_set = '';
        $main_project_id = $arrayadd['main_project_id'];
        $main_categories = $arrayadd['main_categories'];
        $all_categories =  $arrayadd['all_categories'];
        //$thisbranch = $arrayadd['thisbranch'];
        $coloritems2 = $arrayadd['coloritems2'];
        $coloritems = $arrayadd['coloritems'];
        $product_options = $arrayadd['product_options'];
        $child_project = $arrayadd['child_project'];
        
        $thisemploee = get_langer('employees', false, $setproject->employee);
        $thisbranch = get_langer('branches', 8, $thisemploee->branch_id);
        $thisregion = get_langer('regions', 8, $thisbranch->region_id);
        $branchtel = explode(',', $thisbranch->phones);
        $currency = get_langer('currency', false, $thisbranch->currency);
        $moreex = floatval($setproject->tax) + 
                floatval($setproject->shipping) + 
                floatval($setproject->transportation) + 
                floatval($setproject->insurance) + 
                floatval($setproject->extra) + 
                floatval($setproject->install);
                
        $expences = $moreex;
                
        if(substr($setproject->incomen, -1) == '%') {
    

        $percent = floatval(substr($setproject->incomen, 0, -1));
        
        } else {
        
            $incomen = floatval($setproject->incomen);
            
            $moreex= $moreex + $incomen;
        
        }        
                
        $this_cat = get_langer('pdcats',8,$setproject->product_category);
        $main_cat = get_langer('pdcats',8,$this_cat->parent_id);
        $colcats = explode(',',$main_cat->secolorcats);
        
        //if ($adminDetails->role == 'Global Admin') {$backLink = $admin_link;}
        //if ($adminDetails->role == 'Branch Admin') {$backLink = $branch_link;}

       // $product_options = ,$child_project
        
        $html = '';
        foreach($product_options as $optionkey=>$product_option) {
            $productprice = '0.00';
            $projectdata = $child_project;
            if($main_project_id == $optionkey){
                $projectdata = $setproject;
            }
            else {
                foreach($child_project as $child_project_data){
                    if($child_project_data->id == $optionkey){
                        $projectdata = $child_project_data;
                    }
                }
            }
            $product_category_id = 'product_category_'.$optionkey;
            $allProducts      = multiproduct ($projectdata->product_category, 8, array());
            
            $html .= '<div class="separator"></div><div class="cst_box my-5" did="'.$optionkey.'" style="width: 100%;overflow-x: scroll;" id="custom_box_'.$optionkey.'" data-child-ids="'.$child_ids_set.'"><button data-cat-pro="'.$projectdata->product_category.'" class="add_field_button2 btn btn-light-primary rounded-0 btn-sm my-1 me-3" data-cat="'.$optionkey.'"><i class="fa fa-plus"></i>Add row</button><a class="clone_row btn btn-light-warning rounded-0 btn-sm my-1 me-3" type="button" style="margin-bottom:10px" href="javascript:" data-project-id="'.$optionkey.'" ><i class="fa fa-clone"></i>Clone option</a>&nbsp;';
            if($main_project_id != $optionkey){
                $html .= '<a class="delete_row btn btn-light-danger rounded-0 btn-sm my-1 me-3" data-project-id="'.$optionkey.'"  href="javascript:" onclick="return confirm_box(this);"><i class="fa fa-trash"></i>Delete</a>';
            }
            $html .= select_for_invoice_with_id($main_categories, $all_categories, $projectdata->product_category, '', 'product_category',$product_category_id);
            $html .= '<table class="table align-middle table-row-dashed fs-6 gy-5 mb-0 firsttable" data-did="'.$optionkey.'" id="child_table_'.$optionkey.'"><thead>';
            $html .= create_invoice_tr("s-item headmy border-bottom fs-6 fw-bolder text-muted",$thisbranch->metric);
            $html .= '</thead><tbody class="fw-bold text-gray-600 input_fields_wrap">';            
            $j = 1;
            $newcounter_main = 1;
            $product_optionarray = orinpro($product_option);
            $this_cat = get_langer('pdcats',8,$projectdata->product_category);
            $main_cat = get_langer('pdcats',8,$this_cat->parent_id);
            //$colcats = explode(',',$main_cat->secolorcats);
            foreach ($product_optionarray as $selprod) {
                $addsum = 0;
                if(is_numeric($selprod->qty) && is_numeric($selprod->uprice)){
                    $addsum  = $selprod->uprice * $selprod->qty;
                }
         
                $html .= '<tr id="child_tr_'.$j.'" data-project-id="'.$optionkey.'" data-product-id="'.$selprod->id.'" data-counter="'.$j.'">
                    <td style="max-width: 30px;">'.$j.'</td>
                    <td align="center">';
                        $html .= select_for_sproduct("sproduct","",$allProducts,$selprod,$j);
                    $html .= '</td>
                    <td class="edittext" style="max-width:95px;" id="dimensions_'.$selprod->id.'" data-row-id="'.$j.'" data-id="'.$selprod->id.'" data-name="dimensions">'.$selprod->dimensions.'</td>
                    <td align="center">';
                        $html .= select_for_scolor("scolor","colordropdown",$coloritems2,$selprod,$j); 
                    $html .= '</td>
                    <td  align="center">';
                        $html .= select_for_fcolor("fcolor","colordropdown",$colcats,$selprod,$j,$coloritems);
                    $html .= '</td>
                    <td class="edittext" style="max-width: 105px;" id="motorauto_'.$selprod->id.'" data-id="'.$selprod->id.'" data-row-id="'.$j.'" data-name="motorauto">
                        '.$selprod->motorauto.'
                    </td>
                    <td class="edittext" style="max-width: 101px;" id="additional_'.$selprod->id.'" data-id="'.$selprod->id.'" data-row-id="'.$j.'" data-name="additional">
                        '.$selprod->additional.'
                    </td>
                    <td class="edittext" style="max-width:45px;" data-id="'.$selprod->id.'" data-row-id="'.$j.'" data-name="qty" id="qty_'.$selprod->id.'">
                        '.$selprod->qty.'
                    </td>
                    <td class="edittext" style="max-width:60px;" data-id="'.$selprod->id.'" data-row-id="'.$j.'" data-name="uprice" id="uprice_'.$selprod->id.'">
                        '.$selprod->uprice.'
                    </td>                                                    
                    <td id="total_row_'.$selprod->id.'" data-name="tot" style="max-width:60px;">
                        '.$addsum.'                                                        
                    </td>                                                    
                    <td>
                        <a data-main-id="'.$optionkey.'" class="btn btn-light-danger rounded-0 btnsml delete" data-product-id="'.$selprod->id.'" href="javascript:" onclick="return confirm_box_row(this,\'placed\');" data-counter="'.$j.'" id="custom_delete_row_'.$j.'">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>                                                    
                </tr>';

                $productprice += $addsum;
                $j++;
                $newcounter_main = $j;                                                    
            }

            $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
            $subtotal = $fmt->formatCurrency($productprice, "USD");
            $expex = $fmt->formatCurrency($expences, "USD");
            
            if($percent) { $total = $fmt->formatCurrency(($productprice+$moreex+($productprice+$moreex)*$percent/100), "USD"); 
            
            
            $incomex = $fmt->formatCurrency(($productprice+$moreex)*$percent/100, "USD");} else {

            $total = $fmt->formatCurrency(($productprice+$moreex), "USD");   
            $incomex =$fmt->formatCurrency($setproject->incomen, "USD");
            
            
            
            }

            $html .= '</tbody></table>
            
                        <input type="hidden" id="child_input_next_'.$optionkey.'" value="'.$newcounter_main.'"/>
                        <div class="fs-3 text-muted fw-bolder text-end pt-4">Sub Total : <span class="text-muted" id="id_order_total_'.$optionkey.'">'.$subtotal.'</span></div>
                        <div class="fs-5 text-muted text-end" >Expences: <b id="id_order_exp_'.$optionkey.'">'.$expex.' </b></div>
                        <div class="fs-5 text-muted text-end" >Markup: <b id="id_order_income_'.$optionkey.'">'.$incomex.' </b></div>
                        <div class="fs-3 pt-4 text-dark fw-bolder text-end">Total : <span class="text-dark fs-3 fw-boldest text-end" id="id_order_mtotal_'.$optionkey.'">'.$total.'</span>
                        
                        </div></div>  ';
                                
            $maincounter++;
        }
        return $html;
    }

    function create_invoice_tr($class,$metric){
        $html = '<tr class="'.$class.'"><th scope="col" class="nm">No</th><th scope="col" class="pn">Product Name</th><th scope="col" class="dm">Dimension ('.$metric.') </th><th scope="col" class="stc">Structure Color</th><th scope="col" class="cvc">Cover Option</th><th scope="col" class="ma">Motor Automation</th><th scope="col" class="des">Description</th><th scope="col" class="qt">Qty</th><th scope="col" class="up">Unit Price</th><th scope="col" class="tp">Total Price</th><th scope="col"></th></tr>';
        return $html;
    }


    
    function select_for_sproduct($name,$classname,$optionlist,$mainproduct,$increment,$isoptionlist = array()){
        $mainproductid = $mainproduct->id;
        $options = array(''=>'Select');       
        foreach ($optionlist as $product) {
            $options[$product->id] = $product->title;                          
        }     
        return form_dropdown($name, $options, $mainproduct->sproduct,' aria-label="Select" data-allow-clear="true" data-control="select2" data-placeholder="Select" class="form-select  form-select-lg fw-bold  rounded-0 '.$classname.'" data-row-id="'.$increment.'" data-id="'.$mainproductid.'" ');
    }

    function select_for_scolor($name,$classname,$optionlist,$mainproduct,$increment,$isoptionlist = array()){
        $mainproductid = $mainproduct->id;
        $options = array(''=>'Select');   
        foreach ($optionlist as $product) {
            $options[$product->id] = $product->title;                          
        }     
        return form_dropdown($name, $options, $mainproduct->scolor,' aria-label="Select" data-allow-clear="true" data-control="select2" data-placeholder="Select" class="form-select form-select-lg fw-bold  rounded-0 '.$classname.'" data-row-id="'.$increment.'" data-id="'.$mainproductid.'" ');
    }

    function select_for_fcolor($name,$classname,$optionlist,$mainproduct,$increment,$isoptionlist = array()){
        $mainproductid = $mainproduct->id;
        $options = array(''=>'Select');   
        foreach ($optionlist as $product) {
            $catelang= get_langer('colorcats',8,$product);
            if(is_array($isoptionlist)){
                $a_options = array();
                foreach ($isoptionlist as $color) {
                    if ($product == $color->category) {      
                        $a_options[$color->id] = $color->title.' / '.$color->category;
                    }
                }
                $options[$catelang->title] = $a_options;
            }       
        }
        return form_dropdown($name, $options, $mainproduct->fcolor,' aria-label="Select" data-allow-clear="true" data-control="select2" data-placeholder="Select" class="form-select form-select-lg fw-bold  rounded-0 '.$classname.'" data-row-id="'.$increment.'" data-id="'.$mainproductid.'" ');
    }

    function options_for_fcolor($optionlist,$isoptionlist,$mainproduct = null){
        error_reporting(1);
        $string = '<option value="">SELECT</option>';
        //$string = '';        
        foreach ($optionlist as $product) {
            $catelang= get_langer('colorcats',8,$product);
            if(is_array($isoptionlist)){
                $string .= '<optgroup label="'.$catelang->title.'">';
                foreach ($isoptionlist as $color) {
                    if ($product == $color->category) {
                        $string .= '<option value="'.$color->id.'"';
                        if ($color->id == $mainproduct->fcolor) {
                            $string .= ' selected="" ';
                        }
                        $string .= ' >'.$color->title.' / '.$color->category.'</option>';
                    }
                }
                $string .= '</optgroup>';
            }
            $a_options[$color->id] = $color->title.' / '.$color->category;
            $options[$catelang->title] = $a_options;         
        }
        return $string;
    }
    

    function select_for_invoice_fields($name,$classname,$optionlist,$mainproduct,$increment,$isoptionlist = array()){
        $mainproductid = $mainproduct->id;        
        $string .= '<select data-row-id="'.$increment.'" data-id="'.$mainproductid.'" name="'.$name.'" id="'.$name.'_'.$mainproductid.'" style="width: 100%;" class="'.$classname.'">';
        $string .= '<option value="">SELECT</option>';        
        foreach ($optionlist as $product) {
            if($name == "sproduct") {
                $string .= '<option value="'.$product->id.'"';
                if ($product->id == $mainproduct->sproduct) {
                        $string .= ' selected="" ';
                }            
                $string .= ' >'.$product->title.'</option> ';
            }
            else if($name == "scolor") {                
                $string .= '<option value="'.$product->id.'"';
                if ($product->id == $mainproduct->scolor) {
                        $string .= ' selected="" ';
                }            
                $string .= ' >'.$product->title.'</option> ';
            }
            else if($name == "fcolor") {
                $catelang= get_langer('colorcats',8,$product); 
                $string .= '<option style="font-weight:bold" disabled">'.$catelang->title.'</option>';
                foreach ($isoptionlist as $color) {
                    if ($product == $color->category) {
                        $string .= '<option value="'.$color->id.'"';
                        if ($color->id == $mainproduct->fcolor) {
                            $string .= ' selected="" ';
                        }
                        $string .= ' >'.$color->title.' / '.$color->category.'</option>';
                    }
                }      
            }              
        }
        $string .= '</select>';               
        return $string;                                                            
    }
    
    function select_for_invoice ($ort,$list,$field,$field_name,$write) {
        
        
        
        $string = '<select aria-label="Select" data-allow-clear="true" data-control="select2" data-placeholder="Select" class="form-select  form-select-lg fw-bold  mt-5  rounded-0"  name="'.$write.'" required>';
        $string .= '<option value="" >Select</option>'; 
                        
        if($ort){
                foreach($ort as $set_cat){ 
                                    
        $string .= '<optgroup label="'.$set_cat->title.'">';                            
                                  
                                    
                    foreach($list as $set_item){ 
                                            
                        $selected = '';
                        if($field){
                            if($set_item->id==$field){
                                        $selected = 'selected="selected"';
                            }
                        }
                                       
                                            
                                            if ($set_cat->id == $set_item->parent_id) {
                                            
                                        
        $string .= '<option value="'.$set_item->id.'" '.$selected.' >'.$set_item->title.'</option>';                                    
                                            
                                 }} 
                                            
        $string .= '</optgroup>';                                
                                        
                    }}
        
        $string .= '</select>';                        
                            
        
        
        return $string;
        
        
        
        
        
        
    }
    
    
    function select_employees ($field,$field_name,$write,$name,$surname,$where) {
        
        
        $db = \Config\Database::connect();
        
        $builder = $db->table('employees');
        $builder->where($where);
        $builder->orderBy('order', 'asc');
        
        $query  = $builder->get();
        
        $list = $query->getResult();
        
        
        $string = '<div class="form-group">';
        $string .= '<label class="col-lg-2 control-label">'.$field_name.'</label>';
        $string .= '<div class="col-lg-10">';
        $string .= '<select class="form-control rounded-0" name="'.$write.'" >';
                        
        $string .= '<option value="">Select</option>';                          
                                  
                                    
                    foreach($list as $set_item){ 
                                            
                        $selected = '';
                        if($field){
                            if($set_item->id==$field){
                                        $selected = 'selected="selected"';
                            }
                        }
                        
                        
                                            
                        $string .= '<option value="'.$set_item->id.'" '.$selected.' >'.$set_item->{$name}.' '.$set_item->{$surname}.'</option>';                                    
                                            
                                 } 
                                            
        
        
        $string .= '</select></div></div>';                        
                            
        
        
        return $string;
        
        
        
    }
    
    
                             
    function select_existing_only ($list,$field,$field_name,$write,$name) {
        
        
        $string = '<div class="form-group">';
        $string .= '<label class="col-lg-2 control-label">'.$field_name.'</label>';
        $string .= '<div class="col-lg-10">';
        $string .= '<select class="form-control rounded-0" name="'.$write.'" >';
        $string .= '<option value="" >Select</option>'; 
                        
                                  
                                  
                                    
                    foreach($list as $set_item){ 
                                            
                        $selected = '';
                        if($field){
                            if($set_item->id==$field){
                                        $selected = 'selected="selected"';
                            }
                        }
                        
                        
                                            
                        $string .= '<option value="'.$set_item->id.'" '.$selected.' >'.$set_item->{$name}.'</option>';                                    
                                            
                                 } 
                                            
        
        
        $string .= '</select></div></div>';                        
                            
        
        
        return $string;
        
        
        
        
        
        
    }             
    
    function select_existing_only_name ($list,$field,$field_name,$write) {
        
        
        $string = '<div class="form-group">';
        $string .= '<label class="col-lg-2 control-label">'.$field_name.'</label>';
        $string .= '<div class="col-lg-10">';
        $string .= '<select class="form-control rounded-0" name="'.$write.'" required>';
        $string .= '<option value="" >Select</option>'; 
                        
                                  
                                  
                                    
                    foreach($list as $set_item){ 
                                            
                        $selected = '';
                        if($field){
                            if($set_item->id==$field){
                                        $selected = 'selected="selected"';
                            }
                        }
                        
                        
                                            
                        $string .= '<option value="'.$set_item->id.'" '.$selected.' >'.$set_item->name.'</option>';                                    
                                            
                                 } 
                                            
        
        
        $string .= '</select></div></div>';                        
                            
        
        
        return $string;
        
        
        
        
        
        
    } 
    
    function checkPermission($table,$array){
    $CommanModel = new CommanModel();
    $check = $CommanModel->get_by($table,$array,false,false,true);
    if($check){
        return 1;
    }
    else{
        return 0;
    }
}

?>
