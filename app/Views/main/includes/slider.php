<style>
    .bread-div_new {
        width:100%;
        position:relative;
        left:6%;
        bottom: -70%;
    }
    
    
    
    
</style>

<?php 

//echo '';print_r($curreg->id);die();

?>



<div class="carousel" >
                  
              <?php echo view('main/includes/main_slider_right');  ?>
                
                <div class="slick-arrows-helper">
                    
                    <button id="prev"></button>
                    <button id="next"></button>
                </div>
                
                <div class="slide">
                    
                    <?php foreach ($sliders as $slider) { 
                    
                    
                    $exclude =explode(',',$slider->sereg);
                    
                    
                    
                    
                    
                    foreach($exclude as $ex) {
                        
                        if ($ex == $curreg->id) { 
                        
                        ?>
                        
                        
                        
                        
                        <div class="slide-element" style="background-image: url(/assets/uploads/sliders/full/<?=$slider->image?>);height: 100%" loading="lazy">
                            
                            <?php if ($slider->title) { ?>
                                 
                                 
                                
                                <div class="bread-div_new" style="display:block!important">
                                    <div class="bread-bottom">
                                        <h1 lang="en" class="slidetitler text-uppercase"><?=$slider->title?></h1>  
                                        <br>
                                         
                                         
                                        <h1 style="font-size: 20px ;width: 100%">       
                                                <a style="left:0;" href="<?=$curlangcode?>/<?=$slider->link?>">
                                                <div class="contener slider-quote" style="background-color: #ebebec;    filter: brightness(120%);">
                                                                    <div class="txt_button text-uppercase" style="color:#000;"><?=$slider->linktitle?></div>
                                                                    <div class="circle">&nbsp;</div>
                                                                </div>
                                                </a>
                                        </h1>
                                                             
                                    </div>
                                    
                                    
                                    
                                </div>
                                
                                
                                
                            <?php } ?>
                            
                            
                            
                        </div>  
                            
                
                
                   
                
                
                            
                    <?php 
                    } 
                    
                   
                    
                    } ?>
                    
                    
                    
                     
                    
                    
                    <?php } ?>
                    
                    
                </div>
            </div>