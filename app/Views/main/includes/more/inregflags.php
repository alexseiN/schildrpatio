<?php if ($curreg) {  $reglangs =explode(',',$curreg->selang); foreach ($reglangs as $idlang) { //
                    
                                        $uri = new \CodeIgniter\HTTP\URI();
                                    	$exploded = explode('/', $uri);
                                    	$exploded[0] = langidtocode($idlang);
                                    	$uri = implode('',$exploded);
                              
                    ?>
                    
                    
                    
                    <li>
                        <a href="<?=$uri?>/<?=$curreg->code?>">
                            <img style="height:12px" src="assets/uploads/language/thumbnails/<?=langidtoimg($idlang)?>"/>
                            
                        </a>
                    </li>
                    
                    <?php  }} ?>