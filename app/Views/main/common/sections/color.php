<?php if ($feature->template == 'color') { 

$title = explode('///',$feature->title);

?> 

<div class="inner_main_center">

<div class="">
    
        <?php if ($feature->title <> 'notitle') { ?>
    
        <h3><?=$title[0]?></h3>
        <div><?=$feature->description?></div>
        <br>
        
        <?php } ?>
        
        <div class="row">
            
            <?php $i=0; foreach ($morefiles as $file) { $langer = get_langer('files',$curlangid,$file->id)?>
                
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4"> 
        
            <img width="100%" src="<?=$folder?>/<?=$file->filename?>">
            <p style="padding:5px 0;margin-top:10px"><b><?=$langer->title?></b></p>
            
        </div>
                
                
                <?php } ?>
        
        
                </div>
        </div>
        
</div>        
        
<?php } ?>