<style>
    .whitefor {
        color:#fff!important
    }
    
</style>


<?php foreach($banners as $banner) {

    if($banner->type == 'onslider.right') { 
    $rightBanner = $banner;
    }
    
    
    
    
 } ?>

<?php if($rightBanner) { ?>

<div class="carousel_right_zone" style="width:400px">
    <div class="carousel_right_zone_inner whitefor">
        <?=$rightBanner->body ?>

    </div>


    <div class="carousel_right_zone_inner text-uppercase">
        
    </div>
    <span class="open_right">

        <i class="fa fa-angle-right"></i>
    </span>
</div>

<?php } ?>

<script>
      function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute('6LfCdtgaAAAAALBd-tKVQvclyP_iasnO_7pOeyIl', {action: 'submit'}).then(function(token) {
              document.getElementById("slider_right").submit();
          });
        });
      }

    $(document).ready(function() {
                $('#slider_right').submit(function() {
                    
                           
                            
                        $('.submio').prop("disabled", true);
                        $('.submiotxt').html('<?=static_area($curlangid,'sending');?>');
                        
                        
                        var email = $('#input-emails').val();
                        var zipcode = $('#input-zipcodes').val();
                        var branch = '<?=$curbranch->id?>';
                        //var from = 'footer';
                        var from = $('#fromvals').val();
                        
                        
                        
                        $.ajax({
                                type: "POST",
                                url:"/fromhome/getEmail",
                                data: {
                                    <?=csrf_token();?>:'<?=csrf_hash();?>',
                                    email: email,
                                    zipcode: zipcode,
                                    branch: branch,
                                    from: from,
                                    },
                                    success: function(data) {
                                        
                                    //    alert(data);
                                      
                                        $('.ajax-error').html('<?=static_area($curlangid,'datasent');?>');
                                        
                                        $('.submiotxt').html('<?=static_area($curlangid,'send');?>');
                                        
                                     //   window.location.href = "/<?=$curlangcode?>/quotes/thanks"; 
                                    }
                                });
                            return false;
                        });
        
                });
</script>
