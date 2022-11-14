<?php

namespace App\Core;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Files\File;

use Psr\Log\LoggerInterface;

use App\Models\backend\Accountmodel;
use App\Models\backend\Languagemodel;
use App\Models\Commanmodel;

class Admincontroller extends Controller  
{
    protected $AccountModel;
    protected $CommanModel;
    protected $LanguageModel;
    protected $admin_request;

    public function __construct()
    {

        date_default_timezone_set("Asia/Baku");
	$this->helpers = array('comman', 'language', 'admin', 'text','cookie','url','form'); 
	helper($this->helpers);

        $this->AccountModel     = new Accountmodel();
        $this->CommanModel      = new Commanmodel();
        $this->LanguageModel      = new Languagemodel();

	$this->db = \Config\Database::connect();

        $this->data['session'] = \Config\Services::session();
	$this->data['validation'] =  \Config\Services::validation();
        $this->data['set_meta'] = '';
        $this->data['admin_lang'] = $this->LanguageModel->get_default_id();
        $this->data['website_settings'] = $this->CommanModel->get_lang('l_settings', $this->data['admin_lang'], NULL, array('id' => 1), 'connlang_id', true); 
        $this->data['name'] = '';
        $this->data['active'] = 'home';
        $this->data['active_sub'] = '';
        $this->data['admin_link'] = 'manage';
        $this->data['branch_link'] = 'branch';

	$this->data['validationerrors'] = '';

        $detail = $this->data['session']->get();

	$this->data['adminDetails'] =  array();
        if (isset($detail['adminSession']['id'])) {
            $this->data['adminDetails'] =  $this->CommanModel->get_by('admin', array('id' => $detail['adminSession']['id']), FALSE, FALSE, TRUE);
        }

	//pp($this->data['adminDetails']);

	
        $exception_uris = array(
            $this->data['admin_link'] . '/account/login',
            $this->data['admin_link'] . '/Account/login'
        );

	    $this->admin_request = \Config\Services::request();
	    $this->data['request'] = $this->admin_request;
	    $this->postdata = $this->admin_request->getPost();
	    $this->getdata = $this->admin_request->getGet();
	$this->files = $this->admin_request->getFiles();


        
        
        $checkexception = uri_string();
        if (in_array($checkexception, $exception_uris) == FALSE) {
            $logged_in = $this->data['session']->get('adminSession');
	    if ((!isset($logged_in['loggedin']) || $logged_in['loggedin'] != true)) {
		echo '<h4 style="text-align:center;font-family:Arial;">You are not logged or seesion expired. Please go our <a href="/'.$this->data['admin_link'].'/account/login">Login</a> link<h4>';
               die();
	       
            }
	    
        }

	$this->data['admin_view_path'] = 'admin';
    $this->data['admin_assets'] = '/assets/manage';
	$this->data['uploads_folder'] = '/assets/uploads';
	$this->data['global_assets'] = '/assets';
	$this->data['list_rows'] = 50;
	$this->data['noimage'] = base_url('assets/uploads/no-image.gif');
	$this->data['addtocart'] = $this->data['admin_link'].'/loccart/addtocartstore';
	$this->data['removecart'] = $this->data['admin_link'].'/loccart/removecartstore';
	$this->data['listcart'] = $this->data['admin_link'].'/loccart/listcartstore';
	$this->data['_cartlink'] = $this->data['admin_link'].'/loccart';
	$this->data['_product_view'] = $this->data['admin_link'].'/locproducts/productview';
	$this->data['_products_list'] = $this->data['admin_link'].'/locproducts';
	$this->data['_storelink'] = $this->data['admin_link'].'/locstore';
	$this->data['_checkoutlink'] = $this->data['admin_link'].'/loccheckout';
	$this->data['_confirmorder'] = $this->data['admin_link'].'/loccheckout/confirmorder';
	$this->data['_darkmodeurl'] = $this->data['admin_link'].'/account/darkmode';
	$this->data['_searchpagesurl'] = $this->data['admin_link'].'/account/searchpages';
	$this->data['_recentsearchurl'] = $this->data['admin_link'].'/account/recentsearch';
	$this->data['_orderslink'] = $this->data['admin_link'].'/locorders';
	$this->data['_activitieslink'] = $this->data['admin_link'].'/activities';
	
	$this->data['all_sizes'] = $this->CommanModel->get_lang('locsize',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);
	$this->data['all_colors'] = $this->CommanModel->get_lang('loccolor',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);
	$this->data['all_categories'] = $this->CommanModel->get_lang('loccats',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);

	$this->data['pstatusoptions'] = array("Waiting"=>"Waiting","Preparing"=>"Preparing","Delivered"=>"Delivered");

	$this->data['global_ajax_list_url'] = '/global_ajax_list';
	$this->data['subview'] = $this->data['admin_view_path']."/includes/common/lists";
	$this->data['blank_array'] = array();
	$this->data['alllangs'] =  $this->CommanModel->getDatamwithlimit('language',$this->data['blank_array'],$this->data['blank_array'],$this->data['blank_array'],'',0,'all',false);
	$this->data['all_currencies'] = $this->CommanModel->getDatamwithlimit('currency',$this->data['blank_array'],$this->data['blank_array'],$this->data['blank_array'],'',0,'all',false);


	if (isset($detail['adminSession']['id'])) {
	    
	    $getuserdata = getuserdata();
	    $getuserrole = getuserrole();

	    $this->data['thisEmployee'] = get_langer('employees',false,$getuserdata->employee_id);
	    $this->data['thisbranch'] = get_langer('branches',$this->data['admin_lang'],$this->data['thisEmployee']->branch_id);
	    //pp($getuserdata);
	    if($getuserrole == 'Global Admin'){	
		$this->data['main_menu_array'] = globalmenu();
	    }
	    else if($getuserrole == 'Region Admin'){
		$blank_array = array();
		$region_id = $this->data['thisbranch']->region_id;
		$thisregion = get_langer('regions',$this->data['admin_lang'],$region_id);
		$reg_parent_id = $thisregion->parent_id;
		$mainthisregion = get_langer('regions',$this->data['admin_lang'],$reg_parent_id);
		$total_regions =  $this->CommanModel->getDatamwithlimit('regions',array('parent_id' => $reg_parent_id),$blank_array,$blank_array,'',0,'all',false);
		if(count($total_regions)>0){
		    
		    foreach($total_regions as $total_region){
			$region_ids[] = $total_region->id;
		    }
		    $r_ids = implode(",",$region_ids);
		    $region_branches =  $this->CommanModel->get_query("select GROUP_CONCAT(`id`) as totalbranches from `branches` where `region_id` IN (".$r_ids.")");
		    $totalbranches = explode(",",$region_branches[0]->totalbranches);

		    $region_employees =  $this->CommanModel->get_query("select GROUP_CONCAT(`id`) as totalemployees from `employees` where `branch_id` IN (".$region_branches[0]->totalbranches.")");
		    $totalemployees = explode(",",$region_employees[0]->totalemployees);

		    $this->data['session']->set('total_regions', $region_ids);
		    $this->data['session']->set('totalbranches_region', $totalbranches);
		    $this->data['session']->set('totalemployees_region', $totalemployees);
		    
		    
		}		
		$this->data['main_menu_array'] = branchmenu($this->data['thisbranch'],true);
	    }
	    else if($getuserrole == 'Region SubAdmin'){
		$blank_array = array();
		$region_id = $this->data['thisbranch']->region_id;
		$region_ids[] = $region_id;
		$r_ids = implode(",",$region_ids);
		$region_branches =  $this->CommanModel->get_query("select GROUP_CONCAT(`id`) as totalbranches from `branches` where `region_id` IN (".$r_ids.")");
		$totalbranches = explode(",",$region_branches[0]->totalbranches);
		$region_employees =  $this->CommanModel->get_query("select GROUP_CONCAT(`id`) as totalemployees from `employees` where `branch_id` IN (".$region_branches[0]->totalbranches.")");
		$totalemployees = explode(",",$region_employees[0]->totalemployees);
		$this->data['session']->set('total_regions', $region_ids);
		$this->data['session']->set('totalbranches_region', $totalbranches);
		$this->data['session']->set('totalemployees_region', $totalemployees);
		
		
				
		$this->data['main_menu_array'] = branchmenu($this->data['thisbranch'],true);
	    }
	    else if($getuserrole == 'Branch Group Admin'){
		
		
		$branchgrup_employees =  $this->CommanModel->get_query("select GROUP_CONCAT(`id`) as totalemployees from `employees` where `branch_id` IN (".$this->data['thisEmployee']->branch_id.")");
		$totalemployees = explode(",",$branchgrup_employees[0]->totalemployees);
		$totalbranches = array($this->data['thisEmployee']->branch_id);
		
		//$this->data['session']->set('total_regions', $region_ids);
		$this->data['session']->set('totalbranches_region', $totalbranches);
		$this->data['session']->set('totalemployees_region', $totalemployees);
		
		$this->data['main_menu_array'] = branchmenu($this->data['thisbranch'],true);
	    }
	    else if($getuserrole == 'Branch Admin'){
		$this->data['main_menu_array'] = branchmenu($this->data['thisbranch']);
	    }

	    
	    $this->data['checknamearray'] = array('branches','banners','partners','reviews','videos','currency','pmethods','socials','email');
	    $this->data['checkparent_array'] = array('regions','pdcats');
	    $this->data['checklangarray'] = array('admin','language','currency','pmethods','socials','email');
	}

		
    }

    function recentsearch(){
	$logged_in = $this->data['adminDetails'];
	$employeeid = $logged_in->employee_id;
	$where = array("employee"=>$employeeid);
	$postdata['view'] = 'recentsearch';

	$this->data['blank_array'] = array();
	$this->items['_thisData'] = $this->data;
	$this->items['postdata'] = $postdata;
	$this->items['topsearch'] =  $this->CommanModel->getDatamwithlimit('topsearch',$where,$this->data['blank_array'],$this->data['blank_array'],'created DESC',0,'20',false);
	$html = view('admin/includes/topmenu/searchlist', $this->items);
	$total = count($this->items['topsearch']);
	$jsonrerurn = json_encode(array(
		"status" => 'success',
		"html" => $html,
		"total" => $total
	    ));
	echo $jsonrerurn;
    }

    function referrecent(){
	if(!empty($this->getdata)) {
	    $getdata = $this->getdata;
	    $logged_in = $this->data['adminDetails'];
	    $employeeid = $logged_in->employee_id;
	    $this->CommanModel->saveData('topsearch',array('employee'=>$employeeid,'searchitem'=>$getdata['view']));
	    return redirect()->to($this->data['admin_link'].'/'.$getdata['view']);
	}	
    }
    
    function searchpages(){
	if(!empty($this->postdata)) {
	    $postdata = $this->postdata;
	    $postdata['view'] = 'searchresult';
	    $status = 'success';
	    $this->items['_thisData'] = $this->data;
	    $this->items['postdata'] = $postdata;
	    $html = view('admin/includes/topmenu/searchlist', $this->items);

	    $logged_in = $this->data['adminDetails'];
	    $employeeid = $logged_in->employee_id;
	    $where = array("employee"=>$employeeid);	    
	    $topsearch =  $this->CommanModel->getDatamwithlimit('topsearch',$where,$this->data['blank_array'],$this->data['blank_array'],'',0,'all',false);
	}
	else {
	    $status = 'error';
	    $html = 'Something not right.';
	}
	$jsonrerurn = json_encode(array(
		"status" => $status,
		"html" => trim($html),
		"total" => count($topsearch),
	    ));
	echo $jsonrerurn;
    }

    function darkmode(){
	error_reporting(0);
	$logged_in = $this->data['session']->get('adminSession');
	if (isset($logged_in['loggedin'])) {
	    if(!empty($this->postdata)) {
		$postdata = $this->postdata;
		$this->CommanModel->saveData('admin',array('theme_appearence'=>$postdata['dataid']),$logged_in['id']);
		$status = 'success';
		$html = ($postdata['dataid'] == 1)?'dark':'light';
	    }
	    else {
		$status = 'error';
		$html = 'Something not right.';
	    }
	}
	else {
	    $status = 'error';
	    $html = 'Something not right.';
	}
	$jsonrerurn = json_encode(array(
		"status" => $status,
		"html" => $html,
	    ));
	echo $jsonrerurn;
    }
    
    function global_ajax_list(){
	error_reporting(0);
	$where = array();
	$like  = array();
	$havingIn  = array();
	$langcondition  = array();
	$tablename = $this->data['_table_names'];

	if($tablename == 'setproject') {
	    $where = array('parent_id'=>0);
	}
	else {
	    $where = array();
	}
	$adminDetails = $this->data['adminDetails'];
	if($adminDetails->role == 'Branch Admin'){
	    $thisEmployee = get_langer('employees',false,$adminDetails->employee_id);
	    $thisbranch = get_langer('branches',$this->data['admin_lang'],$thisEmployee->branch_id);
	    
	    if($tablename == 'fromhome') {
		$ASKCOL = 'branch';
		$ASKVALUE = $thisbranch->id;
		$where= array($ASKCOL=>$ASKVALUE);
	    }
	    else if($tablename == 'setproject') {
		$ASKCOL = 'employee';
		$ASKVALUE = $adminDetails->employee_id;
		$where= array($ASKCOL=>$ASKVALUE,'parent_id'=>0);
	    }
	    else if($tablename == 'locorders') {
		$ASKCOL = 'ordered_user';
		$ASKVALUE = $adminDetails->employee_id;
		$where= array($ASKCOL=>$ASKVALUE);
	    }
	    else if($tablename == 'activitylogs') {
		$ASKCOL = 'employee';
		$ASKVALUE = $adminDetails->employee_id;
		$where= array($ASKCOL=>$ASKVALUE);
	    }
	    else if($tablename != 'tasks' && $tablename != 'employees') {
		$ASKCOL = 'branch_id';
		$ASKVALUE = $thisbranch->id;
		$where= array($ASKCOL=>$ASKVALUE);
	    }    
	    
	}

	
	
	
		 
	//pp($where);
	
	$wherefind = '';
	$is_join = '';
	if($this->postdata){
	    $postdata = $this->postdata;	    
	    foreach($postdata as $key=>$inputs){
		$columns = explode("_TYPE",$key);
		if($key != 'rowperpage' && $key != 'row' && $key != 'sect[]' && $inputs != ''){
		    $name 	= trim($columns[0]);
		    $searchtype = trim($columns[1]);
		    if($searchtype == 'where'){
			if($inputs != ''){
			    $where[$name] = $inputs;
			}
		    }
		    if($searchtype == 'wheredaterange'){
				if($inputs != ''){
					$checkdaterange = explode(" - ",$inputs);
					$startdaterange = $checkdaterange[0];
					$enddaterange = $checkdaterange[1];
					
					if($tablename == 'supportvisitors'){
						$where[$name.' >='] = $startdaterange;
						$where[$name.' <='] = $enddaterange;
					}
					else {
						$where[$name.' >'] = strtotime($startdaterange);
						$where[$name.' <'] = strtotime($enddaterange);
					}					
				}
		    }
		    
		    if($searchtype == 'like'){
			if($inputs != ''){
			    $like[$name] = $inputs;
			}
		    }
		    if($searchtype == 'joinlike'){
			if($inputs != ''){
			    $is_join = 'yes';
			    $langcondition[$name] = $inputs;
			    $langcondition['language_id'] = $this->data['admin_lang'];
			}
		    }
		    if($searchtype == 'findinset'){
			if($inputs != ''){
			    $wherefind =  "find_in_set('".$inputs."',".$name.")";
			    $where[$wherefind.' > '] = 0;
			}
		    }
		    if($searchtype == 'concat'){
			if($inputs != ''){
			    $contactexplode = explode("_CONCAT_",$name);
			    $wherefind =  "CONCAT(".$contactexplode[0].", ' ', ".$contactexplode[1].")";
			    $like[$wherefind] = $inputs;
			}
		    }
		    if($searchtype == 'having'){
			if($inputs != ''){
			    $bsenders = $this->CommanModel->get_lang('employees',false,false,array('branch_id'=>$inputs,'rep'=>1),'connlang_id',FALSE);
			    
			    foreach($bsenders as $bsend) {
				array_push($havingIn,$bsend->id);
			    }			    
			}
		    }
		    if($searchtype == 'custom'){
			if($inputs != ''){
			    $wherefind = $name;
			    if ($inputs == 'd') {
				$where[$wherefind]=null;
			    }
			    else if ($inputs == 's') {
				$where[$wherefind.' <>']=null;
			    }			    
			}
		    }
		    	    
		}
	    }
	    
	    
	    $row 	= $postdata['row'];
	    $rowperpage = $postdata['rowperpage'];
	    $viewdata = $this->data['viewdata'];
	    $default_sort = $viewdata['view_data']['default_sort'].' '.$viewdata['view_data']['default_sort_type'];

	    $this->items['_thisData'] = $this->data;
	    $this->items['_lang_table_names'] = $tablename."_lang";
	    if($tablename == 'features' || $tablename == 'bsections' || $tablename == 'sections'){
		$c_id 	= $postdata['c_id'];
		$where['category_id'] = $c_id;
	    }
	    
	    
	    if($tablename == 'tasks') {
		$this->items['objects'] = $this->CommanModel->get_emp_tasks_filter($tablename,$where,$havingIn,$like,'updated',$row,$rowperpage,false,$adminDetails->employee_id);
		$totalcount = $this->CommanModel->get_emp_tasks_filter($tablename,$where,$havingIn,$like,'updated',$row,'all',true,$adminDetails->employee_id);
	    }
	    else {
		$totalcount = $this->CommanModel->getDatamwithlimit($tablename,$where,$havingIn,$like,$default_sort,$row,'all',true,$is_join,$langcondition);
		$this->items['objects'] = $this->CommanModel->getDatamwithlimit($tablename,$where,$havingIn,$like,$default_sort,$row,$rowperpage,false,$is_join,$langcondition);
	    }

	    
	    //pp($where);
	    //pp($this->items['objects']);
	    $this->items['view_data'] = $viewdata['view_data'];

	    $this->items['admin_link'] = $this->data['admin_link'];
	    $this->items['_cancel'] = $this->data['_cancel'];
	    $this->items['_edit']   = $this->data['_edit'];
	    
	    
	    $html = view($this->data['_subView'].'ajax_list', $this->items);
	    $status = 'success';
	}
	else {
	    $totalcount = '0';
	    $html = 'Invalid request';
	    $status = 'error';
	}
	$jsonrerurn = json_encode(array(
		"status" => $status,
		"html" => $html,
		"totalcount"=>$totalcount
	    ));
	echo $jsonrerurn;
    }
 
    function checkchildlist(){
	$html = 'Something is not right';
	$status = 'error';
	if(!empty($this->postdata)) {            
            $postdata = $this->postdata;

	    $chosenfield = $postdata['chosenfield'];
	    
	    $tablename = $this->data['_table_names'];
	    
	    $is_join = 'yes';
	    $where['parent_id'] = $postdata['parent_id'];
	    $where['id != '] = $postdata['chosenfield'];
	    
	    $langcondition['language_id'] = $this->data['admin_lang'];			    
	    $objects = $this->CommanModel->getDatamwithlimit($tablename,$where,$this->data['blank_array'],$this->data['blank_array'],'order ASC',0,'all',false,$is_join,$langcondition);

	    $checkname = 'title';
	    $checknamearray = $this->data['checknamearray'];
	    if(in_array($tablename,$checknamearray)){
		$checkname = 'name';		
	    }
	    
	    $objects_1 = array();
	    foreach($objects as $values){
		$objects_1_array['id'] = $values->id;
		$objects_1_array['name'] = $values->{$checkname};
		array_push($objects_1,$objects_1_array);
	    }
	    
	    $this->items['objects_1'] = $objects_1;
	    $html = view('admin/includes/common/listchildinner', $this->items);
	    $status = 'success';	   
	    
	}
	$jsonrerurn = json_encode(array(
		"status" => $status,
		"html" => $html
	    ));
	echo $jsonrerurn;
    }
    
    function changelistorder(){
	$html = 'Something is not right';
	$status = 'error';
	if(!empty($this->postdata)) {            
            $postdata = $this->postdata;
	    $tablename = $this->data['_table_names'];

	    $is_join = 'yes';
	    $langcondition['language_id'] = $this->data['admin_lang'];
	    	
	    $checklangarray = $this->data['checklangarray'];
	    if(in_array($tablename,$checklangarray)){
		$is_join = '';	
	    }	    
	    
	    $segment_order = $postdata['segment_order'];
	    if($tablename == 'features' || $tablename == 'sections' || $tablename == 'bsections'){
			$where['category_id'] = $segment_order;
		}
	    	    
	    $objects = $this->CommanModel->getDatamwithlimit($tablename,$where,$this->data['blank_array'],$this->data['blank_array'],'order ASC',0,'all',false,$is_join,$langcondition);

	    
	    
	    $objects_1 = array();
	    $objects_2 = array();
	    $checkname = 'title';

	    $checknamearray = $this->data['checknamearray'];
	    if(in_array($tablename,$checknamearray)){
		$checkname = 'name';		
	    }
	    else if($tablename == 'admin'){
		$checkname = 'username';		
	    }
	    else if($tablename == 'language'){
		$checkname = 'language';		
	    }
	    

	    $is_parent = 0;
	    $this->items['textchoose'] = 'Choose Before/After Field';
	    $checkparent_array = $this->data['checkparent_array'];
	    if(in_array($tablename,$checkparent_array)){
		$this->items['textchoose'] = 'Choose Parent';
		$is_parent = 1;
	    }
	    
	    $this->items['is_parent'] = $is_parent;

	    if($is_parent == 1){
		foreach($objects as $values){
		    $objects_1_array['id'] = $values->id;
		    $objects_1_array['name'] = $values->{$checkname};
		    if($values->parent_id == '0'){
			$objects_2_array['id'] = $values->id;
			$objects_2_array['name'] = $values->{$checkname};
			array_push($objects_2,$objects_2_array);
		    }		    		    
		    array_push($objects_1,$objects_1_array);
		}
	    }
	    else {
		foreach($objects as $values){
		    $objects_1_array['id'] = $values->id;
		    $objects_1_array['name'] = $values->{$checkname};		
		    $objects_2_array['id'] = $values->id;
		    $objects_2_array['name'] = $values->{$checkname}; 
		    array_push($objects_2,$objects_2_array);
		    array_push($objects_1,$objects_1_array);
		}
	    }
	    //pp($objects,false);
	    //pp($objects_2);
	    $this->items['segment_order'] = $segment_order;
	    $this->items['objects_1'] = $objects_1;
	    $this->items['objects_2'] = $objects_2;	   
	    $html = view('admin/includes/common/changelistorderbody', $this->items);
	    $status = 'success';	   
	    
	}
	$jsonrerurn = json_encode(array(
		"status" => $status,
		"html" => $html
	    ));
	echo $jsonrerurn;
    }

    function changeordersave(){
	if(!empty($this->postdata)) {            
            $postdata = $this->postdata;

	    
	    $tablename = $this->data['_table_names'];
	    $action_type = $postdata['action_type'];
	    $select_position = $postdata['select_position'];
	    $choose_field = $postdata['choose_field'];
	    $select_position_child = isset($postdata['select_position_child'])?($postdata['select_position_child']):'';
	    
	    $blank_array = array();
	    $where['id != '] = $choose_field;
	    
	    $segment_order = $postdata['segment_order'];
	    if($tablename == 'features' || $tablename == 'sections' || $tablename == 'bsections'){
			$where['category_id'] = $segment_order;
		}
		
	    //$where = array();
	    $thisitem = $this->CommanModel->getDatamwithlimit($tablename,$where,$blank_array,$blank_array,'order ASC',0,'all',false);

	    if(count($thisitem)>0){
		foreach($thisitem as $item){
		    $fieldsarray[] = $item->id;
		}
		$newarray = $fieldsarray;		
		$checkitem = $select_position;
		
		$addparent = 0;
		if($select_position_child != ''){
		    $checkitem = $select_position_child;
		    $addparent = $select_position;
		}

		$findelementkey = array_search ($checkitem, $newarray);		
		if($action_type == 1){
		    $replacekeynumber = $findelementkey+1;
		}
		else {
		    $replacekeynumber = $findelementkey;
		}		
		array_splice($newarray, $replacekeynumber, 0, $choose_field);

		$updatearray = array();
		$counterset = 1;
	
		foreach($newarray as $chooseids){
		    if($chooseids === $choose_field){
			$updateids['parent_id'] = $addparent;
			$updateids['id'] = $chooseids;
			$updateids['order'] = $counterset;
		    }
		    else {
			$updateids['id'] = $chooseids;
			$updateids['order'] = $counterset;
			unset($updateids['parent_id']);
		    }
		    array_push($updatearray,$updateids);
		    $counterset++;
		}
		$this->CommanModel->batchupdatedata($tablename,$updatearray,'id');	
		$status = 'success';
	    }
	    else {
		$status = 'error';
		$html = 'No data found.';
	    }
	}
	else {
	    $status = 'error';
	    $html = 'Invalid Request.';
	}
	$jsonrerurn = json_encode(array(
		"status" => $status,
		"html" => $html
	    ));
	echo $jsonrerurn;	
    }
    
    function uploadmedia(){
	$ret['result']= 'error';	
	if(!empty($this->postdata)) {            
            $postdata = $this->postdata;
	    //echo $this->data['uploadFolder'];die;
	    $connfile_id = $postdata['id'];
	    $uploaded_files = array();
	    if ($imagefile = $this->admin_request->getFiles()) {
		foreach($imagefile['file'] as $img) {
		    if ($img->isValid() && ! $img->hasMoved()) {
			$newname = $this->data['website_settings']->keyname.$img->getRandomName();
			$img->move($this->data['uploadFolder'].'/',$newname);
			$uploaded_files[] = $newname;
		    }
		}
	    }
	    if(count($uploaded_files)>0){
		$ret['result']= 'success';
		foreach($uploaded_files as $filename) {		    
		    $ret['msg']= $uploaded_files;
		    $ret['id'] = $this->CommanModel->saveData('files', array('section'=>$this->_table_names,'connfile_id'=>$connfile_id,'filename'=>$filename));
		}
		$ret['target_file']= implode(",",$uploaded_files);

		$d_action = 'New files added for table <b>'.$this->_table_names.'</b>.';		
		$logged_in = $this->data['adminDetails'];
		$employeeid = $logged_in->employee_id;
		$insertactivity['employee'] = $employeeid;
		$insertactivity['d_action'] = $d_action;
		$insertactivity['created']  = date("Y-m-d H:i:s");
		activitylogs($insertactivity,'insert');
	    
	    }
	}
	echo json_encode($ret);
    }

    function mediafiles(){
	$ret['result']= 'error';
	$ret['target_file']= 'target_file';
	if(!empty($this->postdata)) {            
            $postdata = $this->postdata;
	    $id = $postdata['id'];
	    $uploaded_files = array();	    
	    if ($img = $this->request->getFile('file')) {
		$newname = $this->data['website_settings']->keyname.$img->getRandomName();
		$img->move($this->data['uploadFolder'].'/',$newname);
		$uploaded_files = $newname;		
		$this->CommanModel->savemanually('files',array('pdfname'=>$uploaded_files,'link'=>$this->data['uploadFolder'].'/'.$uploaded_files),$id);
		
		$ret['result']= 'success';
		$ret['target_file']= $uploaded_files;	   
	    }
	}
	echo json_encode($ret);
    }

    function getmediadata(){
	$result['status']= 'error';
	if(!empty($this->postdata)) {            
            $postdata = $this->postdata;
	    $id = $postdata['ID'];
	    $mainid = $postdata['mainid'];
	    $tablename = $this->data['_table_names'];
	    $where = array('section'=>$tablename,'id'=>$id);
	    $moreFiles = $this->CommanModel->getDatamwithlimit('files',$where,$this->data['blank_array'],$this->data['blank_array'],'',0,'all',false);
	    if(count($moreFiles)>0){
		$this->items['_cancel'] = $this->data['_cancel'];
		$this->items['files'] = $moreFiles[0];
		$this->items['uploadFolder'] = $this->data['uploadFolder'];
		$this->items['id'] = $id;
		$this->items['alllangs'] = $this->data['alllangs'];
		$this->items['files_lang'] = 'files_lang';
		$this->items['mainid'] = $mainid;
		$html = view('admin/includes/common/mediabody', $this->items);
		$result['status'] = 'success';
		$result['html'] = $html; 
	    }
	}
	echo json_encode($result);
    }
    
    function chekmorefiles($id){	
	$tablename = $this->data['_table_names'];
	$where = array('section'=>$tablename,'connfile_id'=>$id);
	$moreFiles = $this->CommanModel->getDatamwithlimit('files',$where,$this->data['blank_array'],$this->data['blank_array'],'order ASC',0,'all',false);
	//pp($moreFiles);
	$result['status'] = 'error';
	if(count($moreFiles)>0){
	    $this->items['files'] = $moreFiles;
	    $this->items['uploadFolder'] = $this->data['uploadFolder'];
	    $html = view('admin/includes/common/listimage', $this->items);
	    $result['status'] = 'success';
	    $result['html'] = $html; 
	}
	header('Content-Type: application/json');
	$jsonrerurn = json_encode($result);
	echo $jsonrerurn;
    }
    
    public function change_crm_status() { 
        
        
        $output = array();
		$output['status']= 'error';
		$output['message']= 'there is no data';
		$status = $this->request->getVar('status');
		$id = $this->request->getVar('id');
		
		
		if($id){
			$check_user = $this->CommanModel->get_by($this->_table_names,array('id'=>$id),false,false,true);
			
			
			if($check_user){
			    
			    
			    
				$output['status']= 'ok';
				$output['message']= '';
				
				$db = \Config\Database::connect();
				$builder = $db->table($this->_table_names);
				$builder->where('id', $check_user->id);
				
				
				$builder->set('view',$status);
					
				
				$builder->update();
			}
		}
		echo json_encode($output);
	
        
        
		
		
		$d_action = 'Status Changed to <b>'.$status.'</b> in '.$this->_table_names.'#'.$check_user->id;	 	
		$logged_in = $this->data['adminDetails'];
		$employeeid = $logged_in->employee_id;
		$insertactivity['employee'] = $employeeid;
		$insertactivity['d_action'] = $d_action;
		$insertactivity['created']  = date("Y-m-d H:i:s");
		activitylogs($insertactivity,'insert');
        
        
        
        
        
    }
    
    public function orderAjax ()
    {
	$postdata = $this->postdata;
        // Save order from ajax call
        if (isset($postdata['sortable'])) {
            $this->data['ThisModule']->saveOrder($postdata['sortable']);
        }

        // Fetch all pages
        $this->data['thisItems'] = $this->data['ThisModule']->getNested($this->data['admin_lang'],$this->data['withoutlang'],array());
        

        // Load view
        echo view($this->_subView.'/order_ajax', $this->data);
    }
    
    
    public function filterAjax ()
    {
        
        
        
        $data['dates'] = explode(' - ',$this->request->getVar('daterange'));
        
        $data['min'] = strtotime($data['dates'][0]);
        $data['max'] = strtotime($data['dates'][1])+24*3600;
        
        
        $where = array('created >' => $data['min'],'created <' => $data['max']);
        
        

        // Fetch all pages
        $this->data['thisItems'] = $this->data['ThisModule']->getLast($this->data['admin_lang'],$this->data['withoutlang'],$where); 
        

        // Load view
        echo view($this->_subView.'/order_ajax', $this->data);
    }
    
    
    function view($id = NULL) 
    {
        if($id)
        {
            $this->data['name'] = 'View '.$this->data['_title_call'];
            $this->data['title'] = $this->data['name'];
	    $where['id'] = $id;
            $items = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$this->data['blank_array'],$this->data['blank_array'],'',0,'all',false);
	    if(count($items)>0){
		$this->data['thisItems'] = $items[0];
	    }
	}
        //set load view
        $this->data['subview'] = $this->_subView.'view';
        echo view('admin/_layout_main', $this->data);
    }
    
    
    function updateLang () {
        
        $tablename = 'branches_lang';
        
        $id = $this->request->getPost('id');
        
        $db = \Config\Database::connect();
        
        
        $tables = $db->listTables();

        foreach ($tables as $table)
        {
            

            
           if(strpos($table, '_lang') !== false) {
    
            
            //print_r($table.'---'); 
    
        $builder = $db->table($table);
		$builder->where('language_id', 8);
		
		$items = $builder->get()->getResultArray();
		
		
		foreach ($items as $item) {
		    
		    $db = \Config\Database::connect();
		    $builder = $db->table($table);
		    $builder->where(array('language_id'=>$id,'connlang_id'=>$item['connlang_id']));
		    
		    
		    $check = $builder->get()->getResultArray();
		    
		    if ($check) {} else {
		    $data = $item;
		    $data['lid'] = NULL;
		    $data['language_id'] = $id;
		    
		    if($builder->insert($data)) {
		        
		        echo 'Data inserted';
		        
		        
		    }
		    
		    
		    
		    }
		    
		    
		}
		
		
	
           }
            
        }
        
 
        
    }
    
    
    function change_branch(){
		$output = array();
		$output['status']= 'error';
		$output['message']= 'there is no data';
		$branch_id = $this->request->getVar('branch_id');
		$id = $this->request->getVar('id');
		
		
		if($id){
			$check_user = $this->CommanModel->get_by($this->_table_names,array('id'=>$id),false,false,true);
			
			
			if($check_user){
			    
			    $this->data['oldbranch'] =  $this->CommanModel->get_by('branches', array('id' => $check_user->branch_id), FALSE, FALSE, TRUE);
			    
				$output['status']= 'ok';
				$output['message']= '';
				
				$db = \Config\Database::connect();
				$builder = $db->table($this->_table_names);
				$builder->where('id', $check_user->id);
				
				
				$builder->set('branch_id',$branch_id);
				$builder->set('view',0);
					
				
				$builder->update();
			}
		}
		echo json_encode($output);
	
        
        if ($branch_id) {
		
		    $this->data['branch'] =  $this->CommanModel->get_by('branches', array('id' => $branch_id), FALSE, FALSE, TRUE);
		    $this->CommanModel->sendmail(14,$this->data['branch']->email,$data);
		
		}
		
		
		$d_action = 'Branch Changed from <b>'.$this->data['oldbranch']->name.'</b> to <b>'.$this->data['branch']->name.'</b> in '.$this->_table_names.'#'.$check_user->id;		
		$logged_in = $this->data['adminDetails'];
		$employeeid = $logged_in->employee_id;
		$insertactivity['employee'] = $employeeid;
		$insertactivity['d_action'] = $d_action;
		$insertactivity['created']  = date("Y-m-d H:i:s");
		activitylogs($insertactivity,'insert');
        
    }
    
    
    
    
    public function byshow(){
	    $column = $this->request->getPost('column');
		
		
		  // Fetch all pages
        $this->data['thisItems'] = $this->data['ThisModule']->getLast($this->data['admin_lang'],$this->data['withoutlang'],array('archive'=>1)); 
        

        // Load view
        echo view($this->_subView.'/order_ajax', $this->data);
    }
    
    
    function ajaxupload(){	//upload more img
        $id = $this->request->getPost('id');
        $connfile_id = $this->request->getPost('connfile_id');
        $ret =array();
        $config['upload_path'] = './'.$this->data['uploadFolder'];
        $config['allowed_types'] = '*';

        $validated = $this->validate([
            'myfile' => [
                'uploaded[myfile]',
                //'mime_in[myfile,image/gif,image/jpg,image/png,image/jpeg,image/bmp,image/GIF,image/JPG,image/JPEG,image/BMP]',
                'max_size[myfile,60000]',
                'max_dims[myfile,5000,5000]',
            ],
        ]);

        if ($validated) {
            $avatar = $this->request->getFile('myfile');
            $newname = $this->data['website_settings']->keyname.$avatar->getRandomName();
            $avatar->move($this->data['uploadFolder'].'/',$newname);

            $ret['result']= 'success';
            $ret['msg']= $avatar->getName();
            $ret['id'] = $this->CommanModel->saveData('files', array('section'=>$this->_table_names,'connfile_id'=>$connfile_id,'filename'=>$newname));
        } else {
            $ret['result']= 'error';
            $ret['msg']= 'Invalid file for upload!';
        }
        echo json_encode($ret);
    }

    function ajaxuploadNew(){	//upload more img
        
        $id = $this->request->getPost('id');
        $connfile_id = $this->request->getPost('connfile_id');
        $id = $this->request->getPost('image_id');
        
        $ret =array();
        $config['upload_path'] = './'.$this->data['uploadFolder'];
        $config['allowed_types'] = '*';

        $validated = $this->validate([
            'myfile' => [
                'uploaded[myfile]',
                'mime_in[myfile,image/gif,image/jpg,image/png,image/jpeg,image/bmp,image/GIF,image/JPG,image/JPEG,image/BMP]',
               // 'max_size[myfile,60000]',
                //'max_dims[myfile,5000,5000]',
            ],
        ]);
        
        
        // if($this->request->getPost('old_file_name') != "")
        // {
        //     $image = $this->data['uploadFolder'].'/'.$this->request->getPost('old_file_name');
        //     unlink($image);
        // }
    
        
        $check_image = $this->CommanModel->get_by('files',array('section'=>$this->_table_names,'id'=>$id),false,false,true);
        
        $avatar = $this->request->getFile('myfile');
        
        $name = $avatar->getName();
        $size = $avatar->getSize();
        $image_type = $avatar->getMimeType();
        $newname = $name;
        $avatar->move($this->data['uploadFolder'].'/',$newname);
        
        $data['filename'] = $newname;
        
        if($check_image->pdfname != "")
        {
            if(file_exists($this->data['uploadFolder'].'/'.$check_image->pdfname))
            {
                $image = $this->data['uploadFolder'].'/'.$check_image->pdfname;
                unlink($image);
            }    
        }
       
        
        
        $ret['result'] = 'success';
        $ret['msg']    =  $avatar->getName();
        $ret['size']   = $size;
        $ret['old_name'] = $check_image->pdfname;
        $ret['image_type']   = $image_type;
        
        // $ret['id'] = $this->CommanModel->saveData('files',array('section'=>$this->_table_names,'pdfname' => $newname ),$id);
       
        echo json_encode($ret);
    }



    //refresh more images
    function refresh(){//set img html
        $id = $this->request->getPost('id');
        $connfile_id = $this->request->getPost('connfile_id');
        echo '<li class="item" id="more_image_'.$connfile_id.'" data-id="'.$connfile_id.'" >
			<div class="pi-img-wrapper">
			<img style="height:100px;width:100%" alt="" class="img-responsive" src="'.site_url().$this->data['uploadFolder'].'/'.$id.'"></a>
			</div>
			<div class="file-option" style="text-align:center">
			<button  class="btn btn-default" onclick="delete_image('.$connfile_id.')" href="javascript:void(0)" style="margin-top:10px">Delete</button>
			</div>
			</il>';
    }
    
    
    
   public function slugifier(){
    
    $txt = $this->request->getPost('text');
    
    $unwanted_array = array(
    '&amp;' => 'and',   '@' => 'at',    '©' => 'c', '®' => 'r', 'À' => 'a',
    'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'Å' => 'a', 'Æ' => 'ae','Ç' => 'c',
    'È' => 'e', 'É' => 'e', 'Ë' => 'e', 'Ì' => 'i', 'Í' => 'i', 'Î' => 'i',
    'Ï' => 'i', 'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Õ' => 'o', 'Ö' => 'o',
    'Ø' => 'o', 'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'Ý' => 'y',
    'ß' => 'ss','à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', 'å' => 'a',
    'æ' => 'ae','ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
    'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ò' => 'o', 'ó' => 'o',
    'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u',
    'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'þ' => 'p', 'ÿ' => 'y', 'Ā' => 'a',
    'ā' => 'a', 'Ă' => 'a', 'ă' => 'a', 'Ą' => 'a', 'ą' => 'a', 'Ć' => 'c',
    'ć' => 'c', 'Ĉ' => 'c', 'ĉ' => 'c', 'Ċ' => 'c', 'ċ' => 'c', 'Č' => 'c',
    'č' => 'c', 'Ď' => 'd', 'ď' => 'd', 'Đ' => 'd', 'đ' => 'd', 'Ē' => 'e',
    'ē' => 'e', 'Ĕ' => 'e', 'ĕ' => 'e', 'Ė' => 'e', 'ė' => 'e', 'Ę' => 'e',
    'ę' => 'e', 'Ě' => 'e', 'ě' => 'e', 'Ĝ' => 'g', 'ĝ' => 'g', 'Ğ' => 'g',
    'ğ' => 'g', 'Ġ' => 'g', 'ġ' => 'g', 'Ģ' => 'g', 'ģ' => 'g', 'Ĥ' => 'h',
    'ĥ' => 'h', 'Ħ' => 'h', 'ħ' => 'h', 'Ĩ' => 'i', 'ĩ' => 'i', 'Ī' => 'i',
    'ī' => 'i', 'Ĭ' => 'i', 'ĭ' => 'i', 'Į' => 'i', 'į' => 'i', 'İ' => 'i',
    'ı' => 'i', 'Ĳ' => 'ij','ĳ' => 'ij','Ĵ' => 'j', 'ĵ' => 'j', 'Ķ' => 'k',
    'ķ' => 'k', 'ĸ' => 'k', 'Ĺ' => 'l', 'ĺ' => 'l', 'Ļ' => 'l', 'ļ' => 'l',
    'Ľ' => 'l', 'ľ' => 'l', 'Ŀ' => 'l', 'ŀ' => 'l', 'Ł' => 'l', 'ł' => 'l',
    'Ń' => 'n', 'ń' => 'n', 'Ņ' => 'n', 'ņ' => 'n', 'Ň' => 'n', 'ň' => 'n',
    'ŉ' => 'n', 'Ŋ' => 'n', 'ŋ' => 'n', 'Ō' => 'o', 'ō' => 'o', 'Ŏ' => 'o',
    'ŏ' => 'o', 'Ő' => 'o', 'ő' => 'o', 'Œ' => 'oe','œ' => 'oe','Ŕ' => 'r',
    'ŕ' => 'r', 'Ŗ' => 'r', 'ŗ' => 'r', 'Ř' => 'r', 'ř' => 'r', 'Ś' => 's',
    'ś' => 's', 'Ŝ' => 's', 'ŝ' => 's', 'Ş' => 's', 'ş' => 's', 'Š' => 's',
    'š' => 's', 'Ţ' => 't', 'ţ' => 't', 'Ť' => 't', 'ť' => 't', 'Ŧ' => 't',
    'ŧ' => 't', 'Ũ' => 'u', 'ũ' => 'u', 'Ū' => 'u', 'ū' => 'u', 'Ŭ' => 'u',
    'ŭ' => 'u', 'Ů' => 'u', 'ů' => 'u', 'Ű' => 'u', 'ű' => 'u', 'Ų' => 'u',
    'ų' => 'u', 'Ŵ' => 'w', 'ŵ' => 'w', 'Ŷ' => 'y', 'ŷ' => 'y', 'Ÿ' => 'y',
    'Ź' => 'z', 'ź' => 'z', 'Ż' => 'z', 'ż' => 'z', 'Ž' => 'z', 'ž' => 'z',
    'ſ' => 'z', 'Ə' => 'e', 'ƒ' => 'f', 'Ơ' => 'o', 'ơ' => 'o', 'Ư' => 'u',
    'ư' => 'u', 'Ǎ' => 'a', 'ǎ' => 'a', 'Ǐ' => 'i', 'ǐ' => 'i', 'Ǒ' => 'o',
    'ǒ' => 'o', 'Ǔ' => 'u', 'ǔ' => 'u', 'Ǖ' => 'u', 'ǖ' => 'u', 'Ǘ' => 'u',
    'ǘ' => 'u', 'Ǚ' => 'u', 'ǚ' => 'u', 'Ǜ' => 'u', 'ǜ' => 'u', 'Ǻ' => 'a',
    'ǻ' => 'a', 'Ǽ' => 'ae','ǽ' => 'ae','Ǿ' => 'o', 'ǿ' => 'o', 'ə' => 'e',
    'Ё' => 'jo','Є' => 'e', 'І' => 'i', 'Ї' => 'i', 'А' => 'a', 'Б' => 'b',
    'В' => 'v', 'Г' => 'g', 'Д' => 'd', 'Е' => 'e', 'Ж' => 'zh','З' => 'z',
    'И' => 'i', 'Й' => 'j', 'К' => 'k', 'Л' => 'l', 'М' => 'm', 'Н' => 'n',
    'О' => 'o', 'П' => 'p', 'Р' => 'r', 'С' => 's', 'Т' => 't', 'У' => 'u',
    'Ф' => 'f', 'Х' => 'h', 'Ц' => 'c', 'Ч' => 'ch','Ш' => 'sh','Щ' => 'sch',
    'Ъ' => '-', 'Ы' => 'y', 'Ь' => '-', 'Э' => 'je','Ю' => 'ju','Я' => 'ja',
    'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e',
    'ж' => 'zh','з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l',
    'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's',
    'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
    'ш' => 'sh','щ' => 'sch','ъ' => '-','ы' => 'y', 'ь' => '-', 'э' => 'je',
    'ю' => 'ju','я' => 'ja','ё' => 'jo','є' => 'e', 'і' => 'i', 'ї' => 'i',
    'Ґ' => 'g', 'ґ' => 'g', 'א' => 'a', 'ב' => 'b', 'ג' => 'g', 'ד' => 'd',
    'ה' => 'h', 'ו' => 'v', 'ז' => 'z', 'ח' => 'h', 'ט' => 't', 'י' => 'i',
    'ך' => 'k', 'כ' => 'k', 'ל' => 'l', 'ם' => 'm', 'מ' => 'm', 'ן' => 'n',
    'נ' => 'n', 'ס' => 's', 'ע' => 'e', 'ף' => 'p', 'פ' => 'p', 'ץ' => 'C',
    'צ' => 'c', 'ק' => 'q', 'ר' => 'r', 'ש' => 'w', 'ת' => 't', '™' => 'tm',
);
    
   $txt = strtr( $txt, $unwanted_array );

   /* Lowercase all the characters */
   $txt = strtolower($txt);

   /* Avoid whitespace at the beginning and the ending */
   $txt = trim($txt);

   /* Replace all the characters that are not in a-z or 0-9 by a hyphen */
   $txt = preg_replace("/[^a-z0-9]/", "-", $txt);
   /* Remove hyphen anywhere it's more than one */
   $txt = preg_replace("/[\-]+/", '-', $txt);
   return $txt;   
} 


    //order more images
    public function fileOrder(){
	$data = array();
	$getdata = $this->getdata;
	$id = $getdata['connfile_id'];
	$files_order = $getdata['order'];	    
	$files = $this->CommanModel->get_by('files',array('section'=>$this->_table_names,'connfile_id' => $id),false,false,false);
	//pp($files);
	foreach($files_order as $order=>$filename){
	    foreach($files as $file)
	    {
		if($filename == $file->id){
		    $this->CommanModel->saveData('files',array('section'=>$this->_table_names,'order' => $order,),$file->id);
		    break;
		}
	    }
	}
        echo json_encode($data);
    }


    //remove more images
    function deleteImage(){
        $id = $this->request->getPost('id');
        $check_image = $this->CommanModel->get_by('files',array('section'=>$this->_table_names,'id'=>$id),false,false,true);
        if($check_image){
            $this->CommanModel->deleteData('files',array('section'=>$this->_table_names,'id'=>$id));
            $image = $this->data['uploadFolder'].'/'.$check_image->filename;
            if(is_file($image))
                unlink($image);
        }
    }
    
    
   //video link images
    function linkmedia(){
	$result['status'] = 'error';
	if(!empty($this->postdata)) {            
            $postdata = $this->postdata;	    
	    $id = $postdata['id'];
	    $mainid = $postdata['mainid'];
	    $description = $postdata['description'];
	    $filetype = $postdata['filetype'];
	    $pdfname = $postdata['pdfname'];
	    $data['section'] = $this->data['_table_names'];
	    $data['pdfname'] = $pdfname;
	    $data['description'] = $description;
	    $data['filetype'] = $filetype;
	    $data['link'] = $this->data['uploadFolder'].'/'.$pdfname;	    
	    $this->CommanModel->savemanually('files',$data,$id);	     
	    foreach($this->data['alllangs'] as $langs){
		$data_lang['connlang_id'] = $id;
		$data_lang['language_id'] = $langs->id;
		$data_lang['title'] = $postdata["title_".$langs->id];
		$data_lang['body'] = $postdata["body_".$langs->id];
		$this->db->table('files_lang')->delete(array('connlang_id' =>$data_lang['connlang_id'],'language_id' =>$data_lang['language_id']));
		$this->CommanModel->savemanually('files_lang',$data_lang,null,true);
	    }	   
	    $result['status'] = 'success';
	}
	echo json_encode($result);
    }
    
    


    //Remove main image
    public function removeImage($id=false){
        if(!$id)
            return redirect()->to(base_url().'/'.$this->data['_cancel']);

        $check = $this->CommanModel->get_by($this->_table_names,array('id'=>$id),false,false,true);
        if(!$check)
            return redirect()->to(base_url().'/'.$this->data['_cancel']);

        $db = \Config\Database::connect();
        $builder = $db->table($this->_table_names);
        $builder->where(array('id'=>$id));
        $builder->set('image', 'NULL', false);
        $builder->update();

        $file_full = $this->data['uploadFolder'].'/full/'.$check->image;
        $file_small = $this->data['uploadFolder'].'/small/'.$check->image;
        $file_thumbnails = $this->data['uploadFolder'].'/thumbnails/'.$check->image;
        if(is_file($file_full)){ unlink($file_full);}
        if(is_file($file_small)){ unlink($file_small);}
        if(is_file($file_thumbnails)){ unlink($file_thumbnails);}
        
        return redirect()->to(base_url().'/'.$this->data['_cancel'].'/edit/'.$id);
    }
    
    public function delete($id)	{
	
	$check = $this->CommanModel->get_by($this->_table_names,array('id'=>$id),false,false,true);
	if(!$check){
	    $this->data['session']->setFlashdata('error', 'No data found.');
            return redirect()->to($this->data['_cancel']);
	}	
	if(isset($checkitem->image)){
	    $file_full = $this->data['uploadFolder'].'/full/'.$check->image;
	    $file_small = $this->data['uploadFolder'].'/small/'.$check->image;
	    $file_thumbnails = $this->data['uploadFolder'].'/thumbnails/'.$check->image;
	    if(is_file($file_full)){ unlink($file_full);}
	    if(is_file($file_small)){ unlink($file_small);}
	    if(is_file($file_thumbnails)){ unlink($file_thumbnails);}
	}
        $this->data['ThisModule']->deleteData($id);

	$titledeleted = $this->_table_names;
	if($titledeleted != 'activitylogs'){
	    $d_action = 'Row from table <b>'.$titledeleted.'</b> deleted.';		
	    $logged_in = $this->data['adminDetails'];
	    $employeeid = $logged_in->employee_id;
	    $insertactivity['employee'] = $employeeid;
	    $insertactivity['d_action'] = $d_action;
	    $insertactivity['created']  = date("Y-m-d H:i:s");
	    activitylogs($insertactivity,'insert');
	}
	
	$this->data['session']->setFlashdata('success', 'Data has successfully deleted.');
        return redirect()->to($this->data['_cancel']);
    }
    
    
      function do_enable(){
		$output = array();
		$output['status']= 'error';
		$output['message']= 'there is no data';
		$getdata = $this->getdata;
		$id = $getdata['id'];
		
		
		if($id){
			$check_user = $this->CommanModel->get_by($this->_table_names,array('id'=>$id),false,false,true);
			if($check_user){
				$output['status']= 'ok';
				$output['message']= '';
				
				$db = $this->db;
				$builder = $db->table($this->_table_names);
				$builder->where('id', $check_user->id);
				
				if($check_user->enabled==1){
					$builder->set('enabled',0);
					$statuschanged = ' status disabled.';
					
				}
				else{
					$builder->set('enabled',1);
					$statuschanged = ' status enabled.';

				}
				
				$builder->update();

				$titledeleted = $this->_table_names;
				$d_action = $titledeleted.$statuschanged;		
				$logged_in = $this->data['adminDetails'];
				$employeeid = $logged_in->employee_id;
				$insertactivity['employee'] = $employeeid;
				$insertactivity['d_action'] = $d_action;
				$insertactivity['created']  = date("Y-m-d H:i:s");
				activitylogs($insertactivity,'insert');
			}
		}
		echo json_encode($output);
	}
	
	
	function do_quote(){
		$output = array();
		$output['status']= 'error';
		$output['message']= 'there is no data';
		$getdata = $this->getdata;
		$id = $getdata['id'];
		
		
		if($id){
			$check_user = $this->CommanModel->get_by($this->_table_names,array('id'=>$id),false,false,true);
			if($check_user){
				$output['status']= 'ok';
				$output['message']= '';
				
				$db = $this->db;
				$builder = $db->table($this->_table_names);
				$builder->where('id', $check_user->id);
				
				if($check_user->quote==1){
					$builder->set('quote',0);
					
				}
				else{
					$builder->set('quote',1);

				}
				
				$builder->update();

				$titledeleted = $this->_table_names;
				$d_action = $titledeleted.' quote status changed.';		
				$logged_in = $this->data['adminDetails'];
				$employeeid = $logged_in->employee_id;
				$insertactivity['employee'] = $employeeid;
				$insertactivity['d_action'] = $d_action;
				$insertactivity['created']  = date("Y-m-d H:i:s");
				activitylogs($insertactivity,'insert');
			}
		}
		echo json_encode($output);
	}
    
    
     function do_viewed(){
		$output = array();
		$output['status']= 'error';
		$output['message']= 'there is no data';
		$getdata = $this->getdata;
		$id = $getdata['id'];
		
		
		if($id){
			$check_user = $this->CommanModel->get_by($this->_table_names,array('id'=>$id),false,false,true);
			if($check_user){
				$output['status']= 'ok';
				$output['message']= '';
				
				$builder = $db->table($this->_table_names);
				$builder = $db->table($this->_table_names);
				$builder->where('id', $check_user->id);
				
				if($check_user->view==1){
					$builder->set('view',0);
					$viewatstus = ' row view status reverted.';
					
				}
				else{
					$builder->set('view',1);
					$viewatstus = ' row view status changed.';

				}
				
				$builder->update();

				$titledeleted = $this->_table_names;
				$d_action = $titledeleted.$viewatstus;		
				$logged_in = $this->data['adminDetails'];
				$employeeid = $logged_in->employee_id;
				$insertactivity['employee'] = $employeeid;
				$insertactivity['d_action'] = $d_action;
				$insertactivity['created']  = date("Y-m-d H:i:s");
				activitylogs($insertactivity,'insert');
			}
		}
		echo json_encode($output);
	}
    
    
     function do_toggle(){
	$output = array();
	$output['status']= 'error';
	$output['message']= 'there is no data';
	$getdata = $this->getdata;
	$id = $getdata['id'];
	$column = $getdata['column'];	
	if($id){
	    if($this->_table_names == 'allvisitors'){
		$column = 'status';
	    }
	    $element = $this->CommanModel->get_by($this->_table_names,array('id'=>$id),false,false,true);
	    if($element){
		$output['status']= 'ok';
		$output['message']= '';
		$db = $this->db;
		$builder = $db->table($this->_table_names);
		$builder->where('id', $element->id);		
		if($element->{$column}==1){
		    $builder->set($column,0);
		    $statuschanged = ' column "<b>'.$column.'</b>" status reverted.';
		}
		else{
		    $builder->set($column,1);
		    $statuschanged = ' column "<b>'.$column.'</b>" status enabled.';
		}		
		$builder->update();
		$titledeleted = $this->_table_names;
		$d_action = $titledeleted.$statuschanged;		
		$logged_in = $this->data['adminDetails'];
		$employeeid = $logged_in->employee_id;
		$insertactivity['employee'] = $employeeid;
		$insertactivity['d_action'] = $d_action;
		$insertactivity['created']  = date("Y-m-d H:i:s");
		activitylogs($insertactivity,'insert');
	    }
	}
	echo json_encode($output);
    }
    
    

    function clearCache()
    {
        $this->response->setHeader("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->response->setHeader("Pragma: no-cache");
    }
}
