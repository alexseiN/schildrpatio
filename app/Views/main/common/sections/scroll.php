<?php if ($feature->template == 'scroll') { ?>
                
                
                    <div class="inner_main_center">
                 
                        
                        
                        
                        <h3><?=$feature->title?></h3>
                        <?php if($feature->description) {?>
                           <div><?=$feature->description?></div>
                        <?php } ?>
                    </div>
                    
                    
                    <!-- Slider main container -->
                    <div class="swiper swiper-initialized swiper-horizontal swiper-pointer-events pb-4 mb-4">
                      <!-- Additional required wrapper -->
                      <div class="swiper-wrapper">
                        <!-- Slides -->
                        
                        <?php foreach($morefiles as $file) { ?>
                        
                        <div class="swiper-slide"><img height="100%" src="<?=$folder?>/<?=$file->filename?>"/></div>
                        
                        <?php } ?>
                      </div>
                     
                    
                     
                    </div>
                    
                    
                    
                    
                    
                    
                    
                    
                <?php } ?>