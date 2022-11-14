<?php

namespace App\Core;

use CodeIgniter\Controller;
use App\Models\Commanmodel;
use App\Models\Detectmodel;
use App\Models\backend\Languagemodel;
use App\Models\backend\Regionsmodel;

class Maincontroller extends Controller 
{
    protected $CommanModel;

    public function __construct() {
      error_reporting(0);
        $this->helpers = array('comman', 'language', 'url', 'front', 'form_helper','recaptcha'); 

        $this->CommanModel  = new Commanmodel();
        $this->Languagemodel = new Languagemodel();
        $this->Regionsmodel = new Regionsmodel();
        $this->Detectmodel = new Detectmodel();

        $this->data['session'] = \Config\Services::session();

        //Defaults
        
        $this->data['default_domain'] = 'https://schildrpatio.com';
        
            $uri = current_url(true);

		   
		
		
		// Static variables
		
		
		$this->data['curlangcode'] = 'en';
        $this->data['curlangid'] = 8;
		$this->data['curbranch'] = $this->CommanModel->get_lang('branches', $this->data['curlangid'] , NULL, array('id'=>15), 'connlang_id', true);
		
		
		$this->data['settings'] = $this->CommanModel->get_lang('l_settings', $this->data['curlangid'] , NULL, array('id' => 1), 'connlang_id', true);
		$this->data['langs'] = $this->CommanModel->get_by('language', array('enabled'=>1), FALSE, array('order'=>'asc'), FALSE);
        $this->data['socials'] = $this->CommanModel->get_by('socials', array(), FALSE, array('order'=>'order'), FALSE);
        
		$this->data['ogtitle'] = $this->data['settings']->title;
		$this->data['ogdesc'] = $this->data['settings']->meta_desc;
		$this->data['keywords'] = $this->data['settings']->meta_keyword;
		$this->data['ogimage'] = 'assets/uploads/sites/'.$this->data['settings']->logo;
		
        $this->data['pdcats'] = $this->CommanModel->get_lang('pdcats', $this->data['curlangid'] , NULL, array('parent_id'=>0,'enabled'=>1), 'connlang_id', false);
        $this->data['pjcats'] = $this->CommanModel->get_lang('pjcats', $this->data['curlangid'] , NULL, array('parent_id'=>0), 'connlang_id', false);
        
        $this->data['top'] = $this->CommanModel->get_lang('page', $this->data['curlangid'] , NULL, array('top'=>1,'enabled'=>1), 'connlang_id', false);
        $this->data['left_top'] = $this->CommanModel->get_lang('page', $this->data['curlangid'] , NULL, array('left_top'=>1,'enabled'=>1), 'connlang_id', false);
        $this->data['left_bottom'] = $this->CommanModel->get_lang('page', $this->data['curlangid'] , NULL, array('left_b'=>1,'enabled'=>1), 'connlang_id', false);
        
        $this->data['itemcat'] =  $this->CommanModel->get_lang('pdcats', $this->data['curlangid'] , NULL, array('slug'=>'point','enabled'=>1), 'connlang_id', true); 
        $this->data['features'] =  $this->CommanModel->get_lang('features', $this->data['curlangid'] , NULL, array('category_id'=>$this->data['itemcat']->id,'enabled'=>1), 'connlang_id', false);
        
        $this->data['top_left'] = $this->CommanModel->get_lang('page', $this->data['curlangid'] , NULL, array('top_left'=>1,'enabled'=>1), 'connlang_id', false);
        $this->data['top_right'] = $this->CommanModel->get_lang('page', $this->data['curlangid'] , NULL, array('top_right'=>1,'enabled'=>1), 'connlang_id', false);
        $this->data['middle_left'] = $this->CommanModel->get_lang('page', $this->data['curlangid'] , NULL, array('enabled'=>1), 'connlang_id', false);
        $this->data['middle_right'] = $this->CommanModel->get_lang('page', $this->data['curlangid'] , NULL, array('middle_right'=>1,'enabled'=>1), 'connlang_id', false);
        
        $this->data['footer_a'] = $this->CommanModel->get_lang('page', $this->data['curlangid'] , NULL, array('footer_a'=>1,'enabled'=>1), 'connlang_id', false);
        $this->data['footer_b'] = $this->CommanModel->get_lang('page', $this->data['curlangid'] , NULL, array('footer_b'=>1,'enabled'=>1), 'connlang_id', false);
        
        $this->data['homemore'] = $this->CommanModel->get_lang('page', $this->data['curlangid'] , NULL, array('id'=>29,'enabled'=>1), 'connlang_id', true);
        
        $this->data['partners'] = $this->CommanModel->get_lang('partners', $this->data['curlangid'] , NULL, array('enabled'=>1), 'connlang_id', false); 
        $this->data['reviews'] = $this->CommanModel->get_lang('reviews', $this->data['curlangid'] , NULL, array('enabled'=>1), 'connlang_id', false); 
        $this->data['videos'] = $this->CommanModel->get_lang('videos', $this->data['curlangid'] , NULL, array('enabled'=>1), 'connlang_id', false);
        $this->data['banners'] = $this->CommanModel->get_lang('banners', $this->data['curlangid'] , NULL, array('enabled'=>1), 'connlang_id', false);
        
        $this->data['colors'] = $this->CommanModel->get_lang('colors', $this->data['curlangid'] , NULL, array('enabled'=>1,'category'=>15), 'connlang_id', false);
        $this->data['colors1'] = $this->CommanModel->get_lang('colors', $this->data['curlangid'] , NULL, array('enabled'=>1,'category'=>18), 'connlang_id', false);
        
        $this->data['per13'] = $this->CommanModel->get_lang('colors', $this->data['curlangid'] , NULL, array('enabled'=>1,'category'=>13), 'connlang_id', false);
        $this->data['per14'] = $this->CommanModel->get_lang('colors', $this->data['curlangid'] , NULL, array('enabled'=>1,'category'=>14), 'connlang_id', false);
        
        $this->data['cap96'] = $this->CommanModel->get_lang('colors', $this->data['curlangid'] , NULL, array('enabled'=>1,'category'=>12), 'connlang_id', false);
        
        $this->data['forteHorizon86'] = $this->CommanModel->get_lang('colors', $this->data['curlangid'] , NULL, array('enabled'=>1,'category'=>3), 'connlang_id', false);
        $this->data['fortePerform92'] = $this->CommanModel->get_lang('colors', $this->data['curlangid'] , NULL, array('enabled'=>1,'category'=>11), 'connlang_id', false);
        $this->data['forteVeozip'] = $this->CommanModel->get_lang('colors', $this->data['curlangid'] , NULL, array('enabled'=>1,'category'=>16), 'connlang_id', false);
        
        
        $this->data['blogs'] = $this->CommanModel->get_lang_desc('blog', $this->data['curlangid'] , NULL, array('enabled'=>1), 'connlang_id', false);
        $this->data['faqs'] = $this->CommanModel->get_lang('faqs', $this->data['curlangid'] , NULL, array('enabled'=>1), 'connlang_id', false);
        
        
        
        //top regions
        $this->data['regions'] = $this->CommanModel->get_lang('regions', $this->data['curlangid'] , NULL, array('parent_id'=>0,'enabled'=>1), 'connlang_id', false);
        
        $this->data['branches'] = $this->CommanModel->get_lang('branches', $this->data['curlangid'] , NULL, array('enabled'=>1), 'connlang_id', false);
        
        
        if ($_SESSION['cur_reg_code']) {
          $this->data['regbranches'] = $this->CommanModel->get_lang('branches', $this->data['curlangid'] , NULL, array('region_id'=>$this->data['curreg']->id,'enabled'=>1), 'connlang_id', false);
        }
        
        

        $website_active =  $this->CommanModel->get_by('l_settings', array(), FALSE, FALSE, TRUE);
        
       	if($website_active->website_active == 0){
			
			echo view('main/offline',$this->data);
			die();
			
		}   
		
		 
		 //echo $uri->getHost();
		 //die();
		 
		 
		 if($uri->getHost()=='schildr.global'){
		   
			echo view('main/global',$this->data);
			die();
			
		} 
		
		


    }
    
    
    
    
 
}
