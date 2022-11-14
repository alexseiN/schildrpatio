<?php
                                    $setFlag = '';
                                    if(isset($langs)&&!empty($langs)){
                                    foreach($langs as $set_lang){
                                        
                                        
                                    
                                    	$uri = new \CodeIgniter\HTTP\URI();
                                    	
                                    	$exploded = explode('/', $uri);
                                    	$exploded[0] = $set_lang->code;
                                    	$uri = implode('',$exploded);
                                    	$getData = parse_url($_SERVER['REQUEST_URI']);
                                    	if(isset($getData['query'])){
                                    		$uri = $uri.'?'.$getData['query'];
                                    	}
                                    	if($set_lang->code==$lang_code){
                                    		$setFlag = site_url('assets/uploads/language/full/'.$set_lang->image);
                                    	}
                                    ?>
                                    <li class="langflags">
                                    <a href="<?php echo $uri;?>" ><img src="<?=site_url('assets/uploads/language/full/'.$set_lang->image)?>" /> </a>
                                    </li>
                                    <?php		
                                    } 
                                    }
                                    ?>
             