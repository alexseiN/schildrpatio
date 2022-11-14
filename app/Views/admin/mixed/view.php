<?php 




$main = get_langer('features',$admin_lang,$thisItems->id);


$category = get_langer('pdcats',$admin_lang,$main->category_id);
$parent = get_langer('pdcats',$admin_lang,$category->parent_id);

 $morefiles = morefiles('features',$thisItems->id);

?>

<style>
    .itemer {
        border-bottom: 1px solid #ececec;
        padding:10px 0;
    }
    
    .itemel {
        
        padding:10px 0;
    }
    
    .pl-0 {
        
        padding-left:0px!important
        
    }
    
    
</style>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title"><div class="caption"><?=$name?></div></div>
            <div class="portlet-body" style="min-height:80vh;">
                
                <div class="form-body">
                
                    <div class="row">
                    
                        <div class="form-group col-lg-12">
                            <h4 class="col-lg-6"><b class="text-uppercase"><?=$parent->title?> - <?=$category->title?></b></h4>
                            <h4 class="col-lg-6"><b class="text-uppercase"><?=$main->title?></b></h4>
                        
                            <br>
                            <hr/>
                            <br>
                        
                            
                         
                            <?php foreach($morefiles as $file) { ?>
                            
                                <div class="col-md-3 col-xs-6">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100%; ">
                                        <img src="assets/uploads/features/<?=$file->filename?>">                            
                                    </div>
                                    <h4><b><a href="<?=$file->link?>" download="">DOWNLOAD</a></b></h4>
                                </div>
                            
                            
                            <?php } ?>
                            
                            
                        
                        </div>
                        
                    
                        
                    </div>
                
                
                   
                </div>
                
            </div>
        </div>
        <!-- end panel -->
    </div>
</div>




