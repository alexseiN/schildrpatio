<?php echo view('main/includes/head'); ?>
<style>
    .colroum {
        padding:25px 0;
        border-bottom: 1px solid #ededed; 
    }
    
    .colroum h5{
        text-transform:uppercase;
        font-size:1.25rem;
    }
    
    .colroum p{
        text-transform:uppercase;
        
    }
</style>
<?php echo view('main/includes/top'); ?> 

<?php 

$related = sub_langers('pdcats', $curlangid, $parent->id); 



?>

<?php 

    $products = multiproduct ($itemcat->id , $curlangid,array('enabled'=>1));
    $qproducts = multiproduct ($itemcat->id , $curlangid,array('quote'=>1));
    
    

?>

<div class="main_top">

    

<?php $subitems = sub_langers('pdcats', $curlangid, $itemcat->id); ?>

<?php 
    
    $this->data['carotitle'] = $itemcat->title;
    $this->data['carosub'] = $parent->title;
    $this->data['videom'] = $itemcat->video;
    $this->data['slidefiles'] = morefiles('pdcats', $itemcat->id); 
    $this->data['subitems'] = $qproducts;
    $this->data['sublink'] = '' ;
    $this->data['titleonslider'] = $itemcat->title ;
    $this->data['secondary'] = $itemcat->secondary ;
    $this->data['onslider'] = $parent->about ;
    
    $this->data['quotelink'] = $curlangcode.'/quotes/'.$itemcat->slug;
    
    $this->data['slpath'] = '/assets/uploads/pdcats/' ;
					
	echo view('/main/common/inslidesub',$this->data);
	
	?>

    

    <?php echo view('main/includes/leftmenu'); ?>

</div>



<div class="container-fluid main_center">
    
    <div class="inner_main_center for_about" style="margin-top: 0px">
        <div class="bread">
            <div class="_bread_crumb_other_page ">
                <ul class="breadcrumb">
                        <li><i><a href="/"><?=static_area($curlangid,'home');?></a></i></li>
                        <li><i><a href="<?=$curlangcode?>/products"><?=static_area($curlangid,'products');?></a></i></li>
                        <li><i><a href="<?=$curlangcode?>/products/<?=$parent->slug?>"><?=$parent->title?></a></i></li>
                        <li class="active"><?= $itemcat->title ?></li>
                </ul>
            </div>
        </div>
        <div class="page_titles pb-0 pl_992_0" style="padding: 0;">
            <div class="main_center">
                <div class="col-md-12 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
                    <h1 lang="en" class="text-uppercase page_name" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px;"><?= $itemcat->title ?></h1>
                </div>
                <div class="col-lg-12 col-md-112 recidental_text" style="margin-top:30px; padding-right: 0;padding-left: 0;">
                    
                    <?= $itemcat->about ?>
                </div>
            </div>
        </div>
    </div>



    
    <div class="title">
        <div class="vproducts d-flex flex-row">
            
            <?php foreach ($products as $product) { ?>
            
            
            
                   
                        <div class="vproduct d-flex flex-column product-model">
                            
                            <div class="vproduct-bottom" style="cursor:default;background-image: url('assets/uploads/products/full/<?=$product->image?>') ">
                               
                            </div>
                            <div style="width: 100%;" class="product-model-txt">
                                <div class="d-flex flex-row">
                                    <h5><?=$product->title?></h5>
                                </div>
                                <div class="Solution-customized">
                                    <?=$product->body?> </div>
                            </div>
                        </div>
                    
                    
                    
            
                
            <?php } ?>
          
        </div>
        
        
        
        
        
        
        
        
    </div>
   

    <div class="title colroum">
        <div  class="vproducts d-flex flex-row">
            
        
        <div class="col-lg-12">
        <h5><?=static_area($curlangid,'standartcolors');?></h5>
        <p><?=static_area($curlangid,'standartcolors-ex');?></p>
        <br>
        
        <div class="row">
            
            
        <?php foreach($colors as $color) { if ($color->image) { ?>
        
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4"> 
        
            <img width="100%"src="assets/uploads/colors/thumbnails/<?=$color->image?>"/>
            <p style="padding:5px 0;margin-top:10px"><b><?=$color->title?></b></p>
            
        </div>
        <?php }} ?>
        </div>
        </div>    
        </div>
    </div>
    
    
    
    <div class="title colroum">
        <div  class="vproducts d-flex flex-row">
            
        
        <div class="col-lg-12">
        <h5><?=static_area($curlangid,'wood-effect-finish');?></h5>
        <p><?=static_area($curlangid,'wood-effect-finish-ex');?></p>
        <br>
        
        <div class="row">
            
            
        <?php foreach($colors1 as $color) { if ($color->image) { ?>
        
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4"> 
        
            <img width="100%"src="assets/uploads/colors/thumbnails/<?=$color->image?>"/>
            <p style="padding:5px 0;margin-top:10px"><b><?=$color->title?></b></p>
            
        </div>
        <?php }} ?>
        </div>
        </div>  
        
        </hr>
        
        </div>
    </div>
    
    
    <?php if($parent->id == 3) { ?>
    
    <div class="title colroum">
        <div  class="vproducts d-flex flex-row">
            
        
        <div class="col-lg-12">
        <h5><?=static_area($curlangid,'precontraint-opaque-602');?> </h5>
        <p><?=static_area($curlangid,'precontraint-opaque-602-ex');?></p>
        <br>
        
        <div class="row">
            
            
        <?php foreach($per14 as $color) { if ($color->image) { ?>
        
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4"> 
        
            <img width="100%"src="assets/uploads/colors/thumbnails/<?=$color->image?>"/>
            <p style="padding:5px 0;margin-top:10px"><b><?=$color->title?></b></p>
            
        </div>
        <?php }} ?>
        </div>
        </div>    
        </div>
    </div>
    
    <div class="title colroum">
        <div  class="vproducts d-flex flex-row">
            
        
        <div class="col-lg-12">
        <h5><?=static_area($curlangid,'soltis-proof-w96');?> </h5>
        <p><?=static_area($curlangid,'soltis-proof-w96-ex');?></p>
        <br>
        
        <div class="row">
            
            
        <?php foreach($per13 as $color) { if ($color->image) { ?>
        
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4"> 
        
            <img width="100%"src="assets/uploads/colors/thumbnails/<?=$color->image?>"/>
            <p style="padding:5px 0;margin-top:10px"><b><?=$color->title?></b></p>
            
        </div>
        <?php }} ?>
        </div>
        </div>    
        </div>
    </div>

    <?php } ?>
    
    <?php if($itemcat->id == 51) { ?>
    
    <div class="title colroum">
        <div  class="vproducts d-flex flex-row">
            
        
        <div class="col-lg-12">
        <h5><?=static_area($curlangid,'soltis-lounge-96');?> </h5>
        <p><?=static_area($curlangid,'soltis-lounge-96-ex');?></p>
        <br>
        
        <div class="row">
            
            
        <?php foreach($cap96 as $color) { if ($color->image) { ?>
        
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4"> 
        
            <img width="100%"src="assets/uploads/colors/thumbnails/<?=$color->image?>"/>
            <p style="padding:5px 0;margin-top:10px"><b><?=$color->title?></b></p>
            
        </div>
        <?php }} ?>
        </div>
        </div>    
        </div>
    </div>
    
    <?php } ?>
    
    <?php if($itemcat->id == 23) { ?>
    
    <div class="title colroum">
        <div  class="vproducts d-flex flex-row">
            
        
        <div class="col-lg-12">
        <h5><?=static_area($curlangid,'soltis-horizon-86');?> </h5>
        <p><?=static_area($curlangid,'soltis-horizon-86-ex');?></p>
        <br>
        
        <div class="row">
            
            
        <?php foreach($forteHorizon86 as $color) { if ($color->image) { ?>
        
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4"> 
        
            <img width="100%"src="assets/uploads/colors/thumbnails/<?=$color->image?>"/>
            <p style="padding:5px 0;margin-top:10px"><b><?=$color->title?></b></p>
            
        </div>
        <?php }} ?>
        </div>
        </div>    
        </div>
    </div>
    
    <div class="title colroum">
        <div  class="vproducts d-flex flex-row">
            
        
        <div class="col-lg-12">
        <h5><?=static_area($curlangid,'soltis-perform-92');?> </h5>
        <p><?=static_area($curlangid,'soltis-perform-92-ex');?></p>
        <br>
        
        <div class="row">
            
            
        <?php foreach($fortePerform92 as $color) { if ($color->image) { ?>
        
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4"> 
        
            <img width="100%"src="assets/uploads/colors/thumbnails/<?=$color->image?>"/>
            <p style="padding:5px 0;margin-top:10px"><b><?=$color->title?></b></p>
            
        </div>
        <?php }} ?>
        </div>
        </div>    
        </div>
    </div>
    
    <div class="title colroum">
        <div  class="vproducts d-flex flex-row">
            
        
        <div class="col-lg-12">
        <h5><?=static_area($curlangid,'soltis-veozip');?> </h5>
        <p><?=static_area($curlangid,'soltis-veozip-ex');?></p>
        <br>
        
        <div class="row">
            
            
        <?php foreach($forteVeozip as $color) { if ($color->image) { ?>
        
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4"> 
        
            <img width="100%"src="assets/uploads/colors/thumbnails/<?=$color->image?>"/>
            <p style="padding:5px 0;margin-top:10px"><b><?=$color->title?></b></p>
            
        </div>
        <?php }} ?>
        </div>
        </div>    
        </div>
    </div>
    
    <?php } ?>
    
</div>





<?php  echo view('main/products/projects'); ?>
<?php echo view('main/common/features'); ?>

<div class="container-fluid">
        <div class="title product-in product-model">
            <div class="hdr-prd-left" style="margin-top: 20px;">
                <div class="main_prd_right" style="background-image: url('/assets/uploads/pdcats/full/<?= $itemcat->image ?>');background-size: cover">

                </div>
                <div class="main_prd_left">
                    <div style="background-color: <?php if ($itemcat->bcolor) {echo $itemcat->bcolor;} else {echo '#ebebec';} ?>" class="prdct-single-info">
                        <div class="prdct-single-name">
                            <h2 lang="en" class="prd-name text-uppercase" id=""><?= $itemcat->title ?></h2>
                        </div>
                        <div class="prdct-single-about">
                            
                            
                            <?php if ($itemcat->tags) { $alltags = explode(',', $itemcat->tags);    $i = 1;

                                        foreach ($alltags as $tag) { if ($i == 1) {    ?>

                                                <p><span style="font-size: 18pt; color: #000000;"><strong><?= $tag ?></strong></span></p>

                                            <?php    } else {    ?>

                                                <p><span style="font-size: 14pt;"><?= $tag ?></span></p>

                            <?php } $i++; }} ?>
                            
                            <?php if(!isset($apps)) { ?>
                                <p><span class="text-uppercase"  style="font-size: 18pt; color: #000000;"><strong><?= static_area($curlangid, 'applications'); ?>: </strong></span></p>
                            <?php } ?>
                            <p><span style="font-size: 14pt; color: #000000;">
                                
                                
                                
                               
                                
                                
                               <?php

                                        $apps = explode(',', $itemcat->seapplication);
                                        
                                        
                                       
                                        

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
                        </div>
                        <div class="container-fluid" style="display: flex; flex-direction: row; padding-left: 64px; padding-right:64px;  margin-top: 10px">
                            
                            
                            
                            <a href="<?= $curlangcode ?>/quotes/<?=$itemcat->slug?>">
                                <div class="contener" style="margin-top: 0px;margin-right: auto;margin-left: auto;">
                                <div class="txt_button text-uppercase"><?= static_area($curlangid, 'getquote'); ?></div>
                                <div class="circle">&nbsp;</div>
                                </div>
                            </a>
                            
                            
                            
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>

<br><br>
    

<?php if (count($related) > 3) { ?> 

<div class="container-fluid main_center">  
        
            
            <div class="title">
                <div class="page_title_prd">
                    <br><hr><br><br>
                    <a href="en/products">
                    <div class="text-uppercase">
                        <h2 class="text-uppercase"><?= static_area($curlangid, 'relatedproducts'); ?></h2>
                    </div>
                    </a>
                    <br><br>
                </div>
            </div>
            <div class="project" style="margin-bottom: -37px;">
                <div class="products">
                    
                    <?php foreach(array_rand($related, 3) as $rel) { ?>
                    
                        
                                        
                        <div class="project-item" data-id="sunroom">
                            <a href="en/products/<?=$related[$rel]->slug?>">
                                <div class="project-img" style="background-image: url('assets/uploads/pdcats/full/<?=$related[$rel]->image?>') ; background-size: cover; background-position: center;">
                                    <img style="display: none" src="assets/uploads/pdcats/full/<?=$related[$rel]->image?>" alt="Sunroom">
                                </div>
                                <div class="prj-info">
                                    <p class="prj-text text-uppercase"><?=$related[$rel]->title?></p>
                                    
                                    
                                    <div class="btn btn-outline-secondary"><?= static_area($curlangid, 'learnmore'); ?></div>
                                    
                                </div>
                            </a>
                        </div>
                    
                        
                                        
                    <?php } ?>
                    
                                        
                  
                    
                                        
                    
                    

            </div>
        </div>
        
           
        </div>

<?php } else { $related = $related_prducts; ?>

<div class="container-fluid main_center">  
        
            
            <div class="title">
                <div class="page_title_prd">
                    <br><hr><br><br>
                    <a href="en/products">
                    <div class="text-uppercase">
                        <h2 class="text-uppercase"><?= static_area($curlangid, 'otherproducts'); ?></h2>
                    </div>
                    </a>
                    <br><br>
                </div>
            </div>
            <div class="project" style="margin-bottom: -37px;">
                <div class="products">
                    
                    <?php foreach(array_rand($related, 3) as $rel) { ?>
                    
                        
                                        
                        <div class="project-item" data-id="sunroom">
                            <a href="en/products/<?=$related[$rel]->slug?>">
                                <div class="project-img" style="background-image: url('assets/uploads/pdcats/full/<?=$related[$rel]->image?>') ; background-size: cover; background-position: center;">
                                    <img style="display: none" src="assets/uploads/pdcats/full/<?=$related[$rel]->image?>" alt="Sunroom">
                                </div>
                                <div class="prj-info">
                                    <p class="prj-text text-uppercase"><?=$related[$rel]->title?></p>
                                    
                                    
                                    <div class="btn btn-outline-secondary"><?= static_area($curlangid, 'learnmore'); ?></div>
                                    
                                </div>
                            </a>
                        </div>
                    
                        
                                        
                    <?php } ?>
                    
                                        
                  
                    
                                        
                    
                    

            </div>
        </div>
        
           
        </div>

<?php } ?>




<?php echo view('main/includes/clientsandreviews'); ?>



<?php echo view('main/includes/footer'); ?>


<?php echo view('main/includes/end'); ?>