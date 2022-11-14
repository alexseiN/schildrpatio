<style>
    .bread-index {
        font-size:40px;
    }
</style>

<div class="container-fluid main_center">
            <div class="inner_main_center ">

                
                
                
                
                <div class="main_center odd_item d-flex flex-column justify-content-center">
                    
                    <div class="hdr-left hdr-left-index">
                        <div class="main_left  d-flex flex-column aligin-items-start ">
                            <div class="bread-index">
                            
                            <?php if($curreg) { ?>
                                
                                <?=$curreg->message?>
                            
                            <?php } else { ?>
                            
                                <?=static_area($curlangid,'welcomeglobal');?>
                            
                            <?php }  ?>
                            
                            
                            </div>
                           
                            <div>
                                <?=banner_data($curlangid,'home.asl')->body?>
                            </div>
                          
                        </div>
                        <div class="main_right" style="font-size: 17px">
                            
                             
                            
                            <div>
                                <p class="Enjoy-the-serenity">
                                    
                                    
                                    
                                    
                                <p><?=banner_data($curlangid,'home.asr')->body?></p>
                                
                            </div>
                            
                            
                            
                            <a href="<?=$curlangcode?>/page/<?=$homemore->slug?>">
                                
                                
                                <div class="contener">
                                    <div class="txt_button"><?=static_area($curlangid,'more');?></div>
                                    <div class="circle">&nbsp;</div>
                                </div>
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </div>