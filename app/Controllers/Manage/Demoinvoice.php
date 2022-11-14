<?php

namespace App\Controllers\Admin123;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use App\Core\Admincontroller;
use App\Models\backend\Selproductsmodel;
use App\Models\backend\Quotesmodel;

class Demoinvoice extends Admincontroller {
    public $_table_names = 'selproducts';		//set table
    public $_subView = 'admin/demoinvoice';	//set subview
    public $_redirect = '/demoinvoice';			//set controller link

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
       
        $html = '<table cellpadding="4" style="width:100%;"><tr><td><table>';
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
        $html .= '<tr><td><img width="130" src="https://schildr.com/assets/uploads/sites/logo_main_1.png" /></td></tr>';
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

        create_PDF_demo($htmlsend);die;
        $adata = $_SERVER['DOCUMENT_ROOT'].'/assets/invoicePDF/Invoice.pdf';;
        $sendemail = sendmail2(15,$email_data['email'],$email_data,$emp_emails,true,$adata);
        $sendmessage = '0';
        if($sendemail){
            $sendmessage = '1';
        }
        unlink($adata);
        return $sendmessage;
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
