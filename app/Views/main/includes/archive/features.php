<?php  

$lv=0;$vl=0;
$lvc=0; $vlc=0; foreach ($features as $feature) {
                    if ($feature->template == 'videolist') {$vlc=$vlc+1;}
                    if ($feature->template == 'localvideos') {$lvc=$lvc+1;}
                } 

foreach ($features as $feature) {
    

$morefiles = morefiles('features',$feature->id);

?>

  
  
                
                
               
                
                <?php if ($feature->template == 'videolist') {  $vl = $vl + 1;?>
                
                   
                                
                                <?php if ($vl == 1) { ?>
                                <div class="title mt-5">
                                    <div class="vproducts d-flex flex-row slider-for-prd aniimated-thumbnials" > 
                                <?php } ?>
                                
                                
          
         
                    
                            <?php foreach ($morefiles as $file) { ?>
                            
                            <a style="display:inline!important;" href="<?=$file->link?>">
                                <div class="vproduct d-flex flex-column">
                                    <div class="vproduct-bottom" style="background-image: url('assets/uploads/features/<?=$file->filename?>') ">
                                        <img style="width: 100%; height: 100%; display: none" src="assets/uploads/features/<?=$file->filename?>" >
                                        <i class="far fa-play-circle"></i>
                                    </div>
                                    <div style="width: 100%;" d-flex="" flex-column="" align-items-start="" pl-5="">
                                        <div class="d-flex flex-row">
                                            <p class="SkyLounge"><?=$feature->title?></p>
                                        </div>
                                        <p class="Solution-customized">
                                            <?=$feature->description?> </p><br>
                                    </div>
                                </div>
                            </a>
                            
                            <?php } ?>
                    
                
                            <?php if ($vl == $vlc) { ?>
                                </div>
                                    </div> 
                            <?php } ?>
                    
                    
                    
                    
                <?php } ?>
                
                
                <?php if ($feature->template == 'localvideos') {  $lv = $lv + 1;?> 
                
                   
                                
                                <?php if ($lv == 1) { ?>
                                <div class="title mt-5">
                                    <div class="vproducts d-flex flex-row" > 
                                <?php } ?>
                                
                                
          
         
                    
                            <?php foreach ($morefiles as $file) { ?>
                            
                            <div class="vproduct d-flex flex-column product-model vproduct-gif-main">
                                <div class="vproduct-bottom vproduct-gif">
                                    <video controls="" muted="" style="width: 100%">
                                        <source src="<?=$file->link?>" type="video/mp4">
                                    </video>
                                </div>
                                                                <div style="width: 100%;" class="product-model-txt">
                                    <div class="d-flex flex-row">
                                        <p class="SkyLounge" style="font-weight: normal"><?=$feature->title?></p>
                                    </div>
                                    <p class="Solution-customized"><?=$feature->description?></p>
                                </div>
                                                            </div>
                            
                            <?php } ?>
                    
                
                            <?php if ($lv == $lvc) { ?>
                                </div>
                                    </div> 
                            <?php } ?>
                    
                    
                    
                    
                <?php } ?>
  
  
  
                
                
                <?php if ($feature->template == 'gallery') { ?>
                
                
                    <div class="inner_main_center" style="padding:30px 0">
                        
                        <h3><?=$feature->title?></h3>
                        <p><?=$feature->description?></p><br>
                        <div class="hover-main" >
        
                            <div class="hover-nav-main">
                                <span class="hover_up"><i class="fal fa-angle-up"></i></span>
                                <div class="slider slider-nav-hover">
                                    <?php foreach ($morefiles as $file) { ?>
                                    <div><img  src="assets/uploads/features/<?=$file->filename?>" alt=""></div>
                                    <?php } ?>
                                </div>
                                <span class="hover_down"><i class="fal fa-angle-down"></i></span>
                            </div>
                            <div class="slider slider-for-hover">
                                <?php foreach ($morefiles as $file) { ?>
                                    <div><img  src="assets/uploads/features/<?=$file->filename?>" alt=""></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                
                <?php if ($feature->template == 'stgallery') { ?>
                
                
                    <div class="inner_main_center" style="padding:30px 0">
                        
                        
                        
                        
                        <h3><?=$feature->title?></h3>
                        <p><?=$feature->description?></p><br>
                        
                    </div>
                    
                    <div class="title">
                        
                        <div class="vproducts d-flex flex-row slider-for-prd aniimated-thumbnials row">
        
                           
                                    <?php $i=0; foreach ($morefiles as $file) { ?>
                                    
                                    <?php if($i<18) { ?>
                                        <a class="col-lg-2" style="padding:2px;" data-exthumbimage="assets/uploads/features/<?=$file->filename?>" href="assets/uploads/features/<?=$file->filename?>">
                                            
                                                
                                                <img style="width:100%;" src="assets/uploads/features/<?=$file->filename?>"/>
                                                
                                           
                                        </a>
                                    <?php } else { ?>
                                    
                                        <a class="col-lg-3" style="padding:2px;display:none;" data-exthumbimage="assets/uploads/features/<?=$file->filename?>" href="assets/uploads/features/<?=$file->filename?>">
                                            <div style="width:100%!important;" class=" d-flex flex-column product-model">
                                                
                                                <img src="assets/uploads/features/<?=$file->filename?>"/>
                                                
                                            </div>
                                        </a>
                                    
                                    
                                    
                                    <?php } $i++; } ?>
                                    
                                  
                      
                            </div>
                            
                        
                    </div>
                    
                    
                    
                <?php } ?>
                
                
                <?php if ($feature->template == 'showroom') { ?>
                    
                    <div class="inner_main_center">
                        <hr class="hr">
                        <h3><?=$feature->title?></h3>
                        <p><?=$feature->description?></p><br>
                        <div class="title mt-5">
                            <div class="vproducts d-flex flex-row slider-for-prd aniimated-thumbnials">
                        <?php foreach ($morefiles as $file) { ?>
                            
                                <a href="<?=$file->link?>">
                                    <div class="vproduct d-flex flex-column">
                                        
                                        <div class="vproduct-bottom" style="background-image: url('assets/uploads/features/<?=$file->filename?>') ">
                                            <img style="width: 100%; height: 100%; display: none" src="assets/uploads/features/<?=$file->filename?>" >
                                            <i class="far fa-play-circle"></i>
                                        </div>
                                        
                                    </div>
                                </a>
                           
                        <?php } ?>
                         </div>
                        </div>
                    </div>    
                <?php } ?>
                
                <?php if ($feature->template == 'simple') { ?>
                    
                    <div class="inner_main_center">
                        <hr class="hr">
                        <h3><?=$feature->title?></h3>
                        <div><span style="color: #333333; font-size: 14pt;"><?=$feature->description?></span></div><br>
                    </div>
                    
                <?php } ?>
                
                <?php if ($feature->template == 'mixed') { ?>
                    <div class="container-fluid" style="background-color: #ebebec;padding-top: 25px; padding-bottom: 25px;margin-top: 60px">
                    <div class="inner_main_center">
                        
                        <h3><?=$feature->title?></h3>
                        <div><span style="color: #333333; font-size: 14pt;"><?=$feature->description?></span></div><br>
                        
                        
                        
                        <br><br>
                        
                        
                        
                        <div class="main">
                            <div class="catalogs ">
                                
                                
                                <?php foreach ($morefiles as $file) { ?>
                                
                                    <div class="catalog-item " id="<?php if($file->filetype == 'video') { echo 'video-gallery';}?>">
                                            <a href="<?php if($file->filetype == 'video') { echo $file->link;} else { echo $file->link;} ?>" >
                                                <div class="catalog-image  " style="background-image: url('assets/uploads/features/<?=$file->filename?>')">
                                                        
                                                        <?php if($file->filetype == 'video') { ?>
                                                        <i class="far fa-play-circle"></i>
                                                        <?php } ?>
                                                </div>
                                                <div class="catalog-text">
                                                    <p class="catalog-title">
                                                        <?=$file->description?> </p>
                                                </div>
                                            </a>
                                            <?php if($file->filetype == 'pdf') { ?>
                                            <a href="<?=$file->link?>" download="">
                                                <div class="contener mt-0" style="background-color: #ebebec ;filter: brightness(120%);">
                                                    <div class="txt_button" style="color:#000">DOWNLOAD</div>
                                                    <div class="circle">&nbsp;</div>
                                                </div>
                                            </a>
                                            <?php } ?>
                                    </div>
                           
                                <?php } ?>
                                
                                
                              
                                
        
                            </div>
                        
                        </div>
                        
                        
                        
                    </div>
                    </div>
                <?php } ?>
                
                
    
                
                <?php if ($feature->template == 'fullimage') { ?>
                    
                    <?php if($feature->title <> 'no') { ?>
                    
                    <div class="inner_main_center">
                        <hr class="hr">
                        <h3><?=$feature->title?></h3>
                        <div><span style="color: #333333; font-size: 14pt;"><?=$feature->description?></span></div><br>
                    </div>
                    
                    <?php foreach ($morefiles as $file) { ?>
                            
                            <div class="inner_main_center">
                                
                                <img width="100%" src="assets/uploads/features/<?=$file->filename?>"/>
                                
                                
                                
                                
                            </div>
                            
                    <?php } ?>
                    
                    <?php } ?>
                    
                    
                <?php } ?>                   
                                   
                     
                       

<?php } ?>