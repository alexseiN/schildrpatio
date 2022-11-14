<?php

namespace App\Controllers\Admin123;

use App\Core\Admincontroller;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordermanage extends Admincontroller {
    public $_table_names = 'users_order';
    public $_subView = 'admin/order_manage/';
    public $_redirect = '/ordermanage';

    public function __construct(){
        parent::__construct();
        $this->data['active'] = 'Order Management';

        $this->data['CommanModel'] = $this->CommanModel;

        $this->data['_add'] = $this->data['admin_link'].$this->_redirect.'/create';
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_view'] = $this->data['admin_link'].$this->_redirect.'/view';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';

        $redirect = false;
        if($this->data['adminDetails']->default=='0'){
            if($this->data['adminDetails']->is_order==1){}
            else{
                $redirect = true;
            }
        }
        if($redirect){
            $this->data['session']->setFlashdata('error','Sorry ! You have no permission.');
            return redirect()->to(base_url().'/'.$this->data['admin_link'].'/dashboard');
        }
        $this->data['lang_id'] =$this->data['adminLangSession']['lang_id'];
    }


    //  Landing page of admin section.
    function index(){
        //$this->data['table'] = true;
        $this->data['name'] = 'Order History';
        $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];
        
        $this->data['all_data'] = $this->CommanModel->get_by($this->_table_names,array('payment_status'=>1),false,false,false);

        $this->data['subview'] = $this->_subView.'index';
        echo view('admin/_layout_main',$this->data);
    }

    //  Landing page of admin section.
    function newOrder(){
        //$this->data['table'] = true;
        $rules = array(
            'user_id' =>array('field'=>'user_id','label'=>'user','rules'=>'trim|required'),
        );

        $this->data['validation'] = \Config\Services::validation();
        $input = $this->validate($rules);

        if ($_POST){
            if($input) {
                $request = \Config\Services::request();
                $items = $request->getPost('item');
                if($items){
                    $post_item = array();
                    $total = 0;
                    foreach($items as $set_tiem){
                        $total = $total+$set_tiem['price'];
                        $tmp =  array(
                            'product_id'		=> $set_tiem['id'],
                            'quantity'			=> 1,
                            'price'				=> $set_tiem['price'],
                        );
                        $post_item[] =$tmp;
                    }
                    $post_data = array(
                        'user_id'			=> $request->getPost('user_id'),
                        'on_date'			=> date('Y-m-d'),
                        'payment_status'	=> 1,
                        'payment_type'		=> 'Admin',
                        'sub_total'			=> $total,
                        'total'				=> $total,
                        'status'			=> 'Pending'
                    );
                    $order_ids = $this->CommanModel->saveData('users_order',$post_data);
                    $updateOrder = array(
                        'order_number'	=> h_orderNumber2($order_ids,'DO',5),
                    );

                    $db = \Config\Database::connect();
                    $builder = $db->table('users_order');
                    $builder->where('id', $order_ids);
                    $builder->set($updateOrder);
                    $builder->update();

                    if($post_item){
                        foreach($post_item as $key=>$val){
                            $post_item[$key]['order_id'] = $order_ids;
                        }
                    }
                    $builder = $db->table('users_order_item');
                    $builder->insertBatch($post_item);
                    $builder->update();

                    $this->data['session']->setFlashdata('success','Order has successfully created');
                    return redirect()->to(base_url().'/'.$this->data['_cancel']);
                }
                else{
                    $this->data['session']->setFlashdata('error','Please select at least 1 product!!');
                    return redirect()->to(base_url().'/'.$this->data['_cancel'].'/new_order');
                }
            }
        }

        $string = "select username,id from users where account_type='U' and confirm ='confirm' order by username";
        $this->data['user_list'] = $this->CommanModel->get_query($string,false);

        $string = "select id,title,price from products join products_lang on products_lang.products_id=products.id where language_id=".$this->data['content_language_id']." order by title";
        $this->data['product_list'] = $this->CommanModel->get_query($string,false);

        $this->data['name'] = 'Order';
        $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];
        $this->data['subview'] = $this->_subView.'order_form';
        echo view('admin/_layout_main',$this->data);
    }

    function view($id=false){
        if(!$id){
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }
        //$this->data['table'] = true;
        $this->data['name'] = 'Order view';
        $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];
        $this->data['login'] = $this->data['session']->get();
        $this->data['order_id'] = $id;
        $check  = $this->CommanModel->get_by($this->_table_names,array('id'=>$id,'payment_status'=>1),false,false,true);
        if(empty($check)){
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }

        $request = \Config\Services::request();

        if($request->getPost('history'))
        {
            $post_data = $this->CommanModel->array_from_post(array('comment','order_status'));

            $post_data['date_added'] = date('Y-m-d H:i:s');
            $post_data['order_id'] = $id;
            $this->CommanModel->saveData('users_order_history',$post_data);

            //return redirect()->to(base_url().'/'.$this->data['_cancel']);
            return redirect()->to(base_url().'/'.$this->data['_cancel'].'/view/'.$id);
        }

        $this->data['order_histroy_data'] = $this->CommanModel->get_by('users_order_history',array('order_id'=>$id),false,false,false);

        $this->data['order_details'] = $check;
        $this->data['view_data'] = $this->CommanModel->get_by('users_order_item',array('order_id'=>$id),false,false,false);

        $this->data['order_user_details'] = $this->CommanModel->get_by('users',array('id'=>$check->user_id),false,false,true);

        $this->data['subview'] = $this->_subView.'view_admin';
        echo view('admin/_layout_main',$this->data);
    }

    function getStatus($id=false,$type=false){
        if(!$id){
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }
        if(!$type){
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }
        $checkItem =$this->CommanModel->get_by('user_order_items',array('ownner_id'=>0,'id'=>$id,'is_done'=>0),false,false,true);
        if(!$checkItem){
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }

        $checkOrder =$this->CommanModel->get_by('user_orders',array('id'=>$checkItem->order_id,'store_id'=>0,'payment'=>1),false,false,true);
        if(!$checkOrder){
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }
        /*		$productName = '-';
                $product_data = $this->comman_model->get_lang('products',$this->data['lang_id'],NULL,array('id'=>$checkItem->product_id),'product_id',true);
                if($product_data){
                    $productName = $product_data->title.' ('.$product_data->type.')';
                }
                else{
                    $options =unserialize($checkItem->order_content);
                    $productName = $options['productName'].' ('.$options['product_type'].')';
                }*/

        $db = \Config\Database::connect();
        $builder = $db->table('user_order_items');
        $builder->where('id', $id);
        if($type=='cancel'){
            $builder->set('is_done', 2, TRUE);
        }
        else{
            $builder->set('is_done', 1, TRUE);
        }
        $builder->update();
        $user_data =$this->CommanModel->get_by('user_order_shipping_add',array('id'=>$checkOrder->id),false,false,true);
        return redirect()->to(base_url().'/'.$this->data['_view'].'/'.$checkOrder->id);
    }

    function review($id=false){
        //var_dump($this->session->all_userdata());
        $this->data['name'] = 'Review';
        $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];
        if($this->data['user_details']->parent_id!=0){
            $check  = $this->CommanModel->get_by('user_orders',array('id'=>$id,'store_id'=>$this->data['user_details']->parent_id),false,false,true);
        }
        else{
            $check  = $this->CommanModel->get_by('user_orders',array('id'=>$id,'store_id'=>$this->data['user_details']->id),false,false,true);
        }
        if(empty($check)){
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }

        $this->data['user_data'] = $this->CommanModel->get_by('user_order_shipping_add',array('order_id'=>$id),false,false,true);

        $this->data['employee_data'] = $this->CommanModel->get_by('users',array('account_type'=>'E','parent_id'=>$this->data['user_details']->id),false,false,false);

        $this->data['order_details']  =$check;
        $this->data['order_history_data'] = $this->CommanModel->get_by('user_order_history',array('order_id'=>$id),false,false,false);
        $this->data['view_data'] = $this->CommanModel->get_by('user_order_items',array('order_id'=>$id),false,false,false);

        //$this->load->view('user/orders',$this->data);
        $this->data['subview'] = $this->_subView.'review';
        echo view($this->_mainView,$this->data);
    }
    function delete($id = false){
        if(!$id){
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }
        $this->CommanModel->delete_by_id($this->_table_names,array('id'=>$id));
        $this->data['session']->setFlashdata('success','Data successfully deleted');
        return redirect()->to(base_url().'/'.$this->data['_cancel']);
    }

    function setXml(){
        // Gets all the data using MY_Model.php
        $data = $this->CommanModel->get_by('user_orders',array('payment'=>1,'store_id'=>0),false,false,false);

        $orderData = array();
        $orderData[] = array(
            'Order Number'=>'Order Number',
            'Username'=>'Username',
            'Email'=>'Email',
            'City'=>'City',
            'Phone'=>'Phone',
            'Amount'=>'Amount',
            'Order On'=>'Order On',
            'Payment Type'=>'Payment Type',
        );

        if($data){
            foreach($data as $set_data){
                $users = $this->CommanModel->get_by('user_order_shipping_add',array('order_id'=>$set_data->id),false,false,true);
                if($users){
                    $price = $set_data->total;
                    $orderData[] = array(
                        'Order Number'=>$set_data->order_number,
                        'Username'=>$users->first_name.' '.$users->last_name,
                        'Email'=>$users->email,
                        'City'=>$users->city,
                        'Phone'=>$users->phone,
                        'Amount'=>$price,
                        'Order On'=>date('d-m-Y',$set_data->created),
                        'Payment Type'=>$set_data->payment_type,
                    );

                }
            }
        }
        /*		echo '<pre>';
                print_r($orderData);
                die;*/

        if($orderData){
            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"orders-".time()."".".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');

            foreach ($orderData as $set_data) {
                fputcsv($handle, $set_data);
            }
            fclose($handle);
        }
        else{
            return false;
        }
    }

    function setXmlSeller(){
        // Gets all the data using MY_Model.php
        $data = $this->CommanModel->get_by('user_orders',array('payment'=>1,'store_id !='=>0),false,false,false);

        $orderData = array();
        $orderData[] = array(
            'Order Number'	=> 'Order Number',
            'Seller'		=> 'Seller',
            'Username'		=> 'Username',
            'Email'			=> 'Email',
            'City'			=> 'City',
            'Phone'			=> 'Phone',
            'Amount'		=> 'Amount',
            'Order On'		=> 'Order On',
            'Payment Type'	=> 'Payment Type',
        );

        if($data){
            foreach($data as $set_data){
                $users = $this->CommanModel->get_by('user_order_shipping_add',array('order_id'=>$set_data->id),false,false,true);
                if($users){
                    $price = $set_data->total;
                    $orderData[] = array(
                        'Order Number'=>$set_data->order_number,
                        'Seller'=>print_value('users',array('id'=>$set_data->store_id),'username'),
                        'Username'=>$users->first_name.' '.$users->last_name,
                        'Email'=>$users->email,
                        'City'=>$users->city,
                        'Phone'=>$users->phone,
                        'Amount'=>$price,
                        'Order On'=>date('d-m-Y',$set_data->created),
                        'Payment Type'=>$set_data->payment_type,
                    );
                }
            }
        }
        /*		echo '<pre>';
                print_r($orderData);
                die;*/

        if($orderData){
            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"orders-".time()."".".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');

            foreach ($orderData as $set_data) {
                fputcsv($handle, $set_data);
            }
            fclose($handle);
        }
        else{
            return false;
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }
    }



    function setXmlBackExcel(){
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        // Gets all the data using MY_Model.php
        $data = $this->CommanModel->get_by('user_orders',array('payment'=>1,'store_id'=>0),false,false,false);
        if($data){
            foreach($data as $set_data){
                $users = $this->CommanModel->get_by('user_order_shipping_add',array('order_id'=>$set_data->id),false,false,true);
                if($users){
                    $price = $set_data->total;
                    $orderData[] = array(
                        'Order Number'=>$set_data->order_number,
                        'Username'=>$users->first_name.' '.$users->last_name,
                        'Email'=>$users->email,
                        'City'=>$users->city,
                        'Phone'=>$users->phone,
                        'Amount'=>$price,
                        'Order On'=>date('d-m-Y',$set_data->created),
                        'Amount'=>$price,
                        'Payment Yype'=>$set_data->payment_type,
                    );
                }
            }
        }
        /*		echo '<pre>';
                print_r($orderData);
                die;*/

        if($orderData){
            $this->excel->stream('orders'.time().'.xls', $orderData);
        }
        else{
            return false;
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }
    }


    public function exportsData(){
        $data[] = array('x'=> $x, 'y'=> $y, 'z'=> $z, 'a'=> $a);
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"test".".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $handle = fopen('php://output', 'w');

        foreach ($data as $data) {
            fputcsv($handle, $data);
        }
        fclose($handle);
        exit;
    }

    function checkPremission($type=false){
        $redirect = false;

        if($this->data['adminDetails']->default=='0'){
            if($type=='is_order'){
                if($this->data['adminDetails']->is_order==1){}
                else{
                    $redirect = true;
                }
            }
            else if($type =='is_payment'){
                if($this->data['adminDetails']->is_payment==1){}
                else{
                    $redirect = true;
                }
            }
        }
        if($redirect){
            $this->data['session']->setFlashdata('error','Sorry ! You have no permission.');
            return redirect()->to(base_url().'/'.$this->data['admin_link'].'/dashboard');
        }
    }
}

/* End of file OrderManage.php */
/* Location: ./application/controllers/admin123/OrderMange.php */
