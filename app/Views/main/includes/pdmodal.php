
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


<div class="modal fade modal-fullscreen" id="productsModal" aria-hidden="true" style="z-index:100001!important">
    <div class="modal-dialog" role="document">
        <div class="modal-content fullmodal">
            <div class="fluid-container">
                
                <div class="row">
                    <div class="col">
                        <div class="modallogo">
                            <a href="/<?=$curlangcode?>">
                                <img style="height:45px; filter: brightness(10%);" src="assets/uploads/sites/<?=$settings->logo?>" alt="<?=$settings->site_name?>"> 
                            </a>
                        </div>
                    </div>
                    <div class="col text-right"><a data-dismiss="modal"><i class="fal fa-times modalclose"></i></a></div>
                </div>
                
                <div class="modalcont">
                    
                    
                    <section class="row">
                         <?php foreach ($pdcats as $pdcat) { ?>
                    
                    <div class="col-lg-3 col-4"  data-id="<?=$pdcat->slug?>">
                        <a href="<?=$curlangcode?>/products/<?=$pdcat->slug?>">
                            <div>
                                <img style="width:100%" src="assets/uploads/pdcats/thumbnails/<?=$pdcat->image?>" alt="<?=$pdcat->title?>">
                            </div>
                            <div class="prj-info">
                                <a class="prj-text text-uppercase" href="<?=$curlangcode?>/products/<?=$pdcat->slug?>"><h5><?=$pdcat->title?></h5></a>
                                <div  ><?=$pdcat->about?></div> 
                            </div>
                        </a>
                    </div>
                    
                    <?php } ?>
                                          
                    </section>
                    
                    
                    
                    
                    
                </div>
                
              
                
                
            </div>
            
        </div>
    </div>
</div>