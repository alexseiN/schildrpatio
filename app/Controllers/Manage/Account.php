<?php

namespace App\Controllers\Manage; 

use App\Core\Admincontroller;


class Account extends Admincontroller{  
    
    public function __construct(){
        parent::__construct();
        $this->data['active']= 'General Settings';
        
    }

    public function index(){
        $this->data['subview'] = 'admin/dashboard/index';
        echo view('admin/_layout_main',$this->data);
    }

    
    
    public function login(){
        $this->data['title'] = 'Admin Login';
        $dashboard = $this->data['admin_link'].'/dashboard';
        // check admin logged or not
        if($this->AccountModel->loggedin())
            return redirect()->to($dashboard);

        $rules = $this->AccountModel->rules;
        $input = $this->validate($rules);
       
        if($this->postdata){
            if($input){
                $postdata = $this->postdata;
                $user = $this->CommanModel->get_by('admin',array(
                    'username'=>$postdata['username'],
                    'password'=>md5($postdata['password']),
                ),false,false, TRUE);
                if($user){
                    
                    $data = array(
                            'username'=>$user->username,
                            'email'=>(isset($user->email)?$user->email:''),
                            'id'=>$user->id,
                            'logged_type'=>'admin',
                            'loggedin'=>TRUE
                        );
                    
                        $this->data['session']->set('adminSession',$data);
                        
                        
                        $insertactivity['d_action'] = '<b>'.$user->username.'</b> logged in.';	
                        $insertactivity['employee'] = $user->employee_id;
                        $insertactivity['created']  = date("Y-m-d H:i:s");
                        activitylogs($insertactivity,'insert');
                        
                        
                        
                        return redirect()->to($dashboard);
                } else {
                    
                    $insertactivity['d_action'] = '<b>'.$postdata['username'].'</b> could not login. Wrong Credentials';	
                    $insertactivity['employee'] = 0;
                    $insertactivity['created']  = date("Y-m-d H:i:s");
                    activitylogs($insertactivity,'insert');
                    
                    
                    $this->data['session']->setFlashdata('error','Invalid username or password.');
                    return redirect()->to($this->data['admin_link'].'/account/login');
                }
            }
            $this->data['validationerrors'] = $this->data['validation']->listErrors('list');
        }

        $this->data['subview'] = 'admin/user/login';
        return view('admin/_layout_main',$this->data);
    }


    public function checkOldPassword($password){//check admin old pass is match from change password form
        $login = $this->data['session']->get();
        $check = $this->CommanModel->get_by('admin',array('id'=>$login['adminSession']['id'],'password'=>md5($password)),false,false,true);
        if(!count((array)$check)){
            $this->data['session']->setFlashdata('error','Old Password is wrong password');
            return FALSE;
        }
        return TRUE;
    }

    public function changePassword(){
        $this->data['name'] = 'Change Password';
        $this->data['title'] = $this->data['name'];
        $this->data['active']= '';
        $this->data['_table_names']= '';
        
        $this->data['_cancel']= $this->data['admin_link'].'/dashboard';
        
        $login = $this->data['session']->get();
        if(!empty($this->postdata)) {
            $postdata = $this->postdata;
            $rules = $this->AccountModel->rules_password;
            $input = $this->validate($rules, array('matches' => 'Password does not match'));
            if($input) {
                $oldPassword = $postdata['old_password'];
                $newPassword = $postdata['password'];
                if(!$this->checkOldPassword($oldPassword)) {
                    $this->data['session']->setFlashdata('error', 'Old Password is wrong password');
                } else {
                    //update password
                    $this->CommanModel->saveData('admin',array('password'=>md5($newPassword)),$login['adminSession']['id']);
                    $this->data['session']->setFlashdata('success', 'Your Password has successfully been Updated');
                }

                return redirect()->to($this->data['admin_link'].'/account/changePassword');
            }
        }
        $this->data['edit_data'] = $this->CommanModel->get_by('admin',array('id'=>$login['adminSession']['id']),FALSE,FALSE,TRUE);

        $this->data['subview'] = 'admin/dashboard/password';
        echo view('admin/_layout_main',$this->data);
    }

    public function logout(){
        $this->data['session']->destroy();
        return redirect()->to($this->data['admin_link'].'/account/login');
    }
}