<?php echo view('main/includes/head'); ?> 

<body class="home"> 

    <main id="fullpage">




</div>
        
<div class="container">
            <div class="mt-5 text-center">
                <a href="/<?=$curlangcode?>">
                    <img style="height:45px;filter: brightness(10%);" src="assets/uploads/sites/<?=$settings->logo?>" alt="<?=$settings->site_name?>"> 
                </a>
                
            </div>
            <div class="mt-5 text-center">
                
                <?=$settings->offline_data;?>
            </div>
            <div class="mt-5 text-center">
            <?php echo view('main/includes/more/inlineflags'); ?>
            </div>
            <div class="mt-5 text-center">
            <?=$settings->site_email?>
            </div>
        </div>

<?php echo view('main/includes/end'); ?>
       