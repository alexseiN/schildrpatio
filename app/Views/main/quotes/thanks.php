<?php echo view('main/includes/head'); ?>

<!-- Event snippet for Request quote SCHILDR.COM conversion page --> <script>   gtag('event', 'conversion', {'send_to': 'AW-478347887/pYCDCJDW2PkCEO-EjOQB'}); </script>

<?php echo view('main/includes/top'); ?>

<div class="container-fluid main_top">
    <!--Carouse-->

    <div class="carousel quote-carousel" style="height: 47.5vh;">
        <?php echo view('main/includes/logo'); ?>

            <div class="bg_top" style="background-image:  url( assets/uploads/sites/thanks.jpg )">
                <div class="bg_layer">

                </div>
            </div>

    </div>
    <!-- /Carousel -->
    
    <div class="container-fluid main_center">
        
    <div class="main_bottom_inner">
        
        
    <p class="quote-title text-center">
                    <?=static_area($curlangid,'datasent');?>
                </p>
        
    </div>
    
    
    
        
    </div>
    
    
    
    <?php echo view('main/includes/leftmenu'); ?>
</div>


<?php echo view('main/includes/clientsandreviews'); ?>
<?php echo view('main/includes/footer'); ?>
<?php echo view('main/includes/end'); ?>