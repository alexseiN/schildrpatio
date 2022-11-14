<?php

namespace App\Controllers\Admin123;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('post_max_size', '500M');
ini_set('upload_max_filesize', '500M');

ini_set( 'memory_limit', '200M' );
ini_set('max_input_time', 3600);
ini_set('max_execution_time', 3600);

use App\Core\Admincontroller;

class User extends Admincontroller {
    public $_table_names = 'users';			//set table
    public $_subView = 'admin/user/';		//set subview
    public $_redirect = '/user';			//set link

    public function __construct(){
        parent::__construct();

        $this->data['active'] = 'User Management';
        $this->data['_add'] = $this->data['admin_link'].$this->_redirect.'/create';
        $this->data['_edit'] = $this->data['admin_link'].$this->_redirect.'/edit';
        $this->data['_cancel'] = $this->data['admin_link'].$this->_redirect;
        $this->data['_delete'] = $this->data['admin_link'].$this->_redirect.'/delete';

    }


    //  Landing page of admin section.
    function index(){
        $this->data['name'] = 'User';
        $this->data['title'] = $this->data['name'].' | '.$this->data['settings']['site_name'];
        $this->data['table'] = true;

        //fetch data
        if($this->data['adminDetails']->default=='0'){
            $this->data['all_data'] = $this->CommanModel->get_by($this->_table_names,array('account_type'=>"U",'admin_id'=>$this->data['adminDetails']->id),false,array('id'=>'desc'),false);
        }
        else{
            $this->data['all_data'] = $this->CommanModel->get_by($this->_table_names,array('account_type'=>"U"),false,array('id'=>'desc'),false);
        }

        $this->data['subview'] = $this->_subView.'index';
        echo view('admin/_layout_main',$this->data);
    }


    function setUser($id){//set confirm
        if($id)
            $this->CommanModel->saveData($this->_table_names,array('confirm'=>'confirm'),$id);
        return redirect($this->data['_cancel']);
    }


    function sendMail($id =false){
        if(!$id){
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }


        $checkUser = $this->CommanModel->get_by('users',array('id'=>$id),false,false,true);
        if(!$checkUser){
            $this->data['session']->setFlashdata('error','There is no user!!');
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }

        $email_data = $this->CommanModel->get_by('email',array('id'=>3),false,false,true);

        $email_data->subject = str_replace('{site_name}', $this->data['settings']['site_name'], $email_data->subject);
        $email_data->subject = str_replace('{site_email}', $this->data['settings']['site_name'], $email_data->subject);

        $email_data->message = str_replace('{user_name}', $checkUser->first_name.' '.$checkUser->last_name, $email_data->message);
        $email_data->message = str_replace('{user_email}', $checkUser->email, $email_data->message);
        $email_data->message = str_replace('{password}', $checkUser->password, $email_data->message);
        $email_data->message = str_replace('{site_name}', $this->data['settings']['site_name'], $email_data->message);
        $email_data->message = str_replace('{site_email}', $this->data['settings']['site_email'], $email_data->message);
        $email_data->message = str_replace('{login_link}', base_url(), $email_data->message);
        //$email_data-> = str_replace('{site_email}', $this->data['site_name']->value, $email_data->);
        //echo $checkUser->email.' '.$this->data['settings']['site_email'];die;
        //echo $email_data->message;die;

        $email = \Config\Services::email();
        $email->setTo($checkUser->email);
        $email->setFrom($this->data['settings']['site_email'], $this->data['settings']['site_name']);

        $email->setSubject($email_data->subject);
        $email->setMessage($email_data->message);

        if($email->send()){
            $this->data['session']->setFlashdata('success','mail has successfully sent!!');
        }
        else{
            $this->data['session']->setFlashdata('error','There is some problem to sent mail!!');
        }

        return redirect()->to(base_url().'/'.$this->data['_cancel']);
    }

    function getStatus(){
        $request = \Config\Services::request();
        $id = $request->getPost('id');
        $post_data = array('status'=>$request->getPost('status'));
        $result = $this->CommanModel->saveData($this->_table_names,$post_data,$id);
    }


    function delete($id = false){
        if($this->data['adminDetails']->default=='0'){
            $this->data['session']->setFlashdata('error','Sorry ! You have no permission.');
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }
        if(!$id){
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }

        $db = \Config\Database::connect();
        $db->table('users_review')->delete(array('sender_id'=>$id));
        $db->table($this->_table_names)->delete(array('id'=>$id));
        $this->data['session']->setFlashdata('success','Data succesfully deleted');

        return redirect()->to(base_url().'/'.$this->data['_cancel']);
    }

    //delete exam
    function deleteExam($id = false,$exam_id){
        if($this->data['adminDetails']->default=='0'){
            $this->data['session']->setFlashdata('error','Sorry ! You have no permission.');
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }
        if(!$id){
            return redirect()->to(base_url().'/'.$this->data['_cancel']);
        }

        //check exam
        $checkUser = $this->CommanModel->get_by('exams_attempt',array('id'=>$exam_id),false,false,true);
        if($checkUser){
            $db = \Config\Database::connect();
            $db->table('exams_attempt')->delete(array('id'=>$exam_id));
            $db->table('exams_attempt_answer')->delete(array('attempt_id'=>$exam_id));
            $db->table('exams_review')->delete(array('sender_id'=>$id,'exam_id'=>$checkUser->exam_id));
        }
        return redirect()->to(base_url().'/'.$this->data['_cancel'].'/edit/'.$id);
    }

    public function removeImage($id=false){//for remove image
        $path = 'assets/uploads/users/';
        if(!$id)
            return redirect()->to(base_url().'/'.$this->data['_cancel']);

        $check = $this->CommanModel->get_by($this->_table_names,array('id'=>$id),false,false,true);
        if(!$check)
            return redirect()->to(base_url().'/'.$this->data['_cancel']);

        $db = \Config\Database::connect();
        $builder = $db->table($this->_table_names);
        $builder->where(array('id'=>$id));
        $builder->set('image', 'NULL', false);
        $builder->update();

        $file_dir = $path.'full/'.$check->image;
        if(is_file($file_dir)){
            unlink($file_dir);
        }
        $file_dir = $path.'small/'.$check->image;
        if(is_file($file_dir)){
            unlink($file_dir);
        }
        $file_dir = $path.'thumbnails/'.$check->image;
        if(is_file($file_dir)){
            unlink($file_dir);
        }
        return redirect()->to(base_url().'/'.$this->data['_cancel'].'/edit/'.$id);
    }



}

/* End of file User.php */
/* Location: ./application/controllers/Admin123/User.php */
