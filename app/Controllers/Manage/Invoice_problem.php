<?php

namespace App\Controllers\Admin123;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use App\Core\Admincontroller;
use App\Models\backend\Selproductsmodel;
use App\Models\backend\Quotesmodel;

class Invoice extends Admincontroller {
    public $_table_names = 'selproducts';		//set table
    public $_subView = 'admin/invoice';	//set subview
    public $_redirect = '/invoice';			//set controller link

    protected $StaticTextModel;       
    public function __construct(){
        parent::__construct();
        $this->QuotesModel      = new Quotesmodel();
        $this->data['active'] = 'Project management';
        $this->data['_edit']    = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel']  = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete']  = $this->data['admin_link'].$this->_redirect.'/delete';
        $this->data['controller'] = $this;
    }
    
    function index($id=NULL){		
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
        $this->data['subview'] = $this->_subView.'/index';
        echo view('admin/_layout_main',$this->data);
    }
    
    function deleterowdata(){
        $type = $_POST['type'];
        if($type == 'placed'){
            $mainidoption = $_POST['mainidoption'];
            $product_id = $_POST['product_id'];
            $invoiceid = $_POST['invoiceid'];
            $this->CommanModel->deleterowdata('selproducts',$product_id);
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
        $this->CommanModel->deleteoptions('selproducts',$mainidoption);
        $this->CommanModel->deleterowdata('setproject',$mainidoption);     
    }
    
    function cloneoption() {        
        $maincat = $_POST['maincat'];
        $product_id = $_POST['cat_id'];
        //$childids = $_POST['childids'];
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
        echo json_encode($response);die;      
    }
    
    function update_invoice_total() {
        $this->CommanModel->saveData('setproject', array('total_price' => $_GET['total']), $_GET['project_id']);
    }
    
    function send_invoice_mail () {
        $email_data['email'] = $_GET['email'];
        $email_data['invoice_id'] = $_GET['invoice_id'];
        $email_data['buyer'] = $_GET['buyer'];
        $email_data['link'] = $_GET['link'];
        
        $data['sendtime'] = time();
        
        if ($_GET['sender']) {
            $data['sender'] = $_GET['sender'];
        }
        
        
        
        $data['count'] = $_GET['count'];
        
        $data['count'] = $data['count'] + 1;
        
        
        
       // echo '<pre>';print_r($data);die();
        
        $this->CommanModel->saveData('setproject',$data, $email_data['invoice_id']);
        
        
        
        
        
         sendmail(15,$email_data['email'],$email_data);
        
    }

    function invoiceajaxEdit(){
        $msg = 'status';
        $maininvoiceid  = $_POST['invoiceid'];
        $id             = $_POST['row_id'];
        $value          = $_POST['targetvalue'];
        $field          = $_POST['targetname'];
        $optionid       = $_POST['optionid'];        
        $retn = array();
        $total_price    = $_POST['totalprice']; 
        $product_category = $_POST['product_category'];
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
    
  
    

    function getAjaxProducts() {
        $category= $_GET['category'];
        echo json_encode($this->getProductsForCategory($category));
    }

 


    function createInvoice($id) {
      
        
        $quote      = $this->QuotesModel->get($id, FALSE);
        
        //check if the invoice for quote is existing.
        $invoice    = $this->CommanModel->get_by('setproject', array('quote_id' => $quote->id), FALSE, FALSE, true);

        if(!empty($invoice)) {
            //if the invoice is exiting, redirect to that invoice
            
            if (!$invoice->sendtime) {
                return redirect()->to(base_url().'/admin123/invoice/index/'.$invoice->id);
            } else {
                return redirect()->to(base_url().'/admin123/setproject/extra/'.$invoice->id);
            }
            
        } else {
            //if invoice is not exsiting, create a new one
            // get products ids array in the quote
            if($quote->pid != NULL || $quote->pid != "") {
                $products   = explode(",", $quote->pid);
                $category   = $this->CommanModel->get_by('product', array('id' => $products[0]), FALSE, FALSE, true)->category;
                
                
            } else {
                $products   = [];
                $category   = $quote->incat;
            }
            
            $mainid   = $this->CommanModel->get_by('product', array('category'=>$category, 'type' => 'main'), FALSE, FALSE, true);
            
            
            array_unshift($products,$mainid->id);
            
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
                'phone'           => $quote->phone,
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

            return redirect()->to(base_url().'/admin123/invoice/index/'.$newInvoice);
        }
    }

    function updateInvoiceNotes() {
        $invoiceId  = $_GET['category_id'];
        $notes      = $_GET['notes'];
        $tax        = $_GET['tax'];
        $shipping   = $_GET['shipping'];
        $transportation   = $_GET['transportation'];
        $insurance   = $_GET['insurance'];
        $incomen    = $_GET['incomen'];
        $install    = $_GET['install'];
        $extra      = $_GET['extra'];
        $internal      = $_GET['internal'];

        $this->CommanModel->saveData('setproject', array('internal' => $internal,'notes' => $notes,'tax'=>$tax,'shipping'=>$shipping,'transportation'=>$transportation,'insurance'=>$insurance,'incomen'=>$incomen,'install'=>$install,'extra'=>$extra), $invoiceId);

        echo "success";
    }
}
