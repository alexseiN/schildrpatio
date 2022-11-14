<?php  

namespace App\Controllers;
use App\Core\Maincontroller;


class Invoice extends Maincontroller
{
    public $_subView = 'main/invoice/'; 
	public function __construct(){
	    parent::__construct();
		helper('cookie');
		
		$this->data['socials'] = $this->CommanModel->get_by('socials', array(), FALSE, array('order'=>'order'), FALSE);
		
	}

	public function index($link=NULL)
	{
	    $data = $this->data;
		
		

		$data['main'] =  $this->CommanModel->get_by('l_settings', array(), FALSE, FALSE, TRUE);
		
		$data['setproject'] =  $this->CommanModel->get_by('setproject', array('link'=>$link), FALSE, FALSE, TRUE);
		
	//	echo '<pre>';print_r($data['setproject']);
		
		$data['subprojects'] =  $this->CommanModel->get_by('setproject', array('parent_id'=>$data['setproject']->id), FALSE, FALSE, FALSE);
		
	//	echo '<pre>';print_r($data['subprojects']);
		
		$data['selprods'] = $this->CommanModel->get_by('selproducts', array('category_id'=>$data['setproject']->id), FALSE, FALSE, FALSE);
		
	//	echo '<pre>';print_r($data);

        echo view($this->_subView.'index',$data);
	}
	public function createpdf($link=NULL){

	    create_PDF();
	}
	
	public function wp($link=NULL) 
	{
	    $data = $this->data;
		
		

		$data['main'] =  $this->CommanModel->get_by('l_settings', array(), FALSE, FALSE, TRUE);
		
		$data['setproject'] =  $this->CommanModel->get_by('setproject', array('link'=>$link), FALSE, FALSE, TRUE);
		
		$data['subprojects'] =  $this->CommanModel->get_by('setproject', array('parent_id'=>$data['setproject']->id), FALSE, FALSE, FALSE);
		
		$data['selprods'] = $this->CommanModel->get_by('selproducts', array('category_id'=>$data['setproject']->id), FALSE, FALSE, FALSE);
		


        echo view($this->_subView.'wp',$data);
	}
	
	public function auto($link=NULL) {
	    
	    $data['main'] =  $this->CommanModel->get_by('l_settings', array(), FALSE, FALSE, TRUE);
	    
	    $data['request'] =  $this->CommanModel->get_by('storedata', array('link'=>$link), FALSE, FALSE, TRUE);
	    $data['elements'] =  $this->CommanModel->get_lang('locproducts', $this->data['curlangid'] , NULL, array('enabled'=>1), 'connlang_id', false);
	    
	   // echo '<pre>';print_r($data['elements']);die();
	    
	    echo view($this->_subView.'auto',$data);
	    
	}
	
	public function details($link=NULL) {
	    
	    $data['main'] =  $this->CommanModel->get_by('l_settings', array(), FALSE, FALSE, TRUE);
	    
	    $data['request'] =  $this->CommanModel->get_by('storedata', array('link'=>$link), FALSE, FALSE, TRUE);
	    $data['elements'] =  $this->CommanModel->get_lang('locproducts', $this->data['curlangid'] , NULL, array('enabled'=>1), 'connlang_id', false);
	    
	   // echo '<pre>';print_r($data['elements']);die();
	   
	   $data['datax'] = $this->CommanModel->calculation($data['request']->depth,$data['request']->width,$data['request']->height1,$data['request']->height2,$data['request']->number_of_columns);
	    
	    echo view($this->_subView.'details',$data);
	    
	}
	
	
}
