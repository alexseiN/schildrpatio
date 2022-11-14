<?php
namespace App\Controllers\Manage;    

use App\Core\Admincontroller;
use App\Models\backend\Mixedmodel;

class Mixed extends Admincontroller {
    public $_table_names = 'features';			//set table name
    public $_subView = 'admin/mixed/';		//set subview
    public $_redirect = '/mixed';				//set controller link
    

    protected $MixedModel;

    public function __construct(){
        parent::__construct();

        $this->MixedModel = new Mixedmodel();

        $this->data['ThisModule'] = $this->MixedModel;
        $this->data['CommanModel'] = $this->CommanModel;

        //set left menu active on admin dashboard
        $this->data['active'] = 'Important';
        
        //set link with function name
        $this->data['_edit'] = $this->data['branch_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['branch_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['branch_link'].$this->_redirect.'/delete';


    }

    public function index()
    {
        $this->data['name'] = 'Product files';
        $this->data['title'] = $this->data['name'];
        $this->data['features'] = $this->CommanModel->get_bycat('features', $this->data['admin_lang'], NULL, array('template'=>'mixed'), 'connlang_id', false);
        $this->data['subview'] = $this->_subView.'index_order';
        echo view('admin/_layout_main',$this->data);
    }

    


    
  
}
