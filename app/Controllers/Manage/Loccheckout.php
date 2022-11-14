<?php

namespace App\Controllers\Manage; 


use App\Core\Admincontroller;
use App\Models\backend\Mixedmodel;
use App\Models\backend\Locproductsmodel;

class Loccheckout extends Admincontroller {
	
    public $_table_names = 'locproducts';
    public $_subView = 'admin/loccheckout/';
    public $_redirect = '/loccheckout';
    protected $MixedModel;
    public function __construct(){
        parent::__construct();
        $this->MixedModel = new Mixedmodel();
        $this->data['ThisModule'] = $this->MixedModel;
        $this->data['CommanModel'] = $this->CommanModel;
        $this->data['active'] = 'Local Store';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->LocproductsModel = new Locproductsmodel();
	$this->data['_parent_folder'] = 'Local Store';
    }

    public function index() {
        $this->data['name'] = 'Checkout';
	$this->data['title'] = $this->data['name'];
        $cart = $this->data['session']->get('cart');

        $this->data['thisemployee']  = $this->CommanModel->get_by('employees', array('id'=>$this->data['adminDetails']->employee_id), FALSE, FALSE, true);
        $this->data['thisbranch'] = get_langer('branches', 8, $this->data['thisemployee']->branch_id);
        //$currency = get_langer('currency', false, $thisbranch->currency);

        if($cart){
			$this->data['cartitems'] = $cart;
		}
		else {
			$this->data['cartitems'] = array();
		}        
        $this->data['subview'] = $this->_subView.'index';
        echo view('admin/_layout_main',$this->data);
    }

    public function confirmorder(){
		$cart = $this->data['session']->get('cart');
		if(!$cart){
			$this->data['session']->setFlashdata('error','No data found.');
			return redirect()->to($this->data['_storelink']);
		}		
		$this->data['thisemployee']  = $this->CommanModel->get_by('employees', array('id'=>$this->data['adminDetails']->employee_id), FALSE, FALSE, true);
        $this->data['thisbranch'] = get_langer('branches', 8, $this->data['thisemployee']->branch_id);
		$items = count($cart);
		$totalamountshow = 0;
		$totalamounttoshow = 0;
		
		foreach($cart as $key=>$cartitem){
			$cartkeyexplode = explode("_",$key);
			
			//$product_id = $cartkeyexplode[1];
			//$variant_id = $cartkeyexplode[3];

			$product_id = $cartkeyexplode[1];
			$size_id = $cartkeyexplode[4];
			$color_id = $cartkeyexplode[7];
						
			
			$product_result = getDatam2('locproducts',array("id"=>$product_id),$this->data['admin_lang'],false,'id',false);
			$total_quantity = $product_result[0]->count;
			$remaning_quantity = floatval($total_quantity)-floatval($cartitem['quantity']);
			$this->CommanModel->saveData('locproducts',array('count'=>$remaning_quantity),$product_id);
			$showamount = round(($cartitem['quantity'])*($cartitem['price']),2);
			$totalamounttoshow += $showamount;			
			$products_array[] = $product_id."-".$size_id."-".$color_id;
		}
		$this->data['session']->set('cart',array());
		$ordersdata['products'] = implode(",",$products_array);
		$ordersdata['ordered_user'] = $this->data['adminDetails']->employee_id;
		$ordersdata['status'] = 'Waiting';
		$ordersdata['total_amount'] = $totalamounttoshow;
		$ordersdata['created'] = strtotime("now");		
		$this->CommanModel->saveData('locorders',$ordersdata,NULL);


		$d_action = 'New order placed. <a href="'.$this->data['_orderslink'].'" class="fs-6 text-gray-800 text-hover-primary fw-bold">View orders</a>';		
                $logged_in = $this->data['adminDetails'];
                $employeeid = $logged_in->employee_id;
                $insertactivity['employee'] = $employeeid;
                $insertactivity['d_action'] = $d_action;
                $insertactivity['created']  = date("Y-m-d H:i:s");
                activitylogs($insertactivity,'insert');

		
		$this->data['session']->setFlashdata('success','Successfully ordered.');
		return redirect()->to($this->data['_storelink']);
	}
}
