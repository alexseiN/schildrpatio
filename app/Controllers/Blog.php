<?php  

namespace App\Controllers;
use App\Core\Maincontroller;
 
class Blog extends Maincontroller
{
    public $_subView = 'main/blog/';
	public function __construct(){
	    parent::__construct();
	    
	    
	    
		helper('cookie');
		
	
		
	}

	public function index($slug)
	{
	    $data = $this->data;
	    
	    
		
		$data['blog'] =  $this->CommanModel->get_lang('blog', $this->data['curlangid'] , NULL, array('slug'=>$slug,'enabled'=>1), 'connlang_id', true);
		
		$data['ogtitle'] = $data['blog']->title;
		$data['ogdesc'] = $data['blog']->meta_desc;
		$data['keywords'] = $data['blog']->meta_keyword;
		$data['ogimage'] = 'assets/uploads/blogs/thumbnails/'.$data['blog']->image;
		
		$data['features'] =  $this->CommanModel->get_lang('bsections', $this->data['curlangid'] , NULL, array('category_id'=>$data['blog']->id,'enabled'=>1), 'connlang_id', false);
		
         echo view($this->_subView.'index',$data);
	}
	

	
	
}
