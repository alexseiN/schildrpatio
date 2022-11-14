<div class="carousel" >
       
        <?php echo view('main/includes/logo'); ?>

        <?php echo view('main/includes/inner_slider_right');  ?>


        <div class="bread-div">
                <div class="bread-bottom" >
                    <h1 class="slidetitler text-uppercase"><?=$titleonslider?></h1> 
                    <br>
                     
                     
                     <?php if ($quotelink) { ?>
                     <h1 style="font-size: 20px ;width: 100%">       
                            <a style="left:0;" href="<?= $quotelink ?>">
                            <div class="contener slider-quote" style="background-color: #ebebec;    filter: brightness(120%);">
                                                <div class="txt_button text-uppercase" style="color:#000;"><?=static_area($curlangid,'getquote');?></div>
                                                <div class="circle">&nbsp;</div>
                                            </div>
                            </a>
                    </h1>
                    <?php } ?>
                     
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

                        <video class="slider-video" autoplay="" loop="" muted="" id="myVideo" style="height:auto%!important" >
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