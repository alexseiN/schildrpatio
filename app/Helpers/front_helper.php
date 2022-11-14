<?php
use App\Models\CommanModel;

function static_area($lang,$id){
        $db = \Config\Database::connect();
    
		$builder = $db->table('static_text');
		$builder->join('static_text_lang', 'static_text.id = static_text_lang.connlang_id');
		$builder->where('language_id', $lang);
		$builder->where('static_text.name', $id);
		
		$query  = $builder->get();
	
		$check = $query->getRow();
	
		if($check){
		    return $check->title;
	    } else {
		return $id;
		
    	}
}

function banner_data($lang,$slug){
        $db = \Config\Database::connect();
    
    
		$builder = $db->table('banners');
		$builder->join('banners_lang', 'banners.id = banners_lang.connlang_id');
		$builder->where('language_id', $lang);
		$builder->where('banners.type', $slug);
		
		$query  = $builder->get();
	
		$check = $query->getRow();
	
	
		return $check;
		
    
}

function multiproduct ($thiscat,$lang,$where) {
    $db = \Config\Database::connect();
    
    $builder = $db->table('product');
    $builder->join('product_lang', 'product.id = product_lang.connlang_id');
    $builder->where('language_id', $lang);
    $builder->where($where);
    $builder->orderBy('order', 'asc');
    
    $query  = $builder->get();
    
    $all = $query->getResult();
    
    $select = array();
    
    
    foreach ($all as $thisis) {
        
        $cats= explode(',',$thisis->category);
        
        foreach ($cats as $cat) {
            
            if ($cat == $thiscat) {
                
                array_push($select,$thisis);
                
            }
            
            
        }
        
        
        
    }
    
    
    
    return $select;
    
    
}

function multiproject ($thiscat,$lang,$where) {
    $db = \Config\Database::connect();
    
    $builder = $db->table('project');
    $builder->join('project_lang', 'project.id = project_lang.connlang_id');
    $builder->where('language_id', $lang);
    $builder->where($where);
    $builder->orderBy('order', 'asc');
    
    $query  = $builder->get();
    
    $all = $query->getResult();
    
    $select = array();
    
    
    foreach ($all as $thisis) {
        
        $cats= explode(',',$thisis->seproducts);
        
        foreach ($cats as $cat) {
            
            if ($cat == $thiscat) {
                
                array_push($select,$thisis);
                
            }
            
            
        }
        
        
        
    }
    
    
    
    return $select;
    
    
}

