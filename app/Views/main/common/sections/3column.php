<?php if ($feature->template == '3column') { 


$title = explode('///',$feature->title);

?>

 <div class="inner_main_center mt-4" id="<?=$title[1]?>">
     
                        <?php if ($feature->title <> 'notitle') { ?>
                      
                        <h3 class="my-3"><?=$title[0]?></h3>
                        <div><span style="color: #333333; font-size: 14pt;"><?=$feature->description?></span></div><br>
                        
                        <?php } ?>
                        
                    </div>

<div class="title">
        <div class="vproducts d-flex flex-row">
            
                        
            
                        <?php $i=0; foreach ($morefiles as $file) { $langer = get_langer('files',$curlangid,$file->id)?>
                   
                        <div class="col-md-4 ">
                            
                            <div class="vproduct-bottom" style="cursor:default;background-image: url('<?=$folder?>/<?=$file->filename?>') ">
                               
                            </div>
                            <div style="width: 100%;" class="product-model-txt">
                                <div class="d-flex flex-row">
                                    <h5><?=$langer->title?></h5>
                                </div>
                                <div class="Solution-customized">
                                    <p><?=$langer->body?></p> </div>
                            </div>
                        </div>
                    
                    
                        <?php } ?>
            
                
                        
            
                        
                    
                    
            
                
                      
        </div>
        

        
        
    </div>



<?php } ?>