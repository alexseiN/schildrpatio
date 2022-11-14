<style>
    
    section {margin:20px 0;}
    .reglist {
        margin: 10px 0;
    }
    
    .reglist a {
         color:#cecece;
         transition: color 1s;
    }
    
    .reglist a:hover {
         color:#000;
    }
    
</style>


<div class="modal fade modal-fullscreen" id="projectsModal" aria-hidden="true" style="z-index:100001!important">
    <div class="modal-dialog" role="document">
        <div class="modal-content fullmodal">
            <div class="fluid-container">
                
                
                
                <div class="modalcont">
                    
                    
                    
                    
                    <div class="project" style="width: 100%">
                        <div class="products">
                            
                            
                            <div class="project row" style="width:100%;margin:20px;">
                                <div class="col">
                                    <div class="modallogo">
                                        <a href="/<?=$curlangcode?>">
                                            <img style="filter: brightness(10%);" src="assets/uploads/sites/<?=$settings->logo?>" alt="<?=$settings->site_name?>"> 
                                        </a>
                                    </div>
                                </div>
                                <div class="col text-right"><a data-dismiss="modal"><i class="fal fa-times modalclose"></i></a></div>
                            </div>
                            
                            
                            <?php foreach ($pjcats as $pjcat) { ?>            
                            
                            <div class="project-item projects-item" data-id="">
                                <a href="<?=$curlangcode?>/projects/<?=$pjcat->slug?>">
                                    <div class="project-img projects-img">
                                        <img src="assets/uploads/pjcats/full/<?=$pjcat->image?>" alt="<?=$pjcat->title?>">
                                    </div>
                                    </a><div class="prj-info">
                                        <a href="<?=$curlangcode?>/projects/<?=$pjcat->slug?>">
                                        </a><a class="prj-text text-uppercase" href="en/projects/commercial"><?=$pjcat->title?></a>
                                        <p class="prj-title"><?=$pjcat->body?></p>
                                    </div>
                                
                            </div>
                            
                            
                            <?php } ?>
                                        
                            
                          
                            
                            
                                        
                        </div>
                
                    </div>
                    
                    
                    
                </div>
                
                
                
                
            </div>
            
        </div>
    </div>
</div>