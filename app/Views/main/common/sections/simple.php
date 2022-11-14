 <?php if ($feature->template == 'simple') { 
 
 $title = explode('///',$feature->title);
 
 
 ?>
                    
                    <div id="<?=$title[1]?>" class="inner_main_center"> 
                        <hr class="hr">
                        <h3><?=$title[0]?></h3>
                        <div><span style="color: #333333; font-size: 14pt;"><?=$feature->description?></span></div><br>
                    </div>
                    
                <?php } ?>