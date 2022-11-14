
            <div class="title">
                <div class="page_title_prd">
                    <a href="<?=$curlangcode?>/products">
                    <div class="text-uppercase">
                        <h2 class="text-uppercase"><?=static_area($curlangid,'our_products');?></h2>
                    </div>
                    </a>
                </div>
            </div>
            <div class="project" style="margin-bottom: -37px;">
                <div class="products">
                    
                    
                    <?php foreach ($pdcats as $pdcat) { ?>
                    
                    <div class="project-item" data-id="<?=$pdcat->slug?>">
                        <a href="<?=$curlangcode?>/products/<?=$pdcat->slug?>">
                            <div class="project-img" style="background-image: url('assets/uploads/pdcats/thumbnails/<?=$pdcat->image?>') ; background-size: cover; background-position: center;">
                                <img style="display: none" src="assets/uploads/pdcats/thumbnails/<?=$pdcat->image?>" alt="<?=$pdcat->title?>">
                            </div>
                            <div class="prj-info">
                                <div class="prj-text text-uppercase"><?=$pdcat->title?></div>
                                <div class="prj-title " style="min-height:40px;"><?=$pdcat->about?></div>
                                
                                <div class="btn btn-outline-secondary"><?= static_area($curlangid, 'learnmore'); ?></div>
                                
                            </div>
                        </a>
                    </div>
                    
                    <?php } ?>
                    
                    
                    

            </div>
        </div>
        
        
        
        
        <div class="container-fluid main_center">
            <div class="title">
                <div class="inquire">
                    
                    <div class="inquire-hr" style="bottom: 0"></div> 
                </div>
            </div>
        </div>