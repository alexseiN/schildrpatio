<?php if ($feature->template == 'stgallery') { ?>
                
                
                    <div class="inner_main_center">
                        <hr class="hr">
                        
                        
                        
                        <h3><?=$feature->title?></h3>
                        <p><?=$feature->description?></p><br>
                        
                    </div>
                    
                    <div class="title">
                        
                        <div class="vproducts d-flex flex-row slider-for-prd aniimated-thumbnials row">
        
                           
                                    <?php $i=0; foreach ($morefiles as $file) { ?>
                                    
                                    <?php if($i<6) { ?>
                                        <a class="col-lg-4" style="padding-bottom:20px;" data-exthumbimage="<?=$folder?>/<?=$file->filename?>" href="<?=$folder?>/<?=$file->filename?>">
                                            
                                                
                                                <img style="width:100%;" src="<?=$folder?>/<?=$file->filename?>"/>
                                                
                                           
                                        </a>
                                    <?php } else { ?>
                                    
                                        <a class="col-lg-3" style="padding:2px;display:none;" data-exthumbimage="<?=$folder?>/<?=$file->filename?>" href="<?=$folder?>/<?=$file->filename?>">
                                            <div style="width:100%!important;" class=" d-flex flex-column product-model">
                                                
                                                <img src="<?=$folder?>/<?=$file->filename?>"/>
                                                
                                            </div>
                                        </a>
                                    
                                    
                                    
                                    <?php } $i++; } ?>
                                    
                                  
                      
                            </div>
                            
                        
                    </div>
                    
                    
                    
                <?php } ?>