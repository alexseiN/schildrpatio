<?php



namespace App\Controllers\Admin123;   
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use App\Core\Admincontroller;
use App\Models\backend\Quotesmodel;

class Quotesvone extends Admincontroller {
    public $_table_names = 'quotes';			//set table name
    public $_subView = 'admin/quotesvone/';		//set subview
    public $_redirect = '/quotesvone';				//set controller link
    protected $CurrencyModel;

    public function __construct(){
        parent::__construct();
        $this->QuotesModel = new Quotesmodel();
        $this->data['ThisModule'] = $this->QuotesModel;
        $this->data['CommanModel'] = $this->CommanModel;
        //set left menu active on admin dashboard
        $this->data['active'] = 'From Website';
        $this->data['withoutlang'] = 1;       

        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';
        $this->data['_view'] = $this->data['admin_link'].$this->_redirect.'/view';
    }
	public function index() {

        //set title
        $this->data['name'] = 'Quotes';
        $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name']; 
        $this->data['thisItems'] = $this->CommanModel->getDatam('quotes',array(),false,false,'created');
        $this->data['branches'] = $this->CommanModel->get_lang('branches',false,false,array(),'connlang_id',FALSE);
        $this->data['pdcats'] = $this->CommanModel->get_lang('pdcats',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);
        $this->data['subview'] = $this->_subView.'index'; 
        echo view('admin/_layout_main',$this->data);
    }
    
    function quotelist(){

		$client = $_REQUEST['columns'][0]['search']['value'];
		$zipcode = $_REQUEST['columns'][1]['search']['value'];
		$branch = $_REQUEST['columns'][2]['search']['value'];
		$product = $_REQUEST['columns'][3]['search']['value'];
		$view = $_REQUEST['columns'][5]['search']['value'];

		
		## Read value
		$draw = $_REQUEST['draw'];
		$row = $_REQUEST['start'];
		$rowperpage = $_REQUEST['length']; // Rows display per page
		if($rowperpage == '-1' || $rowperpage == 'all'){
			$rowperpage = 'all';
		}
		//$rowperpage = 10; // Rows display per page
		$columnIndex = $_REQUEST['order'][0]['column']; // Column index
		$columnName = $_REQUEST['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder = $_REQUEST['order'][0]['dir']; // asc or desc
		$searchValue = $_REQUEST['search']['value']; // Search value

		

		$where= array(
		    'parent_id'=>0
		);
		$like = array(
					'first_name'=>$client,
					'zipcode'=>$zipcode
				);
        $havingIn = array();
		if ($branch) {$where['branch_id']=$branch;} else {unset($where['branch_id']);}
		if ($product) {$where['incat']=$product;} else {unset($where['incat']);}
		if ($view == '1') {$where['view']=1;} else if ($view == '0') {$where['view']=0;} else {unset($where['view']);}
		
        
        $data_send = array();    
		$quotes_record = $this->CommanModel->getDatamwithlimit($this->_table_names,$where,$havingIn,$like,'created',$row,$rowperpage);
		$quotes_totalcount = $this->CommanModel->getDatamwithlimit($this->_table_names,$where,$havingIn,$like,'created',$row,'all');
		
		if(count($quotes_record)>0){
			foreach($quotes_record as $set_data){
				$incat = get_langer('pdcats',8,$set_data->incat);
				$catmain = get_langer('pdcats',8,$incat->parent_id);
				if ($set_data->view) {$sentclass='';} else {$sentclass='sent';}
				if ($set_data->view == 1) {$invoice = 'checked';} else {$invoice = ' ';}
				$branchs = get_langer('branches',8, $set_data->branch_id);
				
				$client = $set_data->first_name.' '.$set_data->last_name;
				$zipcode = $set_data->zipcode;
				if($rowperpage == '-1' || $rowperpage == 'all'){
					$branch = $branchs->name;
				}
				else {
					$branch = select_branches($set_data->id,$set_data->branch_id);
				}

				if ($set_data->view) {$sentclass='';} else {$sentclass='sent';}
				
				$product = $incat->title;
				$receivedtime = branchtime($set_data->created,$branchs->diff,'M d,Y h:i');

				$actiontime = '<a class="btn btn-xs btn-outline-success checkclass" data-row-class="'.$sentclass.'" data-id="'.$set_data->id.'" title="Check as invoice"><input class="btn" style="transform:scale(0.8)" type="checkbox" onclick="do_invoice('.$set_data->id.')" '.$invoice.' /></a>
        <a class="btn btn-xs btn-success" href="'.$this->data['_view'].'/'.$set_data->id.'" title="View Invoice"><i class="fa fa-eye"></i></a>
	<a  class="btn btn-xs btn-danger delete"  href="'.$this->data['_delete'].'/'.$set_data->id.'"  onclick="return confirm_box();" title="Delete"><i class="fa fa-remove"></i></a>';
	
				/*$data_send[] = array( 
					"client"=>$client,
					"zipcode"=>$zipcode,
					"branch"=>$branch,
					"product"=>$product,
					"receivedtime"=>$receivedtime,
					"action"=>$actiontime,
				);*/
				$data_send[] = array( 
					$client,
					$zipcode,
					$branch,
					$product,
					$receivedtime,
					$actiontime
				);
				
			}
		}
		
		//pp($data_send);
		
		//$record_count = $this->CommanModel->record_count($this->_table_names);

		
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
	
    function ajax_list(){
		$where= array(
		    'parent_id'=>0
		);
        $havingIn = array();
        $client = $this->request->getPost('client');
        $zipcode = $this->request->getPost('zipcode');
        $branch = $this->request->getPost('branch');
        $product = $this->request->getPost('product');
        $view = $this->request->getPost('view');
        $bsenders = $this->CommanModel->get_lang('employees',false,false,array('branch_id'=>$branch,'rep'=>1),'connlang_id',FALSE);
		if ($branch) {$where['branch_id']=$branch;} else {unset($where['branch_id']);}
		if ($product) {$where['incat']=$product;} else {unset($where['incat']);}
		if ($view == '1') {$where['view']=1;} else
		if ($view == '0') {$where['view']=0;} else {unset($where['view']);}
        $like = array(
				'first_name'=>$client,
				'zipcode'=>$zipcode
            );
		$this->items['objects'] = $this->CommanModel->getDatam('quotes',$where,false,$like,'created');  
        $this->data['subview'] = 'setproject/index';
        $html = view('admin/quotes/ajax_list', $this->items);
		return $html;
	}
}
