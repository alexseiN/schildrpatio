<?php

namespace App\Controllers\Admin123;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use App\Core\Admincontroller;
use App\Models\backend\Chatdbmodel;

class Chatdb extends Admincontroller {
    public $_table_names = 'chatdb';		//set table name
    public $_subView = 'admin/chatdb/';	//set subview
    public $_redirect = '/chatdb';          //set controller link

    protected $SliderModel;
    
    public function __construct(){
        parent::__construct();
        
        $this->ChatdbModel = new Chatdbmodel();
        $this->data['ThisModule'] = $this->ChatdbModel;

        //set active for menu
        $this->data['active'] = 'Content Management';
        
        $this->data['uploadFolder'] = 'assets/uploads/sliders';

        //set function link
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';

    }

    public function index()
    {
        //set title
        $this->data['name'] = 'Predefined answers';
        $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];

        //set load view
        $this->data['subview'] = $this->_subView.'index_order';
        echo view('admin/_layout_main',$this->data);

    }



    public function edit($id = NULL)
    {
        // Fetch a data or set a new one
        if($id)
        {
            //set title
            $this->data['name'] = 'Edit';
            $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];
            $this->data['thisItems'] = $this->data['ThisModule']->getLang($id, FALSE, $this->data['admin_lang']);
            if(!$this->data['thisItems'])
                return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }
        else
        {
            //set title
            $this->data['name'] = 'Create';
            $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];
            //  set a new one
            $this->data['thisItems'] = $this->data['ThisModule']->getNew();
        }

        $this->data['validation'] =  \Config\Services::validation();
        // Set up the form
        $input = $this->validate($this->data['ThisModule']->getAllRules());

        // Process the form
        if($_POST){
            if($input) {
                //get post data
                $data = $this->data['ThisModule']->arrayFromPost(array('link'));
                if($id == NULL)$data['order'] = $this->data['ThisModule']->maxOrder()+1;
                $data_lang = $this->data['ThisModule']->arrayFromPost($this->data['ThisModule']->getLangPostFields());
                
                if($id == NULL){
                    $data['created'] = time();
                    $data['modified'] = time();
                }
                else{
                    $data['modified'] = time();
                }

                //upload main image
                if (!empty($_FILES['logo']['name'])){
                    $result =$this->CommanModel->do_upload('logo','./'.$this->data['uploadFolder']);
                    if($result['status']=='error'){
                        $this->data['session']->setFlashdata('error',$result['message']);
                    }
                    else if($result['status']=='success'){
                        $data['image'] = $result['product_image'];
                    }
                }
                else{
                    if($id != NULL)
                        $data['image'] = $this->data['thisItems']->image;
                }
                
                //insert or update data
                $id = $this->data['ThisModule']->saveWithLang($data, $data_lang, $id);
                if(empty($this->data['thisItems']->id))
                    $this->data['session']->setFlashdata('success','Data has successfully created');
                else
                    $this->data['session']->setFlashdata('success','Data has successfully updated');
                return redirect()->to(base_url().'/'.$this->data['_cancel'].'/edit/'.$id);
            }
        }

        // Load the view
        $this->data['subview'] = $this->_subView.'edit';
        echo view('admin/_layout_main', $this->data);
    }

  
}
