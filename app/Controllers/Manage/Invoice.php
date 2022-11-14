<?php

namespace App\Controllers\Manage;

use App\Core\Admincontroller;
use App\Models\backend\Selproductsmodel;
use App\Models\backend\Quotesmodel;
use App\Models\backend\Setprojectsmodel;

class Invoice extends Admincontroller {
    public $_table_names = 'setproject';			//set table name
    public $_subView = 'admin/invoice/';	//set subview
    public $_redirect = '/invoice';			//set controller link

    protected $StaticTextModel;       
    public function __construct(){
        parent::__construct();
        $this->QuotesModel      = new Quotesmodel();
        $this->data['active'] = 'Invoice management';
        $this->data['_edit']    = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel']  = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete']  = $this->data['admin_link'].$this->_redirect.'/delete';
        $this->data['controller'] = $this;        
        $this->data['_parent_folder'] = 'Invoice & Estimates';


        $this->SetprojectsModel = new Setprojectsmodel();

        $this->data['ThisModule'] = $this->SetprojectsModel;
        $this->data['CommanModel'] = $this->CommanModel;

        //set left menu active on admin dashboard
        $this->data['active'] = 'Invoice management';
        $this->data['withoutlang'] = 1;
        
        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';


        $this->data['employees'] = $this->CommanModel->get_lang('employees',false,false,array('rep'=>1),'connlang_id',FALSE);

        $this->data['branches'] = $this->CommanModel->get_lang('branches',false,false,array(),'connlang_id',FALSE);
            $this->data['pdcats'] = $this->CommanModel->get_lang('pdcats',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);

        
        foreach($this->data['branches'] as $branch){
            $branches[$branch->id] = $branch->name;
        }

        foreach($this->data['employees'] as $employee){
            $employees[$employee->id] = $employee->first_name.' '.$employee->last_name;
        }
        
        foreach($this->data['pdcats'] as $pdcat){
            $pdcats[] = array("id"=>$pdcat->id,"parent_id"=>$pdcat->parent_id,"title"=>$pdcat->title);
        }

        // for Global List
        $this->data['_table_names'] = $this->_table_names;
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Invoice & Estimates';
        $Sentoptions = array("s"=>"Sent","d"=>"Draft");

        $adminDetails = $this->data['adminDetails'];
	
    
        $columns_with_filteroptions = array(
                "Client" => array(
                        "name"=>"buyer_TYPElike",
                        "type"=>"text",
                        "events"=>array(
                        "onkeyup"=>"getData('no')"
                        )
                    ),
                "Phone" => array(
                        "name"=>"phone_TYPElike",
                        "type"=>"text",
                        "events"=>array(
                            "onkeyup"=>"getData('no')"
                        )					
                        ),			
                "Product" => array(
                            "name"=>"product_category_TYPEwhere",
                            "type"=>"selectwithoptiongroup",
                            "options"=>$pdcats,
                            "events"=>array(
                                "onchange"=>"getData('no')"
                            )
                            ),
                
                "Sent Time" => array(
                        "name"=>"sendtime_TYPEcustom",
                        "type"=>"select",
                        "options"=>$Sentoptions,
                        "events"=>array(
                            "onchange"=>"getData('no')"
                        )
                        ),
                "Sender" => array(
                            "name"=>"sender_TYPEwhere",
                            "type"=>"select",
                            "options"=>$employees,
                            "events"=>array(
                                "onchange"=>"getData('no')"
                            )
                            ),
                        
                "Action" => array(
                        "name"=>"id_TYPElike",
                        "type"=>"text",
                        "events"=>array(
                            "onkeyup"=>"getData('no')"
                        )
                        ),
                );
        if($adminDetails->role == 'Global Admin'){
            $add_f_array = array("From"=>array(
                                "name"=>"employee_TYPEwhere",
                                "type"=>"select",
                                "options"=>$employees,
                                "events"=>array(
                                    "onchange"=>"getData('no')"
                                )
                                ));
            $add_b_array = array("Branch"=>array(
                                "name"=>"branch_id_TYPEhaving",
                                "type"=>"select",
                                "options"=>$branches,
                                "events"=>array(
                                    "onchange"=>"getData('no')"
                                )
                                ));
            $columns_with_filteroptions = array_merge(array_slice($columns_with_filteroptions, 0, 3), $add_f_array, array_slice($columns_with_filteroptions, 3));
            $columns_with_filteroptions = array_merge(array_slice($columns_with_filteroptions, 0, 4), $add_b_array, array_slice($columns_with_filteroptions, 4));
        }
        
        $where = array(
		    'parent_id'=>0
		);
        $blank_array = array();
        $adminDetails = $this->data['adminDetails'];
        if($adminDetails->role == 'Branch Admin'){
            $loggedinuseremp = $this->data['adminDetails']->employee_id;            
            $where = array("employee"=>$loggedinuseremp,'parent_id'=>0);
        }
        
        $total_count = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$blank_array,$blank_array,'',0,'all',true);

        $main_array_view = array(
                    "view_data"=>array(
                    "view_folder"=>"setproject",
                    "columns_with_filteroptions"=>$columns_with_filteroptions,
                    "total_count"=>$total_count,
                    "is_filter"=>"yes",
                    "default_sort"=>"created",
                    "default_sort_type"=>"DESC",
                    "add_link"=>array("status"=>"yes","link"=>$this->data['admin_link'].'/invoice/projectedit'),
                    )
                );
                
        $this->data['viewdata'] = $main_array_view;
        // end for Global List      
    }

    public function index() {
        //set title
        $this->data['name'] = 'Invoices';
        $this->data['title'] = $this->data['name']; 
        echo view('admin/_layout_main',$this->data);
    }

    public function projectedit($id = NULL)
    {
        if($id)
        {
            $this->data['name'] = 'Edit Invoice project';
            $this->data['title'] = $this->data['name'];
            $blank_array = array();
            $where['id'] = $id;
            $this->data['thisItems'] = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$where,$blank_array,$blank_array,'',0,'all',false);
            if(count($this->data['thisItems'])<=0){
                return redirect()->to($this->data['_cancel']);
            }
            $message = 'Data has successfully updated';
        }
        else
        {
            $this->data['name'] = 'Create Invoice project';
            $this->data['title'] = $this->data['name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
            $message = 'Data has successfully created';
        }
        $this->data['id'] = $id;
        
        $this->data['employees'] = $this->CommanModel->get_lang('employees',false,false,array(),'connlang_id',FALSE);
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;
            
            $input = $this->validate($this->data['ThisModule']->getAllRules());
            if($input) {
                $data = $this->data['ThisModule']->arrayFromPost(array('project','employee','buyer','address','phone','email','notes'));
                $data['phone']= preg_replace('/[^0-9.]/', '', $data['phone']);      
                $data['created'] = time();
                $data['link']    = md5(time() . rand());

                if(is_null($id)) {	    
                    $d_action = 'New Invoice Project added.';
                }
                else {
                    $d_action = 'Invoice Project updated.';
                }
                
                $id = $this->data['ThisModule']->saveData($data, $id);

                $d_action .= ' <a href="'.$this->data['_cancel'].'/edit/'.$id.'" class="fs-6 text-gray-800 text-hover-primary fw-bold">View</a>';		
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
    
    function edit($id=NULL){
        ini_set('memory_limit', '128M');
		
        //set title
        $this->data['name']             = 'Edit Invoice';
        $this->data['title']            = $this->data['name'];
        $this->data['main']             = $this->CommanModel->get_by('l_settings', array(), FALSE, FALSE, TRUE);
		$this->data['setproject']       = $this->CommanModel->get_by('setproject', array('id'=>$id), FALSE, FALSE, TRUE);
		$this->data['selprods']         = $this->CommanModel->get_by('selproducts', array('category_id'=>$id), FALSE, FALSE, FALSE);
        $this->data['allProducts']      = $this->getProductsForCategory($this->data['setproject']->product_category);
        $this->data['child_project']       = $this->CommanModel->get_by('setproject', array('parent_id'=>$id), FALSE, FALSE, FALSE);
        $ds = array();
        $kp = array();
        $slproids = array();
        $productssarray = array();

        $productssarray[$id] = $this->CommanModel->get_by('selproducts', array('category_id'=>$id), FALSE, FALSE, FALSE);        
        $slproids[$id] = $this->CommanModel->get_by_only_id('selproducts', array('category_id'=>$id), FALSE, FALSE, FALSE);
        
        foreach($this->data['child_project'] as $dts) {
            $productssarray[$dts->id] = $this->CommanModel->get_by('selproducts', array('category_id'=>$dts->id), FALSE, FALSE, FALSE);
            $ds[$dts->id] = $this->CommanModel->get_by('selproducts', array('category_id'=>$dts->id), FALSE, FALSE, FALSE);
            $kp[$dts->id] = $this->getProductsForCategory($dts->product_category);
            $slproids[$dts->id] = $this->CommanModel->get_by_only_id('selproducts', array('category_id'=>$dts->id), FALSE, FALSE, FALSE);
        }
        $this->data['child_pds'] = $ds;
        $this->data['main_project_id'] = $id;
        $this->data['product_options'] = $productssarray;
        $this->data['product_options_ids'] = $slproids;

        $this->data['child_projects'] = array();;
        

        $productOptions = "<option value=''>Select a product</option>";
        foreach($this->data['allProducts'] as $product) {
            $productOptions .= "<option value='".$product->id."'>".$product->title."</option>";
        }
    
		$this->data['coloritems'] = $this->CommanModel->get_lang('colors',$this->data['admin_lang'],false,array('enabled'=>1),'connlang_id',FALSE);
		$this->data['coloritems2'] = $this->CommanModel->get_lang('colors',$this->data['admin_lang'],false,array('category'=>15,'enabled'=>1),'connlang_id',FALSE);
        $this->data['productOptions']   = $productOptions;
        $this->data['child_pdty']   = $kp;
		$this->data['category_id']      = $id;
		$this->data['all_categories']   = $this->CommanModel->get_lang('pdcats',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);
		$pl = array();
        $this->data['main_categories']  = $this->CommanModel->get_lang('pdcats',$this->data['admin_lang'],false,array('parent_id'=>0),'connlang_id',FALSE);
        //set load view
        $this->data['subview'] = $this->_subView.'/index';
        echo view('admin/_layout_main',$this->data);
    }


    function workinvoice($id=NULL){		
        //set title
        $this->data['name']             = 'Invoice Edit Tool';
        $this->data['title']            = $this->data['name'].' | '.$this->data['settings']['site_name'];
        $this->data['main']             = $this->CommanModel->get_by('l_settings', array(), FALSE, FALSE, TRUE);
		$this->data['setproject']       = $this->CommanModel->get_by('setproject', array('id'=>$id), FALSE, FALSE, TRUE);
		$this->data['selprods']         = $this->CommanModel->get_by('selproducts', array('category_id'=>$id), FALSE, FALSE, FALSE);
        $this->data['allProducts']      = $this->getProductsForCategory($this->data['setproject']->product_category);
        $this->data['child_project']       = $this->CommanModel->get_by('setproject', array('parent_id'=>$id), FALSE, FALSE, FALSE);
        $ds = array();
        $kp = array();
        $slproids = array();
        $productssarray = array();

        $productssarray[$id] = $this->CommanModel->get_by('selproducts', array('category_id'=>$id), FALSE, FALSE, FALSE);        
        $slproids[$id] = $this->CommanModel->get_by_only_id('selproducts', array('category_id'=>$id), FALSE, FALSE, FALSE);
        
        foreach($this->data['child_project'] as $dts) {
            $productssarray[$dts->id] = $this->CommanModel->get_by('selproducts', array('category_id'=>$dts->id), FALSE, FALSE, FALSE);
            $ds[$dts->id] = $this->CommanModel->get_by('selproducts', array('category_id'=>$dts->id), FALSE, FALSE, FALSE);
            $kp[$dts->id] = $this->getProductsForCategory($dts->product_category);
            $slproids[$dts->id] = $this->CommanModel->get_by_only_id('selproducts', array('category_id'=>$dts->id), FALSE, FALSE, FALSE);
        }
        $this->data['child_pds'] = $ds;
        $this->data['main_project_id'] = $id;
        $this->data['product_options'] = $productssarray;
        $this->data['product_options_ids'] = $slproids;

        $this->data['child_projects'] = array();;
        

        $productOptions = "<option value=''>Select a product</option>";
        foreach($this->data['allProducts'] as $product) {
            $productOptions .= "<option value='".$product->id."'>".$product->title."</option>";
        }
    
		$this->data['coloritems'] = $this->CommanModel->get_lang('colors',$this->data['admin_lang'],false,array('enabled'=>1),'connlang_id',FALSE);
		$this->data['coloritems2'] = $this->CommanModel->get_lang('colors',$this->data['admin_lang'],false,array('category'=>15,'enabled'=>1),'connlang_id',FALSE);

        
        $this->data['productOptions']   = $productOptions;
        $this->data['child_pdty']   = $kp;
		$this->data['category_id']      = $id;
		$this->data['all_categories']   = $this->CommanModel->get_lang('pdcats',$this->data['admin_lang'],false,array(),'connlang_id',FALSE);
		$pl = array();
        $this->data['main_categories']  = $this->CommanModel->get_lang('pdcats',$this->data['admin_lang'],false,array('parent_id'=>0),'connlang_id',FALSE);
        //set load view
        $this->data['subview'] = $this->_subView.'/workinvoice';
        echo view('admin/_layout_main',$this->data);
    }
    
    function deleterowdata(){
        $postdata = $this->postdata;
        $type = $postdata['type'];
        if($type == 'placed'){
            $mainidoption = $postdata['mainidoption'];
            $product_id = $postdata['product_id'];
            $invoiceid = $postdata['invoiceid'];
            $this->CommanModel->deleterowdata('selproducts',$product_id);

            $d_action = 'Row from <b>Invoice #'.$invoiceid.'</b> deleted.';		
            $logged_in = $this->data['adminDetails'];
            $employeeid = $logged_in->employee_id;
            $insertactivity['employee'] = $employeeid;
            $insertactivity['d_action'] = $d_action;
            $insertactivity['created']  = date("Y-m-d H:i:s");
            activitylogs($insertactivity,'insert');

                
            if($invoiceid != $mainidoption){
                $childids = $this->CommanModel->get_by('selproducts', array('category_id'=>$mainidoption), FALSE, FALSE, FALSE);
                if(count($childids)<=0){
                    $this->CommanModel->deleterowdata('setproject',$mainidoption);
                }
            }
        }      
    }

    function deleteoptiondata(){
        $mainidoption = $_POST['mainidoption'];
        $maincat = $_POST['maincat'];
        $this->CommanModel->deleteoptions('selproducts',$mainidoption);
        $this->CommanModel->deleterowdata('setproject',$mainidoption);

        $d_action = 'Option <b>Invoice #'.$maincat.'</b> deleted.';		
        $logged_in = $this->data['adminDetails'];
        $employeeid = $logged_in->employee_id;
        $insertactivity['employee'] = $employeeid;
        $insertactivity['d_action'] = $d_action;
        $insertactivity['created']  = date("Y-m-d H:i:s");
        activitylogs($insertactivity,'insert');
               
    }

    function cloneoption() {
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;
            $maincat = $postdata['maincat'];
            $product_id = $postdata['cat_id'];
            $response = array();
            $childids = $this->CommanModel->get_by_only_id('selproducts', array('category_id'=>$product_id), FALSE, FALSE, FALSE);
            
            if($childids != ''){
                $insertprojectid = $this->CommanModel->cloneproject($product_id);        
                if ($insertprojectid) {
                    if($maincat == $product_id){
                        $custom_data = array();
                        $custom_data['parent_id'] = $maincat;//timestamp
                        $custom_data['employee'] = 'inherit';
                        $custom_data['email'] = '';
                        $custom_data['phone'] = '';
                        $custom_data['buyer'] = 'inherit';
                        $custom_data['address'] = null;
                        $custom_data['notes'] = null;
                        $custom_data['tax'] = '';
                        $custom_data['shipping'] = '';
                        $custom_data['transportation'] = '';
                        $custom_data['insurance'] = '';
                        $custom_data['extra'] = '';
                        $custom_data['install'] = '';
                        $custom_data['incomen'] = '';
                        $custom_data['created'] = null;
                        $custom_data['quote_id'] = 0;
                        $custom_data['link'] = '';
                        $this->CommanModel->saveData('setproject', $custom_data, $insertprojectid);
                    }            
                    $childarray = explode(",",$childids);
                    foreach($childarray as $child){                
                        $selproductsid = $this->CommanModel->cloneproducts($child);
                        if ($selproductsid) {
                            $custom_data_products = array();
                            $custom_data_products['category_id'] = $insertprojectid;
                            $this->CommanModel->saveData('selproducts', $custom_data_products, $selproductsid);
                        }
                    }
                    $htmlset = create_invoice_table($maincat,$this->data['admin_lang']);


                    $d_action = 'Option in <b>Invoice #'.$maincat.'</b> has been cloned.';		
                    $logged_in = $this->data['adminDetails'];
                    $employeeid = $logged_in->employee_id;
                    $insertactivity['employee'] = $employeeid;
                    $insertactivity['d_action'] = $d_action;
                    $insertactivity['created']  = date("Y-m-d H:i:s");
                    activitylogs($insertactivity,'insert');

        
                    $response['status'] = 'success';
                    $response['message'] = 'Successfully created.';
                    $response['data'] = $htmlset;
                }
                else {
                    $response['status'] = 'error';
                    $response['message'] = 'Option not created.';
                    $response['data'] = '';
                }
            }
            else {
                $response['status'] = 'error';
                $response['message'] = 'You can not clone this option';
                $response['data'] = '';
            }
        }
        else {
            $response['status'] = 'error';
            $response['message'] = 'You can not clone this option';
            $response['data'] = '';
        }
        
        echo json_encode($response);die;      
    }

    
  
    function update_invoice_total() {
        $this->CommanModel->saveData('setproject', array('total_price' => $_GET['total']), $_GET['project_id']);
    }
    
    function send_invoice_mail () {
        $email_data['email'] = $_GET['email'];
        $email_data['invoice_id'] = $_GET['invoice_id'];
        $email_data['buyer'] = $_GET['buyer'];
        $wp = $_GET['wp'];
        if ($wp == 1) {
            $email_data['link'] = '/wp/'.$_GET['link'];
        }  else {
            $email_data['link'] = $_GET['link'];
        }   
        
        $data['sendtime'] = time();
        
        if ($_GET['sender']) {
            $data['sender'] = $_GET['sender'];
        }
        
        if ($_GET['emp_email']) {
            $emp_email = $_GET['emp_email'];
        }
        
        $data['count'] = $_GET['count'];
        
        $data['count'] = $data['count'] + 1;
        
        
        
       //echo '<pre>';print_r($data);die();
        
        $this->CommanModel->saveData('setproject',$data, $email_data['invoice_id']);
        
        $emp_emails = $emp_email.',sales@schildr.com';
        
        
        
         //sendmail(15,$email_data['email'],$email_data);
         
         sendmail2(15,$email_data['email'],$email_data,$emp_emails);


                $d_action = 'Invoice successfully sent for <b>Invoice #'.$email_data['invoice_id'].'</b>.';		
                $logged_in = $this->data['adminDetails'];
                $employeeid = $logged_in->employee_id;
                $insertactivity['employee'] = $employeeid;
                $insertactivity['d_action'] = $d_action;
                $insertactivity['created']  = date("Y-m-d H:i:s");
                activitylogs($insertactivity,'insert');
                
         
        
    }
    
    
    function followUp_mail () {
        $email_data['email'] = $_GET['email'];
        $email_data['invoice_id'] = $_GET['invoice_id'];
        $email_data['buyer'] = $_GET['buyer'];
          
        $email_data['link'] = $_GET['link'];
        
        if ($_GET['sender']) {
            $data['sender'] = $_GET['sender'];
        }
        
        
        $emp_email = $_GET['emp_email'];
        
        

        
        
         //sendmail(15,$email_data['email'],$email_data);
         
         sendmail(20,$email_data['email'],$email_data,$emp_email); 


                $d_action = 'Invoice successfully Followed Up for <b>Invoice #'.$email_data['invoice_id'].'</b>.';		
                $logged_in = $this->data['adminDetails'];
                $employeeid = $logged_in->employee_id;
                $insertactivity['employee'] = $employeeid;
                $insertactivity['d_action'] = $d_action;
                $insertactivity['created']  = date("Y-m-d H:i:s");
                activitylogs($insertactivity,'insert');
                
         
        
    }


    function send_invoice_with_pdf(){
        error_reporting(0);
        $email_data['email'] = $_REQUEST['email'];
        $email_data['invoice_id'] = $_REQUEST['invoice_id'];
        $email_data['buyer'] = $_REQUEST['buyer'];
        $wp = $_REQUEST['wp'];
        if ($wp == 1) {
            $email_data['link'] = '/wp/'.$_REQUEST['invoicelink'];
        }  else {
            $email_data['link'] = $_REQUEST['invoicelink'];
        }   
        $data['sendtime'] = time();
        if ($_REQUEST['sender']) {
            $data['sender'] = $_REQUEST['sender'];
        }
        if ($_REQUEST['emp_email']) {
            $emp_email = $_REQUEST['emp_email'];
        }
        $data['count'] = (isset($_REQUEST['count'])?$_REQUEST['count']:0);
        $data['count'] = $data['count'] + 1;
        $this->CommanModel->saveData('setproject',$data, $email_data['invoice_id']);
        $emp_emails = $emp_email.',sales@schildr.com';
        //$emp_emails = 'missjankipatel@gmail.com';

         
        $link = $_REQUEST['invoicelink'];
        $data['main'] =  $this->CommanModel->get_by('l_settings', array(), FALSE, FALSE, TRUE);		
		$data['setproject'] =  $this->CommanModel->get_by('setproject', array('link'=>$link), FALSE, FALSE, TRUE);
       // pp($link);	
		$subprojects =  $this->CommanModel->get_by('setproject', array('parent_id'=>$data['setproject']->id), FALSE, FALSE, FALSE);		
		$selprods = $this->CommanModel->get_by('selproducts', array('category_id'=>$data['setproject']->id), FALSE, FALSE, FALSE);

        $setproject = $data['setproject'];
        $extratotal = floatval($setproject->tax) +
            floatval($setproject->shipping) +
            floatval($setproject->transportation) +
            floatval($setproject->insurance) +
            floatval($setproject->extra) +
            floatval($setproject->install) +
            floatval($setproject->incomen);

        $included = array();
        if (floatval($setproject->tax)) {
            array_push($included, 'Tax');
        }
        if (floatval($setproject->shipping)) {
            array_push($included, 'Shipping');
        }
        if (floatval($setproject->install)) {
            array_push($included, 'Installation');
        }
        if (floatval($setproject->insurance)) {
            array_push($included, 'Insurance');
        }

        $thisemploee = get_langer('employees', false, $setproject->employee);
        $thisbranch = get_langer('branches', 8, $thisemploee->branch_id);
        $thisregion = get_langer('regions', 8, $thisbranch->region_id);
        $thiscurrency = get_langer('currency', false, $thisbranch->currency);
        $branchtel = explode(',', $thisbranch->phones);
        $subcatm = get_langer('pdcats', 8, $setproject->product_category);
        $maincatm = get_langer('pdcats', 8, $subcatm->parent_id);

		$logo = 'https://schildr.com/assets/uploads/sites/logo_main_1.png';
        if($thisbranch->image) {
			$logo = 'https://schildr.com/assets/uploads/branches/full/'.$thisbranch->image;
		}      
       
        $html = '<table cellpadding="4"><tr><td><table>';
        $html .= '<tr><td><img width="130" src="'.$logo.'"/></td></tr>';
            if ($thisbranch->ortype != 'virtual') {
                $html .= '<tr><td><b>'.$thisbranch->name.'</b></td></tr>';
                $html .= '<tr><td>'.$thisbranch->address.'</td></tr>';
                $html .= '<tr><td height="25"><b>Branch contacts:</b>';
                $i = 0;
                foreach ($branchtel as $tel) {
                    $html .= '<span>'.$tel; if (next($branchtel)) { $html .= ','; }
                    $i = $i + 1;
                    $html .= '</span>';
                }
                $html .= '</td></tr>';
                $html .= '<tr><td><b>Created by:</b> '.$thisemploee->first_name.' '.$thisemploee->last_name.'</td></tr>';
                $html .= '<tr><td><b>Phones:</b> '.$thisemploee->mobile.'</td></tr>';
            }
        
        $html .= '</table></td>';
        if ($setproject->invoice == 1) {
            $takename = 'INVOICE';
        }
        else {
            $takename = 'ESTIMATE';
        }

        $addhtml = '';
        $colspan = '8';
        $f1 = '30';
		$f2 = '125';
		$f3 = '80';
		$f4 = '157';
		$f5 = '157';
		$f6 = '90';
		$f7 = '90';
		$f8 = '35';
        $f9 = '';
        $f10 = '';
        $imagesize = '10';
        if ($wp == 1) {
            $f1 = '30';
            $f2 = '100';
            $f3 = '75';
            $f4 = '157';
            $f5 = '157';
            $f6 = '60';
            $f7 = '80';
            $f8 = '35';
            $f9 = '35';
            $f10 = '35';
            
            $addhtml .= '<th scope="col" style="background-color: #eeeeee;" width="'.$f9.'" class="up">Unit<br>Price</th><th scope="col" style="background-color: #eeeeee;" class="tp" width="'.$f10.'" >Total<br>Price</th>';
            $colspan = '10';
        }
        
        $html .= '<td><table  align="right" nobr="true"><tr><td height="25"><h2>'.$takename.'</h2></td></tr>';
        $html .= '<tr><td><b>Project Number:</b> '.$thisbranch->code . '/' . $setproject->id.'</td></tr>';
        $html .= '<tr><td height="25"><b>Date:</b> <span>'.branchtime($setproject->created, $thisbranch->diff, 'M d,Y').'</span></td></tr>';
        $html .= '<tr><td><b>Customer:</b> <span>'.$setproject->buyer.'.</span></td></tr>';
        $html .= '<tr><td><b>Address or ZIP:</b> <span>'.$setproject->address.'.</span></td></tr>';
        $html .= '</table></td></tr></table><br><br>';
        $html .= '<table cellpadding="4" nobr="true" class="table" style="width:100%;"><tr><td colspan="'.$colspan.'" style="border:none;"><h4>'.$maincatm->title.'</h4></td></tr>';
        $html .= '<tr  class="s-item"><th style="background-color: #eeeeee;" scope="col" class="nm" width="'.$f1.'">No</th><th scope="col" class="pn" style="background-color: #eeeeee;" width="'.$f2.'">Product Name</th><th width="'.$f3.'" scope="col" class="dm" style="background-color: #eeeeee;">Dimension ('.$thisbranch->metric.')</th><th scope="col" width="'.$f4.'" class="stc" style="background-color: #eeeeee;">Structure Color</th><th width="'.$f5.'" scope="col" class="cvc" style="background-color: #eeeeee;">Cover Option</th><th scope="col" width="'.$f6.'" class="ma" style="background-color: #eeeeee;">Motor<br>Automation</th><th scope="col" class="des" width="'.$f7.'" style="background-color: #eeeeee;">Description</th><th scope="col" width="'.$f8.'" class="qt" style="background-color: #eeeeee;">Qty</th>'.$addhtml.'</tr>';
        $i = 1;
        $total = 0;
        $selprods = orinpro($selprods);
        foreach ($selprods as $selprod) {
            $thisproduct = get_langer('product', 8, $selprod->sproduct);
            $total = $total;
            if (is_numeric($selprod->qty) && is_numeric($selprod->uprice)) {
                $total = $total + $selprod->uprice * $selprod->qty;
            }
            $scolor = get_langer('colors', 8, $selprod->scolor);
            $fcolor = get_langer('colors', 8, $selprod->fcolor);
            $html .= '<tr nobr="true"><td width="'.$f1.'">'.$i.'</td><td width="'.$f2.'"><b>'.$thisproduct->title.'</b></td><td width="'.$f3.'">'.$selprod->dimensions.'</td><td width="'.$f4.'">';
            //pp($scolor);
            if (isset($scolor->image)) {
                $html .= '<img width="'.$imagesize.'" height="'.$imagesize.'" src="/assets/uploads/colors/small/'.$scolor->image.'" />&nbsp;';
            }
            $html .= isset($scolor->title)?$scolor->title:'';
            $html .= '</td><td width="'.$f5.'">';
            if (isset($fcolor->image)) {
                $html .= '<img width="'.$imagesize.'" height="'.$imagesize.'" src="/assets/uploads/colors/small/'.$fcolor->image.'" />&nbsp;';
            }
            $html .= isset($fcolor->title)?$fcolor->title:'';
            $html .= '</td><td width="'.$f6.'">'.$selprod->motorauto.'</td><td width="'.$f7.'">'.$selprod->additional.'</td><td width="'.$f8.'">'.$selprod->qty.'</td>';
            if ($wp == 1) {
                $html .= '<td width="'.$f9.'">'.$selprod->uprice.'</td><td width="'.$f10.'">'.($selprod->qty*$selprod->uprice).'</td>';
            }
            $html .= '</tr>';
            $i = $i + 1;
        }
        $html .= '<tr><td colspan="'.$colspan.'" align="right" style="border:none;">';
        if ($total) {
            $html .= '<h4>Total: <b>';
            if ($thiscurrency->symbol == '$' or $thiscurrency->symbol == '£') {
                $html .= $thiscurrency->symbol;
            }
            $html .= number_format(($total + $extratotal));
            
            if ($thiscurrency->symbol <> '$' and $thiscurrency->symbol <> '£') {
                $html .= $thiscurrency->symbol;
            }
            $html .= '</b></h4></td></tr>';
        }
        $html .= '</table>';
        foreach ($subprojects as $subproje) {
            $subproducts = orinpro(get_table_where('selproducts', array('category_id' => $subproje->id)));
            $subcat = get_langer('pdcats', 8, $subproje->product_category);
            $maincat = get_langer('pdcats', 8, $subcat->parent_id);
            $html .= '<table nobr="true" cellpadding="4"  style="width:100%" class="table table-bordered "><tr nobr="true"><td colspan="'.$colspan.'" style="border:none;" ><h4>'.$maincat->title.'</h4></td></tr>';
            $html .= '<tr class="s-item" nobr="true"><th scope="col" class="nm" style="background-color: #eeeeee;" width="'.$f1.'">No</th><th  style="background-color: #eeeeee;" width="'.$f2.'" scope="col" class="pn">Product Name</th><th style="background-color: #eeeeee;" scope="col" class="dm" width="'.$f3.'">Dimension ('.$thisbranch->metric.')</th><th width="'.$f4.'" style="background-color: #eeeeee;" scope="col" class="stc">Structure Color</th><th scope="col" class="cvc" width="'.$f5.'" style="background-color: #eeeeee;">Cover Option</th><th style="background-color: #eeeeee;" scope="col" class="ma" width="'.$f6.'">Motor Automation</th><th style="background-color: #eeeeee;" scope="col" width="'.$f7.'" class="des">Description</th><th width="'.$f8.'" style="background-color: #eeeeee;" scope="col" class="qt" >Qty</th>'.$addhtml.'</tr>';
            $i = 1;
            $total = 0;
            foreach ($subproducts as $selprod) {
                $thisproduct = get_langer('product', 8, $selprod->sproduct);
                $total = $total;
                if (is_numeric($selprod->qty) && is_numeric($selprod->uprice)) {
                    $total = $total + $selprod->uprice * $selprod->qty;
                }
                $scolor_2 = get_langer('colors', 8, $selprod->scolor);
                $fcolor_2 = get_langer('colors', 8, $selprod->fcolor);
                $html .= '<tr class="pagebreak" nobr="true">';
                $html .= '<td width="'.$f1.'">'.$i.'</td><td width="'.$f2.'"><b>'.$thisproduct->title.'</b></td><td width="'.$f3.'">'.$selprod->dimensions.'</td><td width="'.$f4.'">';
                if (isset($scolor_2->image)) {
                    $html .= '<img width="'.$imagesize.'" height="'.$imagesize.'" src="/assets/uploads/colors/small/'.$scolor_2->image.'" />&nbsp;';
                }                
                $html .= isset($scolor_2->title)?$scolor_2->title:'';
                $html .= '</td><td width="'.$f5.'">';
                if (isset($fcolor_2->image)) {
                    $html .= '<img width="'.$imagesize.'" height="'.$imagesize.'" src="/assets/uploads/colors/small/'.$fcolor_2->image.'" />&nbsp;';
                }
                $html .= isset($fcolor_2->title)?$fcolor_2->title:'';
                $html .= '</td><td width="'.$f6.'">'.$selprod->motorauto.'</td><td width="'.$f7.'">'.$selprod->additional.'</td><td width="'.$f8.'">'.$selprod->qty.'</td>';

                if ($wp == 1) {
                    $html .= '<td width="'.$f9.'">'.$selprod->uprice.'</td><td width="'.$f10.'">'.($selprod->qty*$selprod->uprice).'</td>';
                }

                $html .= '</tr>';
                                 
                $i = $i + 1;                
            }
            $html .= '<tr nobr="true"><td colspan="'.$colspan.'" align="right" style="border:none;" >';
            if ($total) {
                $html .= '<h4>Total: <b>';
                if ($thiscurrency->symbol == '$' or $thiscurrency->symbol == '£') {
                    $html .= $thiscurrency->symbol;
                }
                $html .= number_format(($total + $extratotal));
                if ($thiscurrency->symbol <> '$' and $thiscurrency->symbol <> '£') {
                    $html .= $thiscurrency->symbol;
                }
                $html .= '</b></h4></td></tr>';
            }
            $html .= '</table>';
        }
        $html .= '<table nobr="true" cellpadding="4"><tr><td style="border:none;"><h3><b>IMPORTANT NOTES</b></h3></td></tr>';
        if ($total) {
            if ($extratotal) {
                $html .= '<tr><td><b>Option included:</b>'.implode(', ', $included).'</td></tr>';
            }
        }
        $html .= '<tr><td>'.html_entity_decode($setproject->notes).'</td></tr>';
        $html .= '<tr><td>'.html_entity_decode($thisbranch->about).'</td></tr>';
        if ($setproject->invoice == 1) {
            $html .= '<tr><td><h4><b>OUR REQUISITES</b></h4></td></tr>';
            $html .= '<tr><td>'.html_entity_decode($thisbranch->requisite).'</td></tr>';
        }

        //$html .= '<tr><td><img width="130" src="https://schildr.com/assets/uploads/sites/logo_main_1.png" /></td></tr>';
        $html .= '</table>';
        //echo $html;die;

        $htmlsend = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
    h1 {
        font-size: 24pt;
    }
    td {
        height:14pt;
    }
    .table td, th{border: 1px solid #eeeeee;  border-collapse: collapse;}
    th{background-color: #FFFF66;}
    table{width:100%;}
</style>
$html
EOF;

        //create_PDF($htmlsend);
        $adata = $_SERVER['DOCUMENT_ROOT'].'/assets/invoicePDF/Invoice.pdf';
        
        //$sendemail = sendmail2(15,$email_data['email'],$email_data,$emp_emails,true,$adata);
        $sendemail = sendmail2(15,$email_data['email'],$email_data,$emp_emails,false,'');



        //$d_action = 'Email with PDF successfully sent for <b>Invoice #'.$email_data['invoice_id'].'</b>.';
        $d_action = 'Email successfully sent for <b>Invoice #'.$email_data['invoice_id'].'</b>.';		
                $logged_in = $this->data['adminDetails'];
                $employeeid = $logged_in->employee_id;
                $insertactivity['employee'] = $employeeid;
                $insertactivity['d_action'] = $d_action;
                $insertactivity['created']  = date("Y-m-d H:i:s");
                activitylogs($insertactivity,'insert');

                
        $sendmessage = '0';
        if($sendemail){
            $sendmessage = '1';
        }
        unlink($adata);
        return $sendmessage;
    }

    function invoiceajaxEdit(){
        $postdata = $this->postdata;
        $msg = 'status';
        $maininvoiceid  = $postdata['invoiceid'];
        $id             = $postdata['row_id'];
        $value          = $postdata['targetvalue'];
        $field          = $postdata['targetname'];
        $optionid       = $postdata['optionid'];        
        $retn = array();
        $total_price    = $postdata['totalprice']; 
        $product_category = $postdata['product_category'];
        $yesorno = 'no'; 
        if($id != ""){
            if($id == 'create_new'){
                if(strpos($optionid, 'created_') !== false) {
                    $custom_data = array();
                    $custom_data['parent_id'] = $maininvoiceid;//timestamp
                    $custom_data['employee'] = 'inherit';
                    $custom_data['buyer'] = 'inherit';
                    $custom_data['product_category'] = $product_category;//timestamp
                    $custom_data['total_price'] = $total_price;                    
                    $nuid = $this->CommanModel->addSelProject($custom_data);                 
                    $optionid = $nuid;
                    $yesorno = 'yes'; 
                }                
                $newData[$field] = $value;
                $newData['category_id']=$optionid;
                $newData['qty']=1;
                
                $newId = $this->CommanModel->addSelProducts('selproducts', $newData);

                

            
                
                $this->CommanModel->saveData('setproject', array('total_price' => $total_price, 'product_category' => $product_category), $optionid);

                $d_action = 'New Row in <b>Invoice #'.$maininvoiceid.'</b> has been created.';		
                $logged_in = $this->data['adminDetails'];
                $employeeid = $logged_in->employee_id;
                $insertactivity['employee'] = $employeeid;
                $insertactivity['d_action'] = $d_action;
                $insertactivity['created']  = date("Y-m-d H:i:s");
                activitylogs($insertactivity,'insert');

                    
                $retn['status'] = 'success';
                $retn['message'] = '';
                $retn['added_row'] = $newId;
                $retn['optionid'] = $optionid;
                $retn['new_option'] = $yesorno;
                
            }
            else {
                if($value != "" && $field != ""){
                    $this->CommanModel->updateSelProducts('selproducts', $id, $field, $value);
                    $this->CommanModel->saveData('setproject', array('total_price' => $total_price, 'product_category' => $product_category), $optionid);
                    $retn['status'] = 'success';
                    $retn['message'] = '';
                    $retn['added_row'] = $id;
                    $retn['optionid'] = $optionid;
                    $retn['new_option'] = $yesorno;

                    $d_action = '<b>'.$field.'</b> field in Row for <b>Invoice #'.$maininvoiceid.'</b> has been updated.';		
                    $logged_in = $this->data['adminDetails'];
                    $employeeid = $logged_in->employee_id;
                    $insertactivity['employee'] = $employeeid;
                    $insertactivity['d_action'] = $d_action;
                    $insertactivity['created']  = date("Y-m-d H:i:s");
                    activitylogs($insertactivity,'insert');

                
                } else {
                    $retn['status'] = 'error';
                    $retn['message'] = 'Please enter or select details.';
                    $retn['added_row'] = $id;
                    $retn['optionid'] = $optionid;
                    $retn['new_option'] = $yesorno;
                }
            }
        }
        echo json_encode($retn);die;
    }
        
    function getProductsForCategory($category = 0) {
        $products =  multiproduct ($category , 8, array());
        return $products;
    }
    
    function getColorsForCategory($category = 0) {
        
        $thispdcat = $this->CommanModel->get_lang('pdcats',$this->data['admin_lang'],false,array('id'=>$category),'connlang_id',true);
        $thiscat = $this->CommanModel->get_lang('pdcats',$this->data['admin_lang'],false,array('id'=>$thispdcat->parent_id),'connlang_id',true);
        
        $colors =  ColorsByCategory ($thiscat->secolorcats);
        
        $rescolors = array();
        
        foreach ($colors as $color) {
            
            foreach ($color as $col) {
                
                $col->titlem = $this->CommanModel->get_lang('colorcats',$this->data['admin_lang'],false,array('id'=>$col->category),'connlang_id',true)->title;
            
                array_push($rescolors, $col);    
            
            }
        } 
        
        return $rescolors ;
        
        
        
    }
    

    function getAjaxProducts() {
        $category= $_GET['category'];

        $this_cat = get_langer('pdcats',8,$category);
        $main_cat = get_langer('pdcats',8,$this_cat->parent_id);
        $colcats = explode(',',$main_cat->secolorcats);
        $coloritems = $this->CommanModel->get_lang('colors',$this->data['admin_lang'],false,array('enabled'=>1),'connlang_id',FALSE);
        $colorcode = options_for_fcolor($colcats,$coloritems);
        
        $sendata['colorcode'] = $colorcode;
        $sendata['categorieslist'] = $this->getProductsForCategory($category);
        echo json_encode($sendata);
    }

    function getAjaxColors() {
        $category= $_GET['category'];
        echo json_encode($this->getColorsForCategory($category));
    }


    function createInvoice($id) {
        $quote      = $this->QuotesModel->get($id, FALSE);
        $invoice    = $this->CommanModel->get_by('setproject', array('quote_id' => $quote->id), FALSE, FALSE, true);
        if(!empty($invoice)) {
            if (!$invoice->sendtime) {
                return redirect()->to($this->data['_edit'].'/'.$invoice->id);
            }
            else {
                return redirect()->to($this->data['_cancel'].'/extra/'.$invoice->id);
            }
        } else {
            if($quote->pid != NULL || $quote->pid != "") {
                $products   = explode(",", $quote->pid);
                $category   = $this->CommanModel->get_by('product', array('id' => $products[0]), FALSE, FALSE, true)->category;
            } else {
                $products   = [];
                $category   = $quote->incat;
            }
            
            $mainid   = $this->CommanModel->get_by('product', array('category'=>$category, 'type' => 'main'), FALSE, FALSE, true);
            
            if ($mainid) {
                
                array_unshift($products,$mainid->id);
                
            }
            
            
            
            
            if($this->data['adminDetails']->role == 'Branch Admin') {
                $employeeid = $this->data['adminDetails']->employee_id;
            } else {
                $employee   = $this->CommanModel->get_by('employees', array('branch_id'=>$quote->branch_id,'rep'=>1), FALSE, FALSE, true);
                $employeeid = $employee->id;
            }
            //create a new invoice
            $newInvoiceData = array(
                'product_category'  => $category,
                'address'           => $quote->zipcode,
                'phone'             => $quote->phone,
                'email'           => $quote->email,
                'category'          => "",
                'employee'          => $employeeid,
                'quote_id'          => $quote->id,
                'buyer'             => $quote->first_name." ".$quote->last_name,
                'link'              => md5(time() . rand())
            );
            $newInvoice = $this->CommanModel->saveData('setproject', $newInvoiceData, NULL);
            //Insert products for created invoice
            $i=1; foreach($products as $product) {
                if($product != "" && $product > 0) {
                    if ($i == 1) {
                        $newSelProductData = array(
                            'category_id'   => $newInvoice,
                            'sproduct'      => $product,
                            'dimensions'    => $quote->width." X ".$quote->depth,
                            'qty'           => 1,
                            'on_date'       => date('Y-m-d H:i:s')
                        );
                    } else {
                        $newSelProductData = array(
                            'category_id'   => $newInvoice,
                            'sproduct'      => $product,
                            'dimensions'    => '',
                            'qty'           => 1,
                            'on_date'       => date('Y-m-d H:i:s')
                        );    
                    }
                    $newSelProduct = $this->CommanModel->saveData('selproducts', $newSelProductData, NULL); 
                    $i++;
                }
            }
            return redirect()->to($this->data['_edit'].'/'.$newInvoice);
        }
    }

    function updateInvoiceNotes() {
        $message = 'error';
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;
            $invoiceId  = $postdata['category_id'];
            $notes      = $postdata['notes'];
            $tax        = $postdata['tax'];
            $shipping   = $postdata['shipping'];
            $transportation   = $postdata['transportation'];
            $insurance   = $postdata['insurance'];
            $incomen    = $postdata['incomen'];
            $install    = $postdata['install'];
            $extra      = $postdata['extra'];
            $internal      = $postdata['internal'];

            $d_action = '<b>Invoice #'.$invoiceId.'</b> notes updated.';		
            $logged_in = $this->data['adminDetails'];
            $employeeid = $logged_in->employee_id;
            $insertactivity['employee'] = $employeeid;
            $insertactivity['d_action'] = $d_action;
            $insertactivity['created']  = date("Y-m-d H:i:s");
            activitylogs($insertactivity,'insert');

            $this->CommanModel->saveData('setproject', array('internal' => $internal,'notes' => $notes,'tax'=>$tax,'shipping'=>$shipping,'transportation'=>$transportation,'insurance'=>$insurance,'incomen'=>$incomen,'install'=>$install,'extra'=>$extra), $invoiceId);
            $message = 'success';
        }
        echo $message;
    }


    public function deleteinvoice($id)	{
        $this->CommanModel->deleteData('setproject', array('id' => $id));
        $this->CommanModel->deleteData('selproducts', array('category_id' => $id));
        $parents = $this->CommanModel->get_by('setproject',array('parent_id'=>$id),false,false,false);
        foreach($parents as $parent) {
            $this->CommanModel->deleteData('selproducts', array('category_id' => $parent->id));
        }
        $this->CommanModel->deleteData('setproject', array('parent_id' => $id));
        $this->data['session']->setFlashdata('success','Data has successfully deleted');

        $d_action = '<b>Invoice #'.$id.'</b> deleted.';		
        $logged_in = $this->data['adminDetails'];
        $employeeid = $logged_in->employee_id;
        $insertactivity['employee'] = $employeeid;
        $insertactivity['d_action'] = $d_action;
        $insertactivity['created']  = date("Y-m-d H:i:s");
        activitylogs($insertactivity,'insert');
            
        return redirect()->to($this->data['_cancel']);
    }
    
    function extra ($id) {
        $data = $this->data;
        $this->data['name'] = 'Invoice Data';
        $this->data['title'] = $this->data['name'];
        $this->data['main'] =  $this->CommanModel->get_by('l_settings', array(), FALSE, FALSE, TRUE);
		$this->data['setproject'] =  $this->CommanModel->get_by('setproject', array('id'=>$id), FALSE, FALSE, TRUE);
		$this->data['subprojects'] =  $this->CommanModel->get_by('setproject', array('parent_id'=>$this->data['setproject']->id), FALSE, FALSE, FALSE);
		$this->data['selprods'] = $this->CommanModel->get_by('selproducts', array('category_id'=>$this->data['setproject']->id), FALSE, FALSE, FALSE);
        $this->data['subview'] = $this->_subView.'extra';
        echo view('admin/_layout_main', $this->data);
    }
    
    
    function clone($id) {
        $mainInvoice = $this->CommanModel->get_by('setproject',array('id'=>$id),false,false,true);
        if ($mainInvoice) {
            $mainInvoice->sendtime = '';
            $mainInvoice->sender = '';
            $mainInvoice->link = md5(time() . rand());
            $mainInvoice->created = time();
            $cloned_main_invoice = json_decode(json_encode($mainInvoice), true);
            $clonedMain = $this->CommanModel->saveData('setproject', $cloned_main_invoice, NULL);
            $this->data['MainInvoiceProducts'] = $this->CommanModel->get_by('selproducts',array('category_id'=>$mainInvoice->id),false,false,false);
            foreach ($this->data['MainInvoiceProducts'] as $newMainInvoice) {
                $newMainInvoice->id = null;
                $newMainInvoice->category_id = $clonedMain;
                $clonedMainproducts = $this->CommanModel->saveData('selproducts', json_decode(json_encode($newMainInvoice), true), NULL);
            }
        }
        $subInvoices = $this->CommanModel->get_by('setproject',array('parent_id'=>$id),false,false,false);
        if ($subInvoices) {
            foreach ($subInvoices as $subInvoice) {
                $clonedSubProducts = $this->CommanModel->get_by('selproducts',array('category_id'=>$subInvoice->id),false,false,false);
                $subInvoice->id = null;
                $subInvoice->parent_id = $clonedMain;
                $clonedSub = $this->CommanModel->saveData('setproject', json_decode(json_encode($subInvoice), true), NULL);
                foreach ($clonedSubProducts as $clonedSubProduct) {
                    $clonedSubProduct->id = null;
                    $clonedSubProduct->category_id = $clonedSub;
                    $prods = $this->CommanModel->saveData('selproducts', json_decode(json_encode($clonedSubProduct), true), NULL);
                }
            }
        }

        $d_action = '<b>Invoice #'.$id.'</b> cloned.';		
        $logged_in = $this->data['adminDetails'];
        $employeeid = $logged_in->employee_id;
        $insertactivity['employee'] = $employeeid;
        $insertactivity['d_action'] = $d_action;
        $insertactivity['created']  = date("Y-m-d H:i:s");
        activitylogs($insertactivity,'insert');

        
        $this->data['session']->setFlashdata('success','Data has successfully cloned');   
        return redirect()->to($this->data['_cancel']);
    }
}
