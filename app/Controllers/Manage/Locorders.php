<?php

namespace App\Controllers\Manage;

use App\Core\Admincontroller;

class Locorders extends Admincontroller {
    public $_table_names 	= 'locorders';		//set table
    public $_subView = 'admin/locorders/';			//set subview
    public $_mainView = 'admin/_layout_main';		//set mainview
    public $_redirect = '/locorders';	 			//set controller link				//set controller link
    public function __construct(){
        parent::__construct();
        $this->data['active'] = 'Local Store';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;


	$this->data['allemployees'] = $this->CommanModel->get_lang('employees',false,false,array(),'connlang_id',FALSE);
	
	foreach($this->data['allemployees'] as $employee){
	    $employees[$employee->id] = $employee->first_name.' '.$employee->last_name;
	}
	// for Global List
        $this->data['_table_names'] = $this->_table_names;
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Local Store';
        $Statusoptions = array("0"=>"Normal","1"=>"Problem");
        $enabledoptions = array("1"=>"Enabled","0"=>"Disabled");

	$adminDetails = $this->data['adminDetails'];
	if($adminDetails->role == 'Branch Admin'){
	    $setarray = array();
	}
	else {
	    $setarray = array(
                                "name"=>"ordered_user_TYPEwhere",
                                "type"=>"select",
                                "options"=>$employees,
                                "events"=>array(
                                    "onchange"=>"getData('no')"
                                )
                            );
	}
	
        $columns_with_filteroptions = array(
                "ID" => array(
                            "name"=>"id_TYPElike",
                            "type"=>"text",
                            "events"=>array(
                                "onkeyup"=>"getData('no')"
                            )
                        ),
                "Products" => array(),
                "Employee" => $setarray,
                "Branch" => array(),
                "Amount" => array(),
                "Status" => array(
                            "name"=>"status_TYPEwhere",
                            "type"=>"select",
                            "options"=>$this->data['pstatusoptions'],
                            "events"=>array(
                                "onchange"=>"getData('no')"
                            )
                        ),
		"Time" => array(),
                );
		
	$where = array();
        $blank_array = array();
        $adminDetails = $this->data['adminDetails'];
        if($adminDetails->role == 'Branch Admin'){
            $loggedinuseremp = $this->data['adminDetails']->employee_id;            
            $where = array("ordered_user"=>$loggedinuseremp);
        }
	$total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$blank_array,$blank_array,'',0,'all',true);
	
        $main_array_view = array(
                    "view_data"=>array(
                        "view_folder"=>"locorders",
                        "columns_with_filteroptions"=>$columns_with_filteroptions,
                        "total_count"=>$total_count,
                        "is_filter"=>"yes",
                        "default_sort"=>"created",
                        "default_sort_type"=>"DESC",
                        "add_link"=>array("status"=>"no","link"=>"")
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List
    }

    public function index() {
        $this->data['name'] = 'All Orders';
        $this->data['title'] = $this->data['name'];
        echo view('admin/_layout_main', $this->data);
    }

    public function orderslist(){
	$where= array(
	    
	);
	$havingIn = array();
	$id = $_REQUEST['columns'][0]['search']['value'];
	$ordered_user = $_REQUEST['columns'][2]['search']['value'];
	$status_filter = $_REQUEST['columns'][5]['search']['value'];

	if($this->data['adminDetails']->role == 'Global Admin'){
	    $ordered_user = $_REQUEST['columns'][2]['search']['value'];
	}
	else{
	    $ordered_user = $this->data['adminDetails']->employee_id;
	}
	
        $like = array(
		'id'=>$id,
		'ordered_user'=>$ordered_user,
		'status'=>$status_filter,
            );   
	## Read value
	$draw = $_REQUEST['draw'];
	$row = $_REQUEST['start'];
	$rowperpage = $_REQUEST['length']; // Rows display per page
	if($rowperpage == '-1' || $rowperpage == 'all'){
		$rowperpage = 'all';
	}
	$columnIndex = $_REQUEST['order'][0]['column']; // Column index
	$columnName = $_REQUEST['columns'][$columnIndex]['data']; // Column name
	$columnSortOrder = $_REQUEST['order'][0]['dir']; // asc or desc
	$searchValue = $_REQUEST['search']['value']; // Search value    

	$data_send = array();    
	$quotes_record = $this->CommanModel->getDatamwithlimit($this->_table_names,$where,$havingIn,$like,'id',$row,$rowperpage);
	$quotes_totalcount = $this->CommanModel->getDatamwithlimit($this->_table_names,$where,$havingIn,$like,'id',$row,'all');	    
	if(count($quotes_record)>0){
	    foreach($quotes_record as $set_data){
		$productarrayexplode = explode(",",$set_data->products);
		$product_name_array = array();
		foreach($productarrayexplode as $products) {
		    $productexplode = explode("-",$products);
		    $product_id = $productexplode[0];
		    //$variant_id = $productexplode[1];

		    $size_id = $productexplode[1];
		    $color_id = $productexplode[2];

			
		    $product_result = getDatam2('locproducts',array("id"=>$product_id),$this->data['admin_lang'],false,'id',false);
		    $variation_result = getDatam2('locsize',array("id"=>$size_id),$this->data['admin_lang'],false,'id',false);
		    $variation_result_2 = getDatam2('loccolor',array("id"=>$color_id),$this->data['admin_lang'],false,'id',false);
		    
		    $product_name_array[] = $product_result[0]->title.' ( '.$variation_result[0]->title.' ) '.' ( '.$variation_result_2[0]->title.' ) ';
		}
		
		$thisemployee = $this->CommanModel->get_by('employees', array('id'=>$set_data->ordered_user), FALSE, FALSE, true);
		$branchs = get_langer('branches',8, $thisemployee->branch_id);
		$showproducts = implode("<br>",$product_name_array);
		$branch = $branchs->name;
		$phone = $set_data->phone;
		$receivedtime = branchtime($set_data->created,$branchs->diff,'M d,Y h:i');
		if($rowperpage == '-1' || $rowperpage == 'all'){
		    $status = $set_data->status;
		}
		else {
		    $status = '<select class="form-control col-search-input" data-id="'.$set_data->id.'" onchange="return change_status(this)" name="status" autocomplete="on"><option value="Waiting" '.($set_data->status == 'Waiting'?'selected':'').'>Waiting</option><option value="Preparing" '.($set_data->status == 'Preparing'?'selected':'').'>Preparing</option><option value="Delivered" '.($set_data->status == 'Delivered'?'selected':'').'>Delivered</option></select>';
		}

		$data_send[] = array( 
		    $set_data->id,
		    $showproducts,
		    $thisemployee->first_name.' '.$thisemployee->last_name,
		    $branch,
		    front_format_currency_helper($set_data->total_amount),
		    $status,
		    $receivedtime
		);
		    
	    }
	}
	$iTotalRecords = count($quotes_totalcount);
	$iTotalDisplayRecords = count($quotes_totalcount);
	$response = array(
		"draw" => intval($draw),
		"iTotalRecords" => $iTotalRecords,
		"iTotalDisplayRecords" => $iTotalDisplayRecords,
		"aaData" => $data_send,
		//"record_count" => $record_count
	);
	echo json_encode($response);die;
    }

    public function modal() {
        echo view('admin/_layout_modal', $this->data);
    }

    function change_status(){
	$id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
	$order_data = array();
	$order_data['status'] = $status;
	$this->CommanModel->saveData($this->_table_names,$order_data,$id);
	$output = array();
	$output['status'] = 'success';
	$output['message'] = 'Successfully updated';
	echo json_encode($output);
    }
    
     function ajax_list(){
		
		ini_set("memory_limit","-1");
		$where= array();
		
        
        
        $id = $this->request->getPost('id');
        $products = $this->request->getPost('products');
        $ordered_user = $this->request->getPost('ordered_user');
        
        
        
        $row = $this->request->getPost('row');
        $rowperpage = $this->request->getPost('rowperpage');
        
        
        $like = array(
            'id'=>$id,
            'products'=>$products,
            'ordered_user'=>$ordered_user,
            );
   
			
	
        
        $this->items['objects'] = $this->CommanModel->getDatamwithlimit($this->_table_names,false,false,$like,'created',$row,$rowperpage);
        $this->items['totalcount'] = $this->CommanModel->getDatamwithlimit($this->_table_names,false,false,$like,'created',$row,'all');
		
		
		//set load view
        $this->data['subview'] = 'locorders/index';
        $html = view('admin/locorders/ajax_list', $this->items);
        
		$jsonrerurn = json_encode(array(
		    "status" => 'success',
		    "html" => $html,
            "totalcount"=>count($this->items['totalcount'])
		));
		//$json_pretty = json_encode(json_decode($jsonrerurn), JSON_PRETTY_PRINT);
		echo $jsonrerurn;
		
		
		
	}
    
}
