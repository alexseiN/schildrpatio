<?php if ($feature->template == 'gallery') { 


$title = explode('///',$feature->title);

?>
                
                
                    <div class="inner_main_center" id="<?=$title[1]?>">
                        <?php if ($feature->title <> 'notitle') { ?>
                        
                        <h3><?=$title[0]?></h3>
                        <p><?=$feature->description?></p><br>
                        
                        <?php } ?>
                        
                        <div class="hover-main" >
        
                            <div class="hover-nav-main">
                                <span class="hover_up"><i class="fal fa-angle-up"></i></span>
                                <div class="slider slider-nav-hover">
                                    <?php foreach ($morefiles as $file) { ?>
                                    <div><img  src="<?=$folder?>/<?=$file->filename?>" alt=""></div>
                                    <?php } ?>
                                </div>
                                <span class="hover_down"><i class="fal fa-angle-down"></i></span>
                            </div>
                            <div class="slider slider-for-hover">
                                <?php foreach ($morefiles as $file) { ?>
                                    <div><img  src="<?=$folder?>/<?=$file->filename?>" alt=""></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>