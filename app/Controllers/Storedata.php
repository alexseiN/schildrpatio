<?php  

namespace App\Controllers; 
use App\Core\Maincontroller;

 
class Storedata extends Maincontroller
{
    public $_subView = 'main/page/';
	public function __construct(){
	    parent::__construct();
	    
	    
	    
		helper('cookie');
		
	
		
	}

	public function getPost()
	{
		if(!empty($_POST))
		{
			// when using application/x-www-form-urlencoded or multipart/form-data as the HTTP Content-Type in the request
			// NOTE: if this is the case and $_POST is empty, check the variables_order in php.ini! - it must contain the letter P
			return $_POST;
		}

		// when using application/json as the HTTP Content-Type in the request 
		$post = json_decode(file_get_contents('php://input'), true);
		if(json_last_error() == JSON_ERROR_NONE)
		{
			return $post;
		}

		return [];
	}

	public function index()
	{
	    
	    header('Access-Control-Allow-Origin: *');
	    

        $this->data['settings'] = $this->CommanModel->get_lang('l_settings', $this->data['curlangid'] , NULL, array('id' => 1), 'connlang_id', true);

		$tmp = $this->getPost();
        
        $data['first_name'] = $tmp['firstName']; 
        $data['last_name'] = $tmp['lastName'];
        $data['city'] = $tmp['city'];
        $data['address'] = $tmp['address']; 
        $data['zipcode'] = $tmp['zipCode'];
        $data['email'] = $tmp['email']; 
        $data['phone'] = $tmp['phoneNumber'];
        $data['message'] = $tmp['message'];
        
        $data['unit'] = $tmp['unit'];
        $data['light'] = $tmp['Light'];
        
        
        if ($tmp['unit'] == 'inch' ) {
            
            $data['width'] = $tmp['width']*25.4;
            $data['depth'] = $tmp['depth']*25.4; 
            $data['height1'] = $tmp['height1']*25.4;
            $data['height2'] = $tmp['height2']*25.4;
            
            
        } else {
            
            $data['width'] = $tmp['width'];
            $data['depth'] = $tmp['depth']; 
            $data['height1'] = $tmp['height1'];
            $data['height2'] = $tmp['height2'];
            
            
        }
        
        
        
       
        $data['number_of_columns'] = $tmp['numberOfColumns']; 
     //   $data['added_columns'] = $tmp['addedColumns'];
     //   $data['added_columns_position'] = $tmp['addedColumnPosition']; 
        $data['cover_color'] = $tmp['coverColor'];
        $data['glass_texture'] = $tmp['glassTexture'];
        
        
        $datax1 = $this->CommanModel->calculation($data['depth'],$data['width'],$data['height1'],$data['height2'],$data['number_of_columns']);
        
        $data['price'] = $datax1['gt'];
        $data['weight'] = $datax1['w'];
        $data['ledprice'] = $datax1['led'];
        $data['install'] = $datax1['install'];
        
        $data['link'] = md5(time().$data['phone']);
        
       // sendmail(24,$data['email'],$data);
            sendmail(25,'nj@schildr.com',$data);
        
        if ($tmp['unit'] == 'inc' ) {
            
            $data['width'] = $data['width']/25.4;
            $data['depth'] = $data['depth']/25.4; 
            $data['height1'] = $data['height1']/25.4;
            $data['height2'] = $data['height2']/25.4;
            
        }
        
        if ($this->data['settings']->discount) { $data['discount'] = $this->data['settings']->discount;}

		$id = $this->CommanModel->saveData('storedata',$data, $id = NULL);
		
		if($id) {
			print_r(json_encode("Data sent successfully!"));
		}

	}
	
	
	

}
