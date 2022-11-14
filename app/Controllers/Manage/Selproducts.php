<?php

namespace App\Controllers\Admin123;  
use App\Core\Admincontroller;
use App\Models\backend\Selproductsmodel;

class Selproducts extends Admincontroller {
    public $_table_names 	= 'selproducts';		//set table
    public $_subView        = 'admin/selproducts/';			//set subview
    public $_mainView       = 'admin/_layout_main';		//set mainview
    public $_redirect       = '/selproducts';				//set controller link

    protected $SelproductsModel;

    public function __construct(){
        parent::__construct();
        //set left menu active on admin dashboard
        $this->data['active'] = 'Project management';

        $this->SelproductsModel = new Selproductsmodel();
        $this->data['ThisModule'] = $this->SelproductsModel;

        //set link with function name 
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';

        $this->data['_m_cancel'] = $this->data['admin_link'].'/pdcats';

    }

    public function l($id=false){
        if(!$id){
            return redirect()->to(base_url().'/'.$this->data['_m_cancel']);
        }
        $this->data['c_id'] = $id;

        $this->data['name'] = 'Add products for calculation';
        $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];

        $this->data['subview'] = $this->_subView.'index_order';
        echo view('admin/_layout_main',$this->data);
    }

    public function orderAjax($id=false){
        // Save order from ajax call
        if (isset($_POST['sortable'])) {
            $this->data['ThisModule']->saveOrder($_POST['sortable']);
        }

        // Fetch all pages
        $this->data['thisItems'] = $this->data['ThisModule']->getNested($this->data['admin_lang'],true,array('category_id'=>$id));

        // Load view
        echo view($this->_subView.'order_ajax', $this->data);
    }

    public function edit($c_id=false,$id = NULL){
        if(!$c_id){
            return redirect()->to(base_url().'/'.$this->data['_m_cancel']);
        }
        $this->data['_cancel'] = $this->data['_cancel'].'/l/'.$c_id;
        $this->data['c_id'] = $id;
        // Fetch a data or set a new one
        if($id){
            // set title
            $this->data['name'] = 'Create';
            $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];

            $this->data['thisItems'] = $this->data['ThisModule']->get($id, FALSE);
            if(!$this->data['thisItems']){
                return redirect()->to(base_url().'/'.$this->data['_cancel']);
            }
        }
        else
        {
            // set title
            $this->data['name'] = 'Edit';
            $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];

            // set a new one
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
        }

        $this->data['validation'] = \Config\Services::validation();

        $input = $this->validate($this->data['ThisModule']->getAllRules(), array('required', '%s Field required'));
        
        
        
        $this->data['all_products'] = $this->CommanModel->get_lang('product',$lang_id=8,false,array(),'connlang_id',FALSE);

        // Process the form
        if($_POST)
        {
            if($input) {
                $data =array();

                //get post data from form
                $data = $this->data['ThisModule']->arrayFromPost(array('parent_id','dimensions','sproduct','qty','scolor','fcolor','motorauto','description','uprice','additional'));
                $data['parent_id'] = 0;
                $data['category_id'] = $c_id;

                $data_lang = $this->data['ThisModule']->arrayFromPost($this->data['ThisModule']->getLangPostFields());
                if($id == NULL){
                    $data['on_date'] = date('Y-m-d H:i:s');
                    $data['created'] = time();
                    $data['modified'] = time();
                }
                else{
                    $data['modified'] = time();
                }

                //create or update data
             //   $id = $this->data['ThisModule']->saveWithLang($data, $data_lang, $id);
                $id = $this->data['ThisModule']->saveData($data, $id);
                if(empty($this->data['thisItems']->id))
                    $this->data['session']->setFlashdata('success','Data has successfully created');
                else
                    $this->data['session']->setFlashdata('success','Data has successfully updated');

                return redirect()->to(base_url().'/'.$this->data['_cancel']);
            }
        }

        //set load view
        $this->data['subview'] = $this->_subView.'edit';
        echo view('admin/_layout_main', $this->data);
    }

    //delete data
    public function delete($c_id=false, $id=false){
        if(!$c_id){
            return redirect()->to(base_url().'/'.$this->data['_m_cancel']);
        }
        $this->data['_cancel'] = $this->data['_cancel'].'/l/'.$c_id;
        if($this->data['adminDetails']->default=='0'){
            $this->data['session']->setFlashdata('error','Sorry ! You have no permission.');
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }

        $invoiceId = $this->CommanModel->get_by('selproducts', array('sproduct' => $c_id, 'id' => $id), FALSE, FALSE, true)->category_id;
         $in = $this->CommanModel->get_by('setproject', array('id' => $invoiceId), FALSE, FALSE, true)->parent_id;
         if(!empty($in))
         {
            $invoiceId = $in;     
         }
        $this->data['ThisModule']->deleteData($id);
        return redirect()->to(base_url().'/admin123/invoice/index/'.$invoiceId);
    }

}
