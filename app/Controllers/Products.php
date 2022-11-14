<?php  

namespace App\Controllers;
use App\Core\Maincontroller;  

class Products extends Maincontroller
{
    public $_subView = 'main/products/';
	public function __construct(){
	    parent::__construct();
		helper('cookie');
		
	    
		
	}

	public function index($slug)
	{
	    $data = $this->data;

		$data['itemcat'] =  $this->CommanModel->get_lang('pdcats', $this->data['curlangid'] , NULL, array('slug'=>$slug,'enabled'=>1), 'connlang_id', true); 
		
		$data['ogtitle'] = $data['itemcat']->title;
		$data['ogdesc'] = str_replace('"', '', $data['itemcat']->about);
		$data['keywords'] = $data['itemcat']->meta_keyword;
		$data['ogimage'] = 'assets/uploads/pdcats/thumbnails/'.$data['itemcat']->image;
		
		
		
		if ($data['itemcat']->parent_id == 0) {
		
		 
		    echo view($this->_subView.'index',$data);
		
		} else {
		    
		    
		    $data['parent'] =  $this->CommanModel->get_lang('pdcats', $this->data['curlangid'] , NULL, array('id'=>$data['itemcat']->parent_id,'enabled'=>1), 'connlang_id', true);
		    
		    $thispro=array();
		    
		    
		   
		    $data['related_prducts'] =  $this->CommanModel->get_lang('pdcats', $this->data['curlangid'] , NULL, array('parent_id<>'=>0,'enabled'=>1), 'connlang_id', false);
		   
		    
		    
		    $data['features'] =  $this->CommanModel->get_lang('features', $this->data['curlangid'] , NULL, array('category_id'=>$data['itemcat']->id,'enabled'=>1), 'connlang_id', false);
		   
		  
		
            echo view($this->_subView.'sub',$data);
        
		}
	}
	
	public function all() {
	    
	    $data = $this->data;
	    
	    echo view($this->_subView.'all',$data);
	} 
	
	public function details($slug)
	{
	    $data = $this->data;

		$data['itemcat'] =  $this->CommanModel->get_lang('pdcats', $this->data['curlangid'] , NULL, array('slug'=>$slug,'enabled'=>1), 'connlang_id', true); 
		
		$data['ogtitle'] = $data['itemcat']->title;
		$data['ogdesc'] = str_replace('"', '', $data['itemcat']->about);
		$data['keywords'] = $data['itemcat']->meta_keyword;
		$data['ogimage'] = 'assets/uploads/pdcats/thumbnails/'.$data['itemcat']->image;
		
		
		
		if ($data['itemcat']->parent_id == 0) {
		
		 
		    echo view($this->_subView.'index',$data);
		
		} else {
		    
		    
		    $data['parent'] =  $this->CommanModel->get_lang('pdcats', $this->data['curlangid'] , NULL, array('id'=>$data['itemcat']->parent_id,'enabled'=>1), 'connlang_id', true);
		    
		    $thispro=array();
		    
		    
		    //$data['products'] =  $this->CommanModel->get_lang('product', $this->data['curlangid'] , NULL, array('category'=>$data['itemcat']->id,'enabled'=>1), 'connlang_id', false);
		    
		   
		    
		    
		    $data['features'] =  $this->CommanModel->get_lang('features', $this->data['curlangid'] , NULL, array('category_id'=>$data['itemcat']->id,'enabled'=>1), 'connlang_id', false);
		   
		  
		
            echo view($this->_subView.'details',$data);
        
		}
	}

	
	
	    
	}