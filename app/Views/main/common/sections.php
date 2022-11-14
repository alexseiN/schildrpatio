<?php 

//echo '<pre>';print_r($features); die();


$lv=0;$vl=0;
$lvc=0; $vlc=0; foreach ($features as $feature) {
                    if ($feature->template == 'videolist') {$vlc=$vlc+1;}
                    if ($feature->template == 'localvideos') {$lvc=$lvc+1;}
                } 

foreach ($features as $feature) { 
    

$morefiles = morefiles('sections',$feature->id);

$sdata['feature'] =  $feature;
$sdata['morefiles'] =  $morefiles;
$sdata['folder'] =  'assets/uploads/sections';


?>

  
  
                
                
               
                
                <?php if ($feature->template == 'videolist') {  $vl = $vl + 1;?>
                
                   
                                
                                <?php if ($vl == 1) { ?>
                                <div class="title mt-5">
                                    <div class="vproducts d-flex flex-row slider-for-prd aniimated-thumbnials" > 
                                <?php } ?>
                                
                                
          
         
                    
                            <?php foreach ($morefiles as $file) { ?>
                            
                            <a style="display:inline!important;" href="<?=$file->link?>">
                                <div class="vproduct d-flex flex-column">
                                    <div class="vproduct-bottom" style="background-image: url('assets/uploads/sections/<?=$file->filename?>') ">
                                        <img style="width: 100%; height: 100%; display: none" src="assets/uploads/sections/<?=$file->filename?>" >
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
  
  
                <?php echo view('main/common/sections/accordion',$sdata); ?>
                <?php echo view('main/common/sections/scroll',$sdata); ?>
                <?php echo view('main/common/sections/fullimage',$sdata); ?>
                <?php echo view('main/common/sections/gallery',$sdata); ?>
                <?php echo view('main/common/sections/stgallery',$sdata); ?>
                
                <?php echo view('main/common/sections/mixed',$sdata); ?>
                <?php echo view('main/common/sections/showroom',$sdata); ?>
                <?php echo view('main/common/sections/simple',$sdata); ?>
                <?php echo view('main/common/sections/3column',$sdata); ?>
                
                
    
                
                                
                                   
                     
                       

<?php } ?>
<br><br>