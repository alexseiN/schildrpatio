<div class="container-fluid main_center">
            <!--div class="title">
                <div class="inner_main_center" style="margin-top: 40px;">
                    <div class=" oddd_item d-flex flex-row">
                        <div class=" main_center d-flex flex-column aligin-items-start">
                            <div class="Path-3-Copy-36"></div>
                            <div class="Enjoy-div">
                                <p class="Enjoy-the-serenity-Copy">Enjoy the serenity, energy, and beauty of nature 365 days a year no matter what climate you live in.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div-->
            <div class="title">
                <div class="page_title_prd">

                </div>
            </div>
            <div class="videos">
                <div class="vproducts d-flex flex-row">
                    
                    
                    <?php foreach($videos as $video) { ?>
                    
                    
                    <a data-toggle="modal" data-target="#videoModal<?=$video->id ?>">
                        <div class="vproduct d-flex flex-column">
                            <div class="vproduct-bottom">
                                <img style="width: 100%; height: 100%" src="assets/uploads/videos/full/<?=$video->image ?>" alt="<?=$video->name ?>">
                                <i class="far fa-play-circle"></i>
                            </div>
                            <div style="width: 100%;" d-flex flex-column align-items-start pl-5>
                                <div class="d-flex flex-row align-items-start">
                                    <p class="Roseville-New-York"><?=$video->reg ?></p>
                                </div>
                                <div class="d-flex flex-row">
                                    <p class="David"><?=$video->name ?></p>
                                </div>
                                <div class="Retractable-Motorize"><?=$video->body ?> </div>
                            </div>
                        </div>
                    </a>
                    
                    
                    
                    
                    
                <div class="modal fade video-fade" id="videoModal<?=$video->id ?>" aria-hidden="true" style="z-index:200001!important">
                    <div class="modal-dialog video-dialog" role="document">
                        <div class="modal-content video-content">
                            <div class="modal-body video-body" id="yt-player<?=$video->id ?>" style="padding: 0">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <iframe width="100%" height="100%" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                    
                    
                    <script>
                        
                          
            $("#videoModal<?=$video->id ?>").on("show.bs.modal", function() {
        
     
                $('#yt-player<?=$video->id ?> iframe').attr("src", '');
        
                $('#yt-player<?=$video->id ?> iframe').attr("src", '<?=$video->link ?>');

    });
    
    
    $("#videoModal<?=$video->id ?>").on("hide.bs.modal", function() {
        
     
                $('#yt-player<?=$video->id ?> iframe').attr("src", '');
        
                $('#yt-player<?=$video->id ?> iframe').attr("src", '<?=$video->link ?>');

    });

                        
                        
                        
                    </script>
                    
                    
                    
                  
                    
                    <?php } ?>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                </div>
            </div>
        </div>
        
        

                
                