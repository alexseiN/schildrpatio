<div class="contact_main">
                <div class="contact-menu">
                    
                    <?php if ($curreg) { ?>
                    
                    <p class="menu-text  text-uppercase"><b><?=$curreg->title?></b></p>
                    
                    <?php } else { ?>
                    
                    <p class="menu-text  text-uppercase"><?=static_area($curlangid,'menu');?></p>  
                    
                    <?php } ?>
                    
                </div>
                <div class="contact-x">
                    <div class="contact-parts">
                        
                        <?php foreach($left_top as $lt) { ?>
                        
                        <div class="contact-part text-uppercase">
                            <a href="<?=$curlangcode?>/page/<?=$lt->slug ?>"><?=$lt->title ?></a>
                        </div>
                        
                        <?php } ?>
                        
                        
                        
                        <div class="contact-part text-uppercase">
                            <a href="<?=$curlangcode?>/projects">
                                <?=static_area($curlangid,'projects');?>
                                <span class="show_sub_menu arr" id="project-menu" style="padding-right: 15px;padding-left: 15px"><i class="fas fa-chevron-right "></i></span>
                            </a>
                        </div>
                        <?php foreach ($pjcats as $pjcat) { ?>
                        <div class="sub-prj  text-uppercase">
                            <a href="<?=$curlangcode?>/projects/<?=$pjcat->slug ?>"><?=$pjcat->title?></a>
                        </div>
                        <?php } ?>
                        <div class="contact-part text-uppercase">
                            <a href="<?=$curlangcode?>/products" class="span">
                                <?=static_area($curlangid,'products');?>
                                <span class="show_sub_menu arr" id="product-menu" style="padding-left: 15px;padding-right: 15px;"><i class="fas fa-chevron-right"></i></span>
                            </a>
                        </div>
                        
                        <?php foreach ($pdcats as $pdcat) { ?>
                        <div class="sub-prd  text-uppercase">
                            <a href="<?=$curlangcode?>/products/<?=$pdcat->slug?>"><?=$pdcat->title?></a>
                        </div>
                        
                        <?php } ?>
                        
                        <?php foreach($left_bottom as $lb) { ?>
                        
                        <div class="contact-part text-uppercase">
                            <a href="<?=$curlangcode?>/page/<?=$lb->slug ?>"><?=$lb->title?></a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>