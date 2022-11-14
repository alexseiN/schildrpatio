<?php echo view('main/includes/head'); ?>

<?php echo view('main/includes/top'); ?>

<div class="main_top">

    <div class="carousel" style="height: 87.5vh">
        <div class="bg_top" style="background-image:  url(assets/uploads/pages/full/<?= $page->image ?>); ">
            <div class="bg_layer">
            </div>
        </div>

        <?php echo view('main/includes/logo'); ?>


    </div>
</div>

<?php echo view('main/includes/leftmenu'); ?>

</div>









<div class="container-fluid main_center">
    <div class="bread quote-bread">
        <div class="bread_crumb">
            <ul class="breadcrumb">
                <li><i><a href="/"><?=static_area($curlangid,'home');?></a></i></li>
                <li class="active"><?=static_area($curlangid,'getquote');?></li>
            </ul>
        </div>

    </div>
    <div class="inner_main_center for_about">

        <!--Page Title-->
        <div class="page_title pb-0 pl_992_0" style="padding: 0;">
            <div class="main-center">
                <div class="col-md-12" style="border-top: 1px solid #7396ae;  padding-left: 0;">
                    <h1 class="text-uppercase" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px;"><?=static_area($curlangid,'getquote');?> </h1>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid main_center">
    <div class="inner_main_center for_about border_1">
        
            <div class="row contact_form ">

                <?php foreach ($pdcats as $pdcat) { ?>

                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <a href="<?=$curlangcode?>/products/<?=$pdcat->slug?>">
                        <label style="width: 100%;height: auto;cursor: pointer">
                            <div class="img-quote" style="background-image: url('/assets/uploads/pdcats/thumbnails/<?= $pdcat->image ?>') ; background-size: cover; width: 100%; height: 170px;"></div>
                        </label>
                        <div class="prj-info" style="margin-bottom: 15px">
                            <p class="prj-title">
                                <?= $pdcat->title ?>
                            </p>
                        </div>
                        </a>
                    </div>

                <?php } ?>

            </div>

    </div>
</div>

</div>

<?php echo view('main/includes/footer'); ?>
<?php echo view('main/includes/end'); ?>