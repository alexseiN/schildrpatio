<li style=""> <form action="" method="get" enctype="multipart/form-data" id="form-language">
                        <div class="btn-group">
                            <a class="dropdown-toggle" data-toggle="dropdown"><?=$curlangcode?>
                             
                            </a>
                    
                                <ul class="dropdown-menu language-toggle" style="position: absolute; transform: translate3d(-68px, 0px, 0px); top: 36px;">
                                    <?php
                                    $setFlag = '';
                                    if(isset($print_lang_menu)&&!empty($print_lang_menu)){
                                    foreach($print_lang_menu as $set_lang){
                                        
                                        
                                    
                                    	$uri = new \CodeIgniter\HTTP\URI();
                                    	
                                    	$exploded = explode('/', $uri);
                                    	$exploded[0] = $set_lang->code;
                                    	$uri = implode('/',$exploded);
                                    	$getData = parse_url($_SERVER['REQUEST_URI']);
                                    	if(isset($getData['query'])){
                                    		$uri = $uri.'?'.$getData['query'];
                                    	}
                                    	if($set_lang->code==$lang_code){
                                    		$setFlag = site_url('assets/uploads/language/'.$set_lang->image);
                                    	}
                                    ?>
                                    <li>
                                    <a href="<?php echo $uri;?>" ><img src="<?=site_url('assets/uploads/language/'.$set_lang->image)?>" /> <?=$set_lang->language?></a>
                                    </li>
                                    <?php		
                                    } 
                                    }
                                    ?>
            
                                </ul>
                    
                    
                     </div>
                        
                    </form> </li>