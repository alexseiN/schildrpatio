<?php

namespace App\Controllers\Manage;

use App\Core\Admincontroller;
use App\Models\backend\Settingmodel; 

class Settings extends Admincontroller {
    public $_table_names    = 'l_settings';         //table name
    public $_subView        = 'admin/settings/';    // set subview
    public $_redirect       = '/settings';          //set links
    public $LanguageModel;

    public function __construct(){
        parent::__construct();
        $this->data['active']= 'General Settings';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;

        $this->data['ThisModule'] = new Settingmodel();
        $this->data['uploadFolder'] = 'assets/uploads/sites';
        $this->checkPermissions('general_setting');

        $this->data['_table_names'] = $this->_table_names;
        $this->data['_subView'] = $this->_subView;
        $this->data['_parent_folder'] = 'Base';
        $this->data['images_array'] = array("logo"=>"Logo","favicon"=>"Favicon","watermark"=>"Watermark");
        
        //check for employee permission
        
        $this->data['_lang_table_names'] = $this->data['_table_names'].'_lang';
    }

    function index(){
        $this->data['name'] = 'General Settings'; 
        $this->data['title'] = $this->data['name'];        
        $blank_array = array();
        
        $this->data['thisItems'] = $this->CommanModel->getDatamwithlimit($this->data['_table_names'],$blank_array,$blank_array,$blank_array,'',0,'all',false);
        
        // Process the form
        if(!empty($this->postdata)) {            
            $postdata = $this->postdata;
            $rules = $this->data['ThisModule']->getAllRules();
            $input = $this->validate($rules);
            if($input) {
                $admin_languages = $this->data['ThisModule']->languages;
                $data = $this->data['ThisModule']->arrayFromPost(array('website_active','site_email','name', 'keyname', 'discount'));
                $dataLang = $this->data['ThisModule']->arrayFromPost($this->data['ThisModule']->getLangPostFields());
                $previousdata = $this->data['thisItems'][0];
                $imagesarray = $this->data['images_array'];
                foreach($imagesarray as $key=>$images){
                    if(!empty($_FILES[$key]['name'])){
                        $validated = $this->validate([
                            $key => [
                                'uploaded['.$key.']',
                                'mime_in['.$key.',image/gif,image/jpg,image/png,image/jpeg,image/bmp,image/GIF,image/JPG,image/JPEG,image/BMP]',
                                'max_size['.$key.',60000]',
                                'max_dims['.$key.',5000,5000]',
                            ],
                        ]);
                        if ($validated) {
                            $avatar = $this->request->getFile($key);
                            $avatar->move($this->data['uploadFolder'].'/');
                            $data[$key] = $avatar->getName();
                        } else {
                            $this->data['session']->setFlashdata('error', 'Invalid '.$key.' file for upload!');
                        }
                    }
                    else{
                        $checkname_remove = $postdata[$key."_remove"];
                        if($checkname_remove == 1){
                            $data[$key]  = null;
                        }
                        else {
                            $data[$key]  = $previousdata->{$key};
                        }
                    }
                }               
                $id = $this->data['ThisModule']->saveWithLang($data, $dataLang, 1);
                
                $logged_in = $this->data['adminDetails'];
                $employeeid = $logged_in->employee_id;
                $insertactivity['employee'] = $employeeid;
                $insertactivity['d_action'] = 'Main settings saved.';
                $insertactivity['created']  = date("Y-m-d H:i:s");
                activitylogs($insertactivity,'insert');
                
                $this->data['session']->setFlashdata('success','Data has successfully updated');
            }
            return redirect()->to($this->data['_cancel']);
        }        
        $this->data['subview'] = $this->_subView.'edit';
        echo view('admin/_layout_main', $this->data);
    }

    function checkPermissions($type= false,$is_redirect=false){
        $redirect = 0;
        if(isset($this->data['adminDetails']->default)){
            $redirect = checkPermission('admin_permission',array('user_id'=>$this->data['adminDetails']->id,'type'=>$type,'value'=>1));
        }
        else {
             $redirect = 1;
        }
        if($redirect==0){
            $this->data['session']->setFlashdata('error','Sorry ! You have no permission.');
            if($redirect){
                return redirect()->to($redirect);
            }
            return redirect()->to($this->data['admin_link']);
        }
    }
}