<?php

namespace App\Controllers\Manage; 


use App\Core\Admincontroller;
use App\Models\backend\Mixedmodel;
use App\Models\backend\Locproductsmodel;

class Loccart extends Admincontroller {
	
    public $_table_names = 'locproducts';
    public $_subView = 'admin/loccart/';
    public $_redirect = '/loccart';
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
        $this->data['name'] = 'Shopping Cart';
	$this->data['title'] = 'Shopping Cart';
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
    public function addtocartstore(){
		
		if ($this->request->getMethod() == "post") {
            $post_data = $this->request->getPost();
            
            $sizevariant = $post_data['sizevariant'];
	    $colorvariant = $post_data['colorvariant'];
	    
            $quantity = $post_data['quantity'];
            $product_id = $post_data['mainproduct'];
            $type = $post_data['type'];
            $all_sizes = $this->data['all_sizes'];
	    $all_colors = $this->data['all_colors'];

			$product_result = $this->CommanModel->getDatam2('locproducts',array("id"=>$product_id),$this->data['admin_lang'],false,'id',false);
			$product_details = $product_result[0];
			$morefiles = morefiles('locproducts',$product_details->id);
			$file = $morefiles[0];
			$variant_name = '';
			$variant_name_2 = '';
			if($sizevariant > 0 ){
			    
			    foreach($all_sizes as $sizevar){
				    if($sizevar->id == $sizevariant){
					$variant_name = ' ( '.$sizevar->title.' ) ';
				    }
			    }
			}
			
			if($colorvariant > 0 ){
			    foreach($all_colors as $colorvar){
				    if($colorvar->id == $colorvariant){
					    $variant_name_2 = ' ( '.$colorvar->title.' ) ';
				    }
			    }
			}

			

            $idname = "product_".$product_id."_variant_size_".$sizevariant."_variant_color_".$colorvariant;

			$cart = $this->data['session']->get('cart');
			

			if(isset($cart[$idname])) {
				$cart[$idname]['quantity'] = $quantity;
			}
			else {
				//$variationname = " ( ".$variation->name." ) ";
				$cart[$idname] = [
					"name" => $product_details->title.$variant_name.$variant_name_2,
					"quantity" => $quantity,
					"price" => $product_details->nprice,
					"image" => $file->filename,
					"sizevariant"=>$sizevariant,
					"colorvariant"=>$colorvariant,
				];
			}
			$this->data['session']->set('cart', $cart);

			$e_message = 'Successfully added';
			if($type == 'update'){
				$e_message = 'Successfully updated';
			}
			
			$responsedata['status'] = 'success';
			$responsedata['e_message'] = $e_message;
			echo json_encode( $responsedata );            
			
		}
	}
	
	public function listcartstore(){
	    $cart = $this->data['session']->get('cart');
	    //pp($cart);
	    $cartarray_itemamount = array();
	    $totalamount = front_format_currency_helper(0);
	    $totalamountshow = 0;
	    $items = 0;
	    if($cart){
			$items = count($cart);
			
			foreach($cart as $key=>$cartitems){
				$showamount = round(($cartitems['quantity'])*($cartitems['price']),2);
				$amount  = front_format_currency_helper($showamount);
				$explodekey = explode("_",$key);                
				$totalamountshow += $showamount;
				$cartarray_itemamount[$key] = front_format_currency_helper($showamount);
			}
                                 
			$totalamount = trim(front_format_currency_helper($totalamountshow));
			
		}
		$taxamount = 0;
		$tax = front_format_currency_helper($taxamount);
		$totalwithtax = front_format_currency_helper(($totalamountshow)-($taxamount));

	    $html = '';
	    $responsedata = ['status'=>'success','totalwithtax'=>$totalwithtax,'tax'=>$tax,'html'=>$html,'cartarray_itemamount'=>$cartarray_itemamount,'totalitems'=>$items,'totalamount'=>$totalamount];
	    echo json_encode( $responsedata );
    }

    public function removecartstore(){
		if ($this->request->getMethod() == "post") {
            $post_data = $this->request->getPost();
			$productkey = $post_data['productkey'];  
			$cart = $this->data['session']->get('cart');
			if(isset($cart[$productkey])) {
				unset($cart[$productkey]);
			}
			$this->data['session']->set('cart', $cart);
			$responsedata = ['status'=>'success','e_message'=>'Successfully removed'];
			echo json_encode( $responsedata );
		}
	}
}
