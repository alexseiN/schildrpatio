<?php

namespace App\Controllers\Admin123;
use App\Core\Admincontroller;
use App\Models\backend\Attributesmodel;
use App\Models\backend\Pagesmodel;

class Attributes extends Admincontroller
{
    public $_table_names 	= 'attributes';		//set table
    public $_subView = 'admin/attributes/';			//set subview
    public $_mainView = 'admin/_layout_main';		//set mainview
    public $_redirect = '/attributes';				//set controller link

    protected $AttributesModel;
    protected $PagesModel;

    public function __construct(){
        parent::__construct();
        //set left menu active on admin dashboard
        $this->data['active'] = 'Product Management';

        $this->AttributesModel = new Attributesmodel();
        $this->PagesModel = new Pagesmodel();

        $this->data['AttributesModel'] = $this->AttributesModel;

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
        $this->data['name'] = 'Attributes';
        $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];


        $this->data['subview'] = $this->_subView.'index_order';
        echo view('admin/_layout_main',$this->data);
    }


    //set active inactive
    function getSetData(){
        $msge = array();
        $msge['status']= 'error';

        $request = \Config\Services::request();

        $id = $request->getPost('id');
        $check_data = $this->CommanModel->get_by($this->_table_names,array('id'=>$id),false,false,true);
        if($check_data){
            if($check_data->filter==1){
                $post_data = array('filter'=>0);
            }
            elseif($check_data->filter==0){
                $post_data = array('filter'=>1);
            }
            else{
                $post_data = array('filter'=>1);
            }
            $msge['status']= 'ok';
            $result = $this->CommanModel->saveData($this->_table_names,$post_data,$id);
        }
        echo json_encode($msge);
    }

    public function order_ajax($id=false){
        // Save order from ajax call
        if (isset($_POST['sortable'])) {
            $this->AttributesModel->saveOrder($_POST['sortable']);
        }

        // Fetch all pages
        $this->data['pages'] = $this->AttributesModel->getNested($this->data['admin_lang'],false,array('category_id'=>$id));

        // Load view
        echo view($this->_subView.'order_ajax', $this->data);
    }

    public function edit($c_id=false,$id = NULL){
        if(!$c_id){
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }
        $this->data['_cancel'] = $this->data['_cancel'].'/l/'.$c_id; 
        $this->data['c_id'] = $id;
        // Fetch a data or set a new one
        if($id){
            // set title
            $this->data['name'] = 'Create';
            $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];

            $this->data['form_data'] = $this->AttributesModel->getLang($id, FALSE, $this->data['content_language_id']);
            if(!$this->data['form_data']){
                return redirect()->to(base_url().'/'.$this->data['_cancel']);
            }
        }
        else
        {
            // set title
            $this->data['name'] = 'Edit';
            $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];

            // set a new one
            $this->data['form_data'] = $this->AttributesModel->getNew();
        }

        $this->data['validation'] = \Config\Services::validation();

        $input = $this->validate($this->AttributesModel->getAllRules(), array('required' => '%s field required'));

        // Process the form
        if($_POST)
        {
            if($input) {
                $data =array();

                //get post data from form
                $data = $this->AttributesModel->arrayFromPost(array('section'));

                $data['parent_id'] = 0;

                $data['category_id'] = $c_id;
//            if($id == NULL)$data['order'] = $this->attributes_model->max_order()+1;
                $data_lang = $this->AttributesModel->arrayFromPost($this->AttributesModel->getLangPostFields());
                if($id == NULL){
                    $data['on_date'] = date('Y-m-d H:i:s');
                    $data['created'] = time();
                    $data['modified'] = time();
                    $data['section'] = 0;
                }
                else{
                    $data['modified'] = time();
                }

                //create or update data
                $id = $this->AttributesModel->saveWithLang($data, $data_lang, $id);
                if(empty($this->data['form_data']->id))
                    $this->data['session']->setFlashdata('success','Data succesfully created');
                else
                    $this->data['session']->setFlashdata('success','Data succesfully updated');

                return redirect()->to(base_url().'/'.$this->data['_cancel']);
            }
        }

        //set load view
        $this->data['subview'] = $this->_subView.'edit';
        echo view('admin/_layout_main', $this->data);
    }

    //delete data
    public function delete($c_id=false,$id=false){
        if(!$c_id){
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }
        $this->data['_cancel'] = $this->data['_cancel'].'/l/'.$c_id;
        if($this->data['adminDetails']->default=='0'){
            $this->data['session']->setFlashdata('error','Sorry ! You have no permission.');
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }

        $this->AttributesModel->deleteData($id);
        return redirect()->to(base_url().'/'.$this->data['_cancel']);
    }

}
