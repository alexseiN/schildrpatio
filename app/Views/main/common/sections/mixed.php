<?php if ($feature->template == 'mixed') { 

$title = explode('///',$feature->title);


?>
                    <div class="container-fluid" style="background-color: #ebebec;padding-top: 25px; padding-bottom: 25px;margin-top: 60px" id="<?=$title[1]?>">
                    <div class="inner_main_center">
                        
                        <?php if ($feature->title <> 'notitle') { ?>
                        
                        <h3><?=$title[0]?></h3>
                        <div><span style="color: #333333; font-size: 14pt;"><?=$feature->description?></span></div><br>
                        
                        <?php } ?>
                        
                        
                        <br><br>
                        
                        
                        
                        <div class="main">
                            <div class="catalogs ">
                                
                                
                                <?php foreach ($morefiles as $file) { ?>
                                
                                    <div class="catalog-item " id="<?php if($file->filetype == 'video') { echo 'video-gallery';}?>">
                                            <a href="<?php if($file->filetype == 'video') { echo $file->link;} else { echo $file->link;} ?>" >
                                                <div class="catalog-image  " style="background-image: url('<?=$folder?>/<?=$file->filename?>')">
                                                        
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