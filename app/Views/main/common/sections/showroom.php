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
                                        
                                        <div class="vproduct-bottom" style="background-image: url('<?=$folder?>/<?=$file->filename?>') ">
                                            <img style="width: 100%; height: 100%; display: none" src="<?=$folder?>/<?=$file->filename?>" >
                                            <i class="far fa-play-circle"></i>
                                        </div>
                                        
                                    </div>
                                </a>
                           
                        <?php } ?>
                         </div>
                        </div>
                    </div>    
                <?php } ?>