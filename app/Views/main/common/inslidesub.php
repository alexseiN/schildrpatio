<div class="carousel" >
       
        <?php echo view('main/includes/logo'); ?>
        
        
        <div style="position:absolute;top:60px;left:60px;z-index:12;">
                
                <div class="bread-bottom" >
                    <h1 lang="en" class="lidetitler text-uppercase" style="font-family: 'Barlow Semi Condensed'!important;font-size:30px!important;width:400px;"><b style="font-weight:bold;font-size:40px;">10</b> YEAR WARRANTY</h1> 
                    
                    
                </div>
                
                
            </div>

      <div style="position:absolute;bottom:30px;left:60px;z-index:12;">
                
                <div class="bread-bottom" >
                    <h1 lang="en" class="lidetitler text-uppercase" style="font-family: 'Barlow Semi Condensed'!important;font-size:45px!important;font-weight:bold;margin-bottom:0px"><b><?=$titleonslider?></b></h1> 
                    <h1 lang="en" class="lidetitler text-uppercase" style="font-family: 'Barlow Semi Condensed'!important;font-size:40px!important;font-weight:bold;"><b><?=$secondary?></b></h1> 
                    
                </div>
                
                
            </div>
        
        <?php if (!$videom) { ?>
        <div class="slick-arrows-helper">

            <button id="prev"></button>
            <button id="next"></button>
        </div>
        <?php } ?>
        
        <div class="slide">
            
            
        <?php if ($videom) { ?>

            <?php if (parse_url($videom)['host'] == 'www.youtube.com') { ?>

                <iframe src="<?= $videom ?>" title="YouTube video player" frameborder="0" allow="autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

            <?php } else { ?>

                        <video class="slider-video" autoplay="" loop="" muted="" id="myVideo" style="height:auto!important" >
                            <source src="<?= $videom ?>" type="video/mp4">
                        </video>
                        
                        
                       
                        
                        

            <?php } ?>

        <?php } else if ($slidefiles) { ?>

            <?php foreach ($slidefiles as $item) { ?>
                        <div class="slide-element" style="background-image:   url(<?= $slpath ?>/<?= $item->filename ?>);height: 100%"></div>
            <?php } ?>
            
        <?php } else { ?>
          
            <?php foreach ($subitems as $item) { ?>
                        <div class="slide-element" style="background-image:   url(<?= $slpath ?>/<?= $item->image ?>);height: 100%"></div>
            <?php } ?>
          
          
        <?php } ?>
        </div>
    </div>