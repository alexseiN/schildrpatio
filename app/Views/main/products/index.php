<?php echo view('main/includes/head'); ?>
<?php echo view('main/includes/top'); ?>

<div class="main_top">


    <?php $subitems = sub_langers('pdcats', $curlangid, $itemcat->id); ?>



    <?php 
    
    $this->data['carotitle'] = static_area($curlangid, 'products');
    $this->data['carosub'] = $itemcat->title;
    $this->data['videom'] = $itemcat->video;
    $this->data['slidefiles'] = morefiles('pdcats', $itemcat->id);  
    $this->data['subitems'] = $subitems;
    $this->data['sublink'] =  $curlangcode.'/products/'.'%s';
    $this->data['titleonslider'] = $itemcat->title ;
    $this->data['onslider'] = $itemcat->about ;
    
    $this->data['slpath'] = '/assets/uploads/pdcats/' ;

					
	echo view('/main/common/inslider',$this->data);
	
	?>


    <?php echo view('main/includes/leftmenu'); ?>

</div>



<div class="container-fluid main_center">

    <div class="inner_main_center mt-0 pb-415-0">

        <div class="page_titles pb-0 pl_992_0" style="padding: 0; ">
            <div class="bread">
                <div class="_bread_crumb_other_page ">
                    <ul class="breadcrumb">
                        <li><i><a href="/"><?=static_area($curlangid,'home');?></a></i></li>
                        <li><i><a href="<?=$curlangcode?>/products"><?=static_area($curlangid,'products');?></a></i></li>
                        <li class="active"><?= $itemcat->title ?></li>
                    </ul>
                </div>
            </div>
            <div class="main_center">
                <div class="col-md-12 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
                    <h1 class="text-uppercase page_name" style="margin-top: 30px;"><?= $itemcat->title ?></h1>
                </div>
                <div class="col-lg-12 col-md-12 recidental_text" style="padding-left: 0;">

                    <p><?= $itemcat->more ?> </p>
                </div>
            </div>
        </div>


    </div>
</div>



    <?php foreach ($subitems as $sub) { ?>

                    
 
                        
               

     
                    
                    
                    <div class="container-fluid  ">
        <div class="title product-in product-model">
            <a href="<?= $curlangcode ?>/products/<?=$sub->slug?>">
            <div class="hdr-prd-left" style="margin-top: 20px;">
                <div class="main_prd_right" style="background-image: url('/assets/uploads/pdcats/full/<?= $sub->image ?>');background-size: cover">

                </div>
                <div class="main_prd_left">
                    <div style="background-color: <?php if ($sub->bcolor) {echo $sub->bcolor;} else {echo '#ebebec';} ?>" class="prdct-single-info">
                        <div class="prdct-single-name">
                            <h4 lang="en" class="prd-name text-uppercase" id=""><?= $sub->title ?></h4>
                        </div>
                        <div class="prdct-single-about">
                            
                            
                            <?php if ($sub->tags) { $alltags = explode(',', $sub->tags);    $i = 1;

                                        foreach ($alltags as $tag) { if ($i == 1) {    ?>

                                                <p><span style="font-size: 18pt; color: #000000;"><strong><?= $tag ?></strong></span></p>

                                            <?php    } else {    ?>

                                                <p><span style="font-size: 14pt;"><?= $tag ?></span></p>

                            <?php } $i++; }} ?>
                            
                            <?php 
                            
                            $apps = explode(',', $sub->seapplication);
                            
                            if($sub->seapplication) { ?>
                                <p><span class="text-uppercase"  style="font-size: 18pt; color: #000000;"><strong><?= static_area($curlangid, 'applications'); ?>: </strong></span></p>
                            <?php } ?>
                            <p><span style="font-size: 14pt; color: #000000;">
                                
                                
                                
                               
                                
                                
                               <?php

                                     
                                        
                                        
                                       
                                        

                                        if ($apps) {

                                            foreach ($apps as $apid) {

                                                $applix = get_langer('applications', $curlangid, $apid); 
                                                
                                                
                                                 if( !next( $apps ) ) {
                                                        echo $applix->title;
                                                    } else {
                                                        echo $applix->title.', ';
                                                    }
                                                
                                                
                                                ?>



                                        <?php }
                                        } ?>
                            
                            
                            </span></p>
                            
                            <div class="btn btn-outline-secondary" style="width:180px;border-radius:0px">Learn More</div>
                            
                            
                            
                        </div>
                        
                        
                        
                        
                        <div class="container-fluid" style="display: flex; flex-direction: row; padding-left: 64px; padding-right:64px;  margin-top: 10px">
                            
                            
                            
                            <a href="<?= $curlangcode ?>/quotes/<?=$sub->slug?>">
                                <div class="contener" style="margin-top: 0px;margin-right: auto;margin-left: auto;">
                                <div class="txt_button text-uppercase"><?= static_area($curlangid, 'getquote'); ?></div>
                                <div class="circle">&nbsp;</div>
                                </div>
                            </a>
                            
                            
                            
                        </div>
                        

                    </div>
                </div>
            </div>
            </a>
        </div>
    </div>
                    
                    
                    
                

                <?php } ?>
  




<?php echo view('main/includes/clientsandreviews'); ?>



<?php echo view('main/includes/footer'); ?>
<?php echo view('main/includes/end'); ?>