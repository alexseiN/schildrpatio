<?php if ($feature->template == 'accordion') { 


$title = explode('///',$feature->title);

$faqs = get_table_front('faqs',array('enabled'=>1));

//echo '<pre>';print_r($faqs);die();

?>

<div class="inner_main_center mt-4" id="<?=$title[1]?>">
    
    
    <?php if ($feature->title <> 'notitle') { ?>
                      
                        <h3 class="my-3"><?=$title[0]?></h3>
                        <div><span style="color: #333333; font-size: 14pt;"><?=$feature->description?></span></div><br>
                        
                        <?php } ?>
    
                    </div>

<div class="title">
        <div class="vproducts d-flex flex-row"> 

            <div id="accordion" style="width:100%!important;">
                
                <?php $i=0; foreach ($faqs as $file) { $langer = get_langer('faqs',$curlangid,$file->id)?>
                
                
              <div class="card">
                <div class="card-header pointer collapsed" data-toggle="collapse" data-target="#collapse-<?=$file->id?>">
                      <h5><?=$langer->title?></h5>
                </div>
                <div id="collapse-<?=$file->id?>" class="collapse" data-parent="#accordion">
                  <div class="card-body">
                    <?=$langer->body?>
                  </div>
                </div>
              </div>
              
              
              <?php } ?>
              
              
  
</div>

</div></div>

<?php } ?>