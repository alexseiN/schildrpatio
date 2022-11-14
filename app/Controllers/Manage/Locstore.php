<?php

namespace App\Controllers\Manage;

use App\Core\Admincontroller;
use App\Models\backend\Mixedmodel;

class Locstore extends Admincontroller {
    public $_table_names = 'locproducts';			//set table name
    public $_subView = 'admin/locstore/';		//set subview
    public $_redirect = '/locstore';				//set controller link   

    protected $MixedModel;
    public function __construct(){
        parent::__construct();
        $this->MixedModel = new Mixedmodel();
        $this->data['ThisModule'] = $this->MixedModel;
        $this->data['CommanModel'] = $this->CommanModel;
        //set left menu active on admin dashboard
        $this->data['active'] = 'Local Store';        
        //set link with function name
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';

        $this->data['_table_names'] = $this->_table_names;
        $this->data['_parent_folder'] = 'Local Store';
    }

    public function index() {
        $this->data['name'] = 'Store';
        $this->data['title'] = $this->data['name'];
        $this->data['subview'] = $this->_subView.'index';
        //pp($this->data['all_categories']);
        echo view('admin/_layout_main',$this->data);
    }
          
    function ajax_list() {
        error_reporting(0);
		$where= array();
		$multi=array();
       
        $filter_color = $this->request->getPost('filter_color');
        $filter_size = $this->request->getPost('filter_size');
        $category = $this->request->getPost('filter_category');
        
		$where['enabled'] = 1;
		    
        $like = array(
            'size'=>$filter_size,
            'colors'=>$filter_color
            );

        if($category) { $multi['category']=$category; } else {unset($multi['category']);}
        
		$this->data['thisItems'] = $this->CommanModel->getDatam2('locproducts',$where,$this->data['admin_lang'],$like,'id',$multi);  
        //$this->data['subview'] = $this->_subView.'index';   
        $html = view($this->_subView.'ajax_list', $this->data);
		return $html;	
	}
}
