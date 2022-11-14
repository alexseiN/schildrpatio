<?php if ($feature->template == 'fullimage') {  

$title = explode('///',$feature->title);

?>
                    
                    
                    
                    <div class="inner_main_center" id="<?=$title[1]?>">
                        
                        <?php if($feature->title <> 'notitle') { ?>
                        
                        <h3 class="my-3"><?=$title[0]?></h3>
                        <div><span style="color: #333333; font-size: 14pt;"><?=$feature->description?></span></div><br>
                        
                        <?php } ?>
                        
                    </div>
                    
                    
                    
                    <?php foreach ($morefiles as $file) { ?>
                            
                            <div class="inner_main_center">
                                
                                <img width="100%" src="<?=$folder?>/<?=$file->filename?>"/>
                                
                                
                                
                                
                            </div>
                            
                    
                    
                    <?php } ?>
                    
                    
                <?php } ?>   