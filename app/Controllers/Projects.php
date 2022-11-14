<?php  

namespace App\Controllers;
use App\Core\Maincontroller;

class Projects extends Maincontroller
{
    public $_subView = 'main/projects/';
	public function __construct(){
	    parent::__construct();
		helper('cookie');
		
	
		
	}

	public function index($slug)
	{
	    $data = $this->data;

        $data['pjcats_sel'] =  $this->CommanModel->get_lang('pjcats', $this->data['curlangid'] , NULL, array('slug'=>$slug,'enabled'=>1), 'connlang_id', true);
        
        
        $data['ogtitle'] = $data['pjcats_sel']->title;
		$data['ogdesc'] = $data['pjcats_sel']->meta_desc;
		$data['keywords'] = $data['pjcats_sel']->meta_keyword;
		$data['ogimage'] = 'assets/uploads/pjcats/thumbnails/'.$data['pjcats_sel']->image;
        

	    $data['items_sel'] =  $this->CommanModel->get_lang('project', $this->data['curlangid'] , NULL, array('category'=>$data['pjcats_sel']->id,'enabled'=>1), 'connlang_id', false);
		
		echo view($this->_subView.'index',$data);
		
	}
	
	
	public function all()
	{
	    $data = $this->data;

    
        
	    $data['items'] =  $this->CommanModel->get_lang('project', $this->data['curlangid'] , NULL, array('enabled'=>1), 'connlang_id', false);
	    
	    
	    
	    
		
		echo view($this->_subView.'all',$data);
		
	}
	
	
	public function map()
	{
	    $data = $this->data;

    
        
	    $data['items'] =  $this->CommanModel->get_lang('project', $this->data['curlangid'] , NULL, array('enabled'=>1), 'connlang_id', false);
	    
	    
	    
	    
		
		echo view($this->_subView.'map',$data);
		
	}
	
	
}
