<?php echo view('main/includes/head'); ?>
<?php echo view('main/includes/topforproductpage'); ?>




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
    $this->data['onslider'] = $parent->about ;
    
    $this->data['quotelink'] = 'none';
    
    $this->data['slpath'] = '/assets/uploads/pdcats/' ;
					
	echo view('/main/common/inslidesub',$this->data);
	
	?>

    

    <?php echo view('main/includes/leftmenu'); ?>

</div>




<div class="container-fluid main_center">
    
    <div class="inner_main_center for_about" style="margin-top: 0px">
        
        <div class="page_titles pb-0 pl_992_0" style="padding: 0;">
            <div class="main_center">
                <div class="col-md-12 text-uppercase" style="padding-left: 0;">
                    <h1 lang="en" class="text-uppercase page_name" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px;"><?= $itemcat->title ?></h1>
                </div>
                <div class="col-lg-12 col-md-112 recidental_text" style="margin-top:30px; padding-right: 0;padding-left: 0;">
                    
                    <?= $itemcat->about ?>
                </div>
            </div>
        </div>
    </div>



    <!--Complex Page Systems-->
    <div class="container-fluid  ">
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
                            
                            
                            
                            <a>
                                <div class="contener" style="margin-top: 0px;margin-right: auto;margin-left: auto;" id="quoteButton1">
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
    <div class="title">
        <div class="vproducts d-flex flex-row">
            
            <?php foreach ($products as $product) { ?>
            
            
            
                   
                        <div class="vproduct d-flex flex-column product-model">
                            
                            <div class="vproduct-bottom" style="cursor:default;background-image: url('assets/uploads/products/full/<?=$product->image?>') ">
                               
                            </div>
                            <div style="width: 100%;" class="product-model-txt">
                                <div class="d-flex flex-row">
                                    <p class="SkyLounge"><?=$product->title?></p>
                                </div>
                                <div class="Solution-customized">
                                    <?=$product->body?> </div>
                            </div>
                        </div>
                    
                    
                    
            
                
            <?php } ?>
          
        </div>
    </div>
   


</div>


<?php  echo view('main/products/projects'); ?>
<?php echo view('main/includes/features'); ?>




<script src="https://www.google.com/recaptcha/api.js?render=6LfCdtgaAAAAALBd-tKVQvclyP_iasnO_7pOeyIl"></script>


<?php $products = multiproduct ($itemcat->id , $curlangid,array('quote'=>1))?>



<div class="inner_main_center for_about border_1">

           
        
        <h4 id="map-block" class="contact_foot_title"><?=static_area($curlangid,'address');?></h4>
        <div class="row contacts_helper">
            
                <div class="col-md-6 col-lg-6 contacts_item" id="contact-3">
                    <div class="contacts_item__header">
                        <div class="item__header___flag">
                            <div class="left">
                                <span><?=$curbranch->name?></span>
                            </div>
                            <div class="right">
                            <span>
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </span>
                                <span data-id="branches_map" onclick="goMap(<?=$curbranch->id?>,<?=$curbranch->gps?>);"><?=static_area($curlangid,'showinmap');?></span>
                            </div>
                        </div>
                        <div class="contacts_item__body">
                            <p><?=$curbranch->address?></p>
                            <p>T.: <?=$curbranch->phones?></p>
                            <p><?=static_area($curlangid,'email');?>: <a href="mailto:<?=$curbranch->email?>"><?=$curbranch->email?> </a></p>
                            <p><?=static_area($curlangid,'web');?>:<a href="<?php if ($curreg->domains) {echo 'https://'.$curreg->domains;} else {echo $default_domain;}?>"> <?php if ($curreg->domains) {echo 'https://'.$curreg->domains;} else {echo $default_domain;}?></a></p>
                        </div>
                    </div>
                </div>
            
            
                <?php if($regbranches) { ?>
                    <?php foreach($regbranches as $regbranch) { ?>
                
                    <?php if($regbranch->id <> $curbranch->id) { ?>     
                
                    <div class="col-md-6 col-lg-6 contacts_item" id="contact-3">
                    <div class="contacts_item__header">
                        <div class="item__header___flag">
                            <div class="left">
                                <span><?=$regbranch->name?></span>
                            </div>
                            <div class="right">
                            <span>
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </span>
                                <span data-id="branches_map" onclick="goMap(<?=$regbranch->id?>,<?=$regbranch->gps?>);">show in map</span>
                            </div>
                        </div>
                        <div class="contacts_item__body">
                            <p><?=$regbranch->address?></p>
                            <p>T.: <?=$regbranch->phones?></p>
                            <p>email: <a href="mailto:<?=$regbranch->email?>"><?=$regbranch->email?> </a></p>
                            <p>web:<a href="<?php if ($curreg->domains) {echo 'https://'.$curreg->domains;} else {echo $default_domain;}?>"> <?php if ($curreg->domains) {echo 'https://'.$curreg->domains;} else {echo $default_domain;}?></a></p>
                        </div>
                    </div>
                    </div>
                    <?php } ?>
                
                
                
                    <?php } ?>
                <?php } ?>
            
                

            
        </div>
        
        
        
        
    </div>


<!--Google map For Contact Form-->
    <div class="title">
        <div class="page_title_prd" style="padding-left: 18px !important;">
            <div class="col-md-5 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
                <h1 class="text-uppercase" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px; margin-left: 0 !important;"><?=static_area($curlangid,'ourshowrooms');?></h1>
            </div>
        </div>
    </div>
    <div class="main_center">
        <div id="branches_map" class="inner_main_center for_about border_1 pb-620-0">
            <div id="map" style="height: 400px; position: relative; overflow: hidden;"></div>
        </div>
    </div>


<div class="container-fluid main_center" id="guotelink">
    
    <div class="inner_main_center for_about">

        <!--Page Title-->
        <div class="page_title pb-0 pl_992_0" style="padding: 0;">
            <div class="main-center">
                <div class="col-md-12">
                    <h1 class="text-uppercase" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px;"><?=static_area($curlangid,'getquote');?> - <?=$itemcat->title?> </h1>
                                            
                </div>
            </div>
        </div>
    </div>
</div>






<div class="container-fluid main_center">
    <div class="inner_main_center for_about border_1">
        <form id="quote_form" method="POST">
        <div class="row contact_form ">
                            <input type="text" hidden="" name="product" value="DYNAMIC">

                    </div>
        <div class="row contact_form">
                                  
            <div class="col-md-12" style="margin-bottom: 20px">
                <p class="quote-title">
                    <?=static_area($curlangid,'getquote1text');?>
                </p>
            </div>
            
            
            <?php foreach($products as $product) { ?>
                    <div class="col-lg-3 col-md-4 col-xs-6">
                            
                            
                           
                        
                            
                            <label style="width: 100%;height: auto;cursor: pointer" for="prduct<?=$product->id ?>">
                                <img style="width:100%" src="assets/uploads/products/full/<?=$product->image ?> "/>
                            
                            </label>
                            
                            <div class="prj-info" style="margin-bottom: 15px">
                                <p class="prj-title"><input type="checkbox" style="width:20px;height:20px;" name="input-pid" id="prduct<?=$product->id ?>" value="<?=$product->id ?>" class="theClasscheck d-inline mr-3"><?=$product->title ?></p>
                            </div>
                    </div>
                                   
            <?php } ?>
                                   
                
            <div class="row" style="width: 100%;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="first_name" required="" placeholder="<?=static_area($curlangid,'firstname');?>" id="input-first_name"> 
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="last_name" required="" placeholder="<?=static_area($curlangid,'lastname');?>" id="input-last_name">
                        </div>
                        <div class="form-group">
                            <input type="email" required="" class="form-control" name="email" placeholder="<?=static_area($curlangid,'email');?>" id="input-email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control"  required="" placeholder="<?=static_area($curlangid,'phone');?>" id="input-phone">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control"  required="" placeholder="<?=static_area($curlangid,'ziporpostal');?>" id="input-zipcode">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'width');?>" id="input-width">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" required="" placeholder="<?=static_area($curlangid,'depth');?>" id="input-depth">
                        </div>
                        <div class="form-group">
                            <textarea style="height: 163px;" class="form-control" required="" id="" cols="30" rows="7" placeholder="<?=static_area($curlangid,'message');?>" name="input-message"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="ajax-error"></div>
                
            <div class="container-fluid row" style=" margin-top: 20px">
                
                <div class="col-md-12 d-flex align-items-center">
                    <div class="form-group button_group">
                        <button class="contener btn_more submio" type="submit" style="margin: 0; border: none;">
                            <div class="txt_button submiotxt"><?=static_area($curlangid,'send');?></div>
                            <div class="circle">&nbsp;</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </form>    </div>
</div>


<div class="container-fluid main_center">
	
	<div class="inner_main_center for_about">

		<!--Page Title-->
		<div class="page_title pb-0 pl_992_0" style="padding: 0;">
			<div class="main_center">
				<div class="col-md-4 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
					<h1 class="text-uppercase" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px;">FAQ</h1>
				</div>
				<div class="col-lg-12 col-md-12 about_text" style="padding: 0;">

					<p>In case if you want to ask the following :<br></p>				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid main_center">

        <div class="project" style="width: 100%">
                <div class="products">
                    
                                            
                        <?php foreach($faqs as $faq) { ?>
                              
                                            <h5 class="col-lg-12 col-md-12">
                                                <b><?=$faq->title?></b>
                                            </h5>
                                           
                                            <div class="col-lg-12 col-md-12 about_text">
                                                 <p><?=$faq->body?><br></p>                                                 
                                                 
                                            </div>
                                            
                                            <hr>
                                     
                          
                        <?php } ?>
                                            
                                     
                          
                        
                                           
                </div>

        </div>

</div>


<script>
        var app_lang = 'en';

        var branches = [];
        
                    branches.push([0, '<?=$curbranch->name?>', <?=$curbranch->gps?>, 'object_2', 'map.svg', <?=$curbranch->id?>]);
                  
                    <?php if($regbranches) { ?>
                    <?php $i=1; foreach($regbranches as $regbranch) { ?>
                    <?php if($regbranch->id <> $curbranch->id) { ?>
                    
                    branches.push([<?=$i?>, '<?=$regbranch->name?>', <?=$regbranch->gps?>, 'object_2', 'map.svg', <?=$regbranch->id?>]);
                  
                    <?php } ?>
                    <?php $i++;} ?>
                    <?php } ?>
        
        var web_url = '';

        var domain = '/en';
    </script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD85IqNDTQt5gqc-EHf2ZBnpsYtfd1R1wE"></script>

<script>
      function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute('6LfCdtgaAAAAALBd-tKVQvclyP_iasnO_7pOeyIl', {action: 'submit'}).then(function(token) {
              document.getElementById("contact_form").submit();
          });
        });
      }
  </script>

<script>
    $(document).ready(function() {
                $('#contact_form').submit(function() {
                    
                        $('.submio').prop("disabled", true);
                        $('.submiotxt').html('<?=static_area($curlangid,'sending');?>');
                    
                         var message = $('#input-message').val();
                         
                   
                    
                    
                        var first_name = $('#input-first_name').val();
                        var last_name = $('#input-last_name').val();
                        var street = $('#input-street').val();
                        var zipcode = $('#input-zipcode').val();
                        var city = $('#input-city').val();
                        
                        var phone = $('#input-phone').val();
                        var email = $('#input-email').val();
                        
                        
                        var branch = '<?=$curbranch->id?>';
                        
                       
                        
                        var callbacktime = $('input[name=input-time]:checked', '#contact_form').val();
                        
                       
                        
                        
                        $.ajax({
                                type: "POST",
                                url:"/page/sendcontact", 
                                data: {
                                    <?=csrf_token();?>:'<?=csrf_hash();?>',
                                    first_name: first_name,
                                    last_name: last_name,
                                    street:street,
                                    zipcode:zipcode,
                                    city:city,
                                    
                                    phone:phone,
                                    email: email,
                                    
                                    message:message,
                                    
                                    branch:branch,
                                    
                                    callbacktime:callbacktime,
                                    
                                    
                                 
                                    
                                    },
                                    success: function(data) {
                                        
                                    //    alert(data);
                                        $('.ajax-error').html('<?=static_area($curlangid,'datasent');?>'); 
                                        
                                        window.location.href = "/<?=$curlangcode?>/page/thanks"; 
                                        
                                    }
                                });
                                
                        
                        
                        
                                
                                
                            return false;
                        });
                        
                        
                        
                        
                });
</script>

<script>
    
    var mapInit = 0;

function initialize() {
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
    var e = new google.maps.LatLng(<?=$curbranch->gps?>),
        a = {
            zoom: 8,
            center: e,
            scrollwheel: !1,
            draggable: !0,
            minZoom: 3,
            maxZoom: 17,
            streetViewControl: !1,
            mapTypeControl: !1,
            mapTypeId: google.maps.MapTypeId.TERRAIN,

            styles: [ { "featureType": "water", "elementType": "all", "stylers": [ { "hue": "#71d6ff" }, { "saturation": 100 }, { "lightness": -5 }, { "visibility": "on" } ] }, { "featureType": "poi", "elementType": "all", "stylers": [ { "hue": "#ffffff" }, { "saturation": -100 }, { "lightness": 100 }, { "visibility": "off" } ] }, { "featureType": "transit", "elementType": "all", "stylers": [ { "hue": "#ffffff" }, { "saturation": 0 }, { "lightness": 100 }, { "visibility": "off" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "hue": "#deecec" }, { "saturation": -73 }, { "lightness": 72 }, { "visibility": "on" } ] }, { "featureType": "road.highway", "elementType": "labels", "stylers": [ { "hue": "#bababa" }, { "saturation": -100 }, { "lightness": 25 }, { "visibility": "on" } ] }, { "featureType": "landscape", "elementType": "geometry", "stylers": [ { "hue": "#e3e3e3" }, { "saturation": -100 }, { "lightness": 0 }, { "visibility": "on" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "hue": "#ffffff" }, { "saturation": -100 }, { "lightness": 100 }, { "visibility": "simplified" } ] }, { "featureType": "administrative", "elementType": "labels", "stylers": [ { "hue": "#59cfff" }, { "saturation": 100 }, { "lightness": 34 }, { "visibility": "on" } ] } ]
        };
    for (map = new google.maps.Map(document.getElementById("map"), a), i = 0; i < markers1.length; i++) {
        addMarker(markers1[i], directionsService, directionsDisplay);
        directionsDisplay.setMap(map);
    }
}

function addMarker(e, directionsService, directionsDisplay) {
    var a = e[4],
        t = e[1],
        o = new google.maps.LatLng(e[2], e[3]),
        i = e[1],
        l = e[5];
    m = e[6];
    marker1 = new google.maps.Marker({
        title: t,
        position: o,
        category: a,
        metro_id: m,
        map: map,
        icon: {
            url: "../assets/main/img/" + l
        }
    });
    gmarkers1.push(marker1);
    google.maps.event.addListener(marker1, "click", function(e, a) {
        return function() {
            console.dir(e);
            console.dir(a);
            infoWindow.setContent(a);
            infoWindow.open(map.getCenter(), e);
            map.panTo(this.getPosition());
            map.setZoom(8);
            if(geolocation) {
                calculateAndDisplayRoute(directionsService, directionsDisplay, o);
            }
            return false;
        }
    }(marker1, i))
}

var gmarkers1 = [],
    markers1 = [],
    infoWindow = new google.maps.InfoWindow({
        content: ""
    });


markers1 = branches,

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}

initialize();

mapInit = 1;
// google.maps.event.trigger(map, 'resize');
/**/

function goMap(markerId, lat, lon){
    // google.maps.event.trigger(gmarkers1[markerId], 'click');
    $('html, body').animate({
        scrollTop: $("#branches_map").offset().top
    }, 1000);
    var center = new google.maps.LatLng(lat, lon);
    map.setZoom(7)
    map.panTo(center);
}
    
</script>


<script>
      function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute('6LfCdtgaAAAAALBd-tKVQvclyP_iasnO_7pOeyIl', {action: 'submit'}).then(function(token) {
              document.getElementById("quote_form").submit();
          });
        });
      }
  </script>

<script>
    $(document).ready(function() {
                $('#quote_form').submit(function() {
                    
                    
                        $('.submio').prop("disabled", true);
                        $('.submiotxt').html('<?=static_area($curlangid,'sending');?>');
                        
                        var pid = [];
                       
                        
                        $('.theClasscheck:checkbox:checked').each(function(){
                            pid.push($(this).val());
                        });
                       
                       pid=pid.toString();
                        
                        var message = $('textarea:input[name=input-message]').val();
                        
                        
        
                    
                        var first_name = $('#input-first_name').val();
                        var last_name = $('#input-last_name').val();
                        var email = $('#input-email').val();
                        var phone = $('#input-phone').val();
                        var zipcode = $('#input-zipcode').val();
                        
                        
                        var width = $('#input-width').val();
                        var depth = $('#input-depth').val();
                        
                        var branch = '<?=$curbranch->id?>';
                        
                        var incat = '<?=$itemcat->id?>';
                        
                        
                        $.ajax({
                                type: "POST",
                                url:"/quotes/getQuote",
                                data: {
                                    <?=csrf_token();?>:'<?=csrf_hash();?>',
                                    first_name: first_name,
                                    last_name: last_name,
                                    email: email,
                                    incat: incat,
                                    phone: phone,
                                    zipcode: zipcode,
                                    width: width,
                                    depth: depth,
                                    branch: branch,
                                    
                                    pid: pid,
                                    
                                    message: message,
                             
                                    },
                                    success: function(data) {
                                        
                                     //   alert(data);
                                      
                                        $('.ajax-error').html('<?=static_area($curlangid,'datasent');?>');
                                        
                                       // window.location.href = "/<?=$curlangcode?>/quotes/thanks"; 
                                    }
                                });
                            return false;
                        });
                        
                        
                        
                });
</script>



<script>
    $("#quoteButton").click(function(){

$('html, body').animate({
        scrollTop: $("#guotelink").offset().top
    }, 1000);
});
</script>

<script>
    $("#quoteButton1").click(function(){

$('html, body').animate({
        scrollTop: $("#guotelink").offset().top
    }, 1000);
});
</script>


<?php echo view('main/includes/end'); ?>