<?php  

namespace App\Controllers;
use App\Core\Maincontroller;

class Demoinvoice extends Maincontroller
{
    public $_subView = 'main/invoice/'; 
	public function __construct(){
	    parent::__construct();
		helper('cookie');
		
		$this->data['socials'] = $this->CommanModel->get_by('socials', array(), FALSE, array('order'=>'order'), FALSE);
		
	}


	public function wpdemo($link=NULL) 
	{
	    $data = $this->data;
		
		

		$data['main'] =  $this->CommanModel->get_by('l_settings', array(), FALSE, FALSE, TRUE);
		
		$data['setproject'] =  $this->CommanModel->get_by('setproject', array('link'=>$link), FALSE, FALSE, TRUE);
		
		$data['subprojects'] =  $this->CommanModel->get_by('setproject', array('parent_id'=>$data['setproject']->id), FALSE, FALSE, FALSE);
		
		$data['selprods'] = $this->CommanModel->get_by('selproducts', array('category_id'=>$data['setproject']->id), FALSE, FALSE, FALSE);
		

        echo view($this->_subView.'wpdemo',$data);
	}
	
	
}
