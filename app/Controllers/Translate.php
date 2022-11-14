<?php 

namespace App\Controllers;
use App\Core\Maincontroller;


//for send  mail contact 
class Translations extends Maincontroller {
	public function __construct(){
		parent::__construct();
		
	
      
	}


  
    public function index($lang_id=NULL) {
        
        if ($lang_id) {} else {
        $lang_id=9;
        }
        //  Static Areas
        
        $db = \Config\Database::connect();
        $builder = $db->table('static_text_lang');
        $builder->where('language_id', $lang_id);
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h4 style="font-family:Arial;">Static Areas</h4>';
        
        echo '<a href="https://schildr.com/admin123/statictext">edit</a><br>';
	    echo '<hr><br>';
        
        
        foreach ($items as $item) {
	    echo $item->title.'<br>';
	    $i++;
	    
        }   
        
        //  Main
        
        $db = \Config\Database::connect();
        $builder = $db->table('l_settings_lang');
        $builder->where('language_id', $lang_id);
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h4 style="font-family:Arial;">Main Settings</h4>';

        
	    echo '<a href="https://schildr.com/admin123/settings">edit</a><br>';
	    echo '<hr><br>';
        
        foreach ($items as $item) {
	    echo $item->title.'<br>';
	    $i++;
        }
        
        foreach ($items as $item) {
	    echo $item->meta_desc.'<br>';
	    $i++;
        }
        
        foreach ($items as $item) {
	    echo $item->meta_keyword.'<br>';
	    $i++;
        }
        
        //  Countries
        
        $db = \Config\Database::connect();
        $builder = $db->table('regions_lang');
        $builder->where('language_id', $lang_id);
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h4 style="font-family:Arial;">Regions</h4>';
        
        foreach ($items as $item) {
	    echo $item->title.'<br>';
	    echo $item->message.'<br>';
	    
	    
	    echo '<a href="https://schildr.com/admin123/regions/edit/'.$item->connlang_id.' ">edit</a><br>';
	    echo '<br>';
	    
	    
	    $i++;
        } 
        
        //  Product Categories
        
        $db = \Config\Database::connect();
        $builder = $db->table('pdcats_lang');
        $builder->where('language_id', $lang_id);
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h4 style="font-family:Arial;">Product Categories</h4>';
        
        foreach ($items as $item) {
	    echo 'Title : '.htmlspecialchars_decode($item->title, ENT_NOQUOTES).'<br>';
	    echo 'About : '.htmlspecialchars_decode($item->about, ENT_NOQUOTES).'<br>';
	    echo 'More : '.htmlspecialchars_decode($item->more, ENT_NOQUOTES).'<br>';
	    
	    
	    echo '<a href="https://schildr.com/admin123/pdcats/edit/'.$item->connlang_id.' ">edit</a><br>';
	    echo '<hr><br>';
	    
	    
	    
	    
	    $i++;
        } 
        
        //  Applications
        
        $db = \Config\Database::connect();
        $builder = $db->table('applications_lang');
        $builder->where('language_id', $lang_id);
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h4 style="font-family:Arial;">Applications</h4>';
        
        foreach ($items as $item) {
	    echo $item->title.'<br>';
	    
	    echo '<a href="https://schildr.com/admin123/applications/edit/'.$item->connlang_id.' ">edit</a><br>';
	    echo '<br>';
	    
	    
	    $i++;
        } 
        
        //  Products
        
        $db = \Config\Database::connect();
        $builder = $db->table('product_lang');
        $builder->where('language_id', $lang_id);
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h4 style="font-family:Arial;">Products</h4> ';
        
        foreach ($items as $item) {
	    echo $item->title.'<br>';
	    echo $item->body.'<br>';
	    
	    echo '<a href="https://schildr.com/admin123/product/edit/'.$item->connlang_id.' ">edit</a><br>';
	    echo '<hr><br><br><br><br>';
	    
	    $i++;
        }
        
        //  Features
        
        $db = \Config\Database::connect();
        $builder = $db->table('features');
        $builder->join('features_lang', 'features_lang.connlang_id = features.id');

        $builder->where('language_id', $lang_id);
        $builder->orderBy('id', 'ASC');
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h1 style="font-family:Arial;">Features</h1>';
        
        foreach ($items as $item) {
            
                $db = \Config\Database::connect();
                $builder = $db->table('pdcats');
                $builder->join('pdcats_lang', 'pdcats_lang.connlang_id = pdcats.id');
                $builder->where('language_id', $lang_id);
                $builder->where('id', $item->category_id);
                $category = $builder->get()->getRow();
                
                
            
	    
	   
	    
	    echo '<b style="padding:5px 10px;background-color:yellow;"> '.$category->title.'</b> <a href="https://schildr.com/admin123/features/edit/'.$category->id.'/'.$item->id.' ">edit</a><br>';
	    echo ' <br>';
	    echo $item->title.'<br>';
	    echo ' <br>';
	    echo $item->description.'<br>';
	    
	    
	    echo '<br><br><br>';
	    
	    
	    
	    
	    $i++;
        }
        
        
        
        //  Project Categories
        
        $db = \Config\Database::connect();
        $builder = $db->table('pjcats_lang');
        $builder->where('language_id', $lang_id);
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h4 style="font-family:Arial;">Project Categories</h4>';
        
        foreach ($items as $item) {
	    echo $item->title.'<br>';
	    
	    echo '<a href="https://schildr.com/admin123/pjcats/edit/'.$item->connlang_id.' ">edit</a><br>';
	    echo '<hr><br>';
	    
	    
	    $i++;
        }
        
         //  Projects
        
        $db = \Config\Database::connect();
        $builder = $db->table('project_lang');
        $builder->where('language_id', $lang_id);
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h4 style="font-family:Arial;">Projects</h4>';
        
        foreach ($items as $item) {
	    echo $item->title.'<br>';
	    
	    echo '<a href="https://schildr.com/admin123/project/edit/'.$item->connlang_id.' ">edit</a><br>';
	    echo '<hr><br>';
	    
	    $i++;
        }
        
          //  Banners
        
        $db = \Config\Database::connect();
        $builder = $db->table('banners_lang');
        $builder->where('language_id', $lang_id);
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h4 style="font-family:Arial;">Banners</h4>';
        
        foreach ($items as $item) {
	    echo $item->body.'<br>';
	    
	    echo '<a href="https://schildr.com/admin123/banner/edit/'.$item->connlang_id.' ">edit</a><br>';
	    echo '<hr><br>';
	    
	    
	    $i++;
        }
        
        
          //  Pages
        
        $db = \Config\Database::connect();
        $builder = $db->table('page_lang');
        $builder->where('language_id', $lang_id);
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h4 style="font-family:Arial;">Pages</h4>';
        
        foreach ($items as $item) {
	    echo $item->title.'<br>';
	    echo $item->body.'<br>';
	    
	    echo '<a href="https://schildr.com/admin123/page/edit/'.$item->connlang_id.' ">edit</a><br>';
	    echo '<hr><br>';
	    
	    
	    $i++;
        }
        
          //  Reviews
        
        $db = \Config\Database::connect();
        $builder = $db->table('reviews_lang');
        $builder->where('language_id', $lang_id);
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h4 style="font-family:Arial;">Reviews</h4>';
        
        foreach ($items as $item) {
	    echo $item->body.'<br>';
	    
	    echo '<a href="https://schildr.com/admin123/reviews/edit/'.$item->connlang_id.' ">edit</a><br>';
	    echo '<hr><br>';
	    
	    $i++;
        }
        
         //  Videos
        
        $db = \Config\Database::connect();
        $builder = $db->table('videos_lang');
        $builder->where('language_id', $lang_id);
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h4 style="font-family:Arial;">Videos</h4>';
        
        foreach ($items as $item) {
	    echo $item->body.'<br>';
	    
	    echo '<a href="https://schildr.com/admin123/videos/edit/'.$item->connlang_id.' ">edit</a><br>';
	    echo '<hr><br>';
	    
	    
	    $i++;
        }
        
         //  Faqs
        
        $db = \Config\Database::connect();
        $builder = $db->table('faqs_lang');
        $builder->where('language_id', $lang_id);
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h4 style="font-family:Arial;">Faqs</h4>';
        
        foreach ($items as $item) {
	    echo $item->title.'<br>';
	    echo $item->body.'<br>';
	    
	    echo '<a href="https://schildr.com/admin123/faq/edit/'.$item->connlang_id.' ">edit</a><br>';
	    echo '<hr><br>';
	    
	    $i++;
        }
        
         //  Blogs
        
        $db = \Config\Database::connect();
        $builder = $db->table('blog_lang');
        $builder->where('language_id', $lang_id);
        $items = $builder->get()->getResult();
        $i=1;

        echo '<h4 style="font-family:Arial;">Blogs</h4>';
        
        foreach ($items as $item) {
	    echo $item->title.'<br>';
	    echo $item->body.'<br>';
	    echo '--------<br>';
	    
	    
	    echo '<a href="https://schildr.com/admin123/blog/edit/'.$item->connlang_id.' ">edit</a><br>';
	    echo '<hr><br>';
	    
	    
	    $i++;
        }
		
        
    }	


}

