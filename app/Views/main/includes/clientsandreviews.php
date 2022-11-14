<div id="reviews" class="container-fluid pt-3">
            <div class="main_bottom_inner">
                
                    
                    <div class="col-lg-12 row">
                        <h3 class="col-lg-12 mb-4"><?=static_area($curlangid,'revandrat');?></h3>
                        
                        
                        <?php foreach ($reviews as $review) { ?>
                            
                            <div class=" col-md-6" >
                                <div class="row p-3 m-1 mb-3" style="min-height:220px;box-shadow:0 0 7px rgba(0,0,0,.09)">
                                    <div class="col-md-3 text-center">
                                        <img style="width:77px;height:77px;border-radius: 50%; margin:15px 0;"  src="assets/uploads/reviews/full/<?=$review->image?>" alt="<?=$review->name?>">
                                        <div class="fs-12 " style="color:#f7b500;">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-9 ">
                                        <h5><?=$review->name?></h5>
                                        <p><?=$review->link?></p>
                                        
                                        <div style="font-size:14px;"><?=$review->body?></div>
                                        
                                    </div>
                                </div>
                            </div>
                           
                           <?php } ?>
                        
                        
                    </div>
            
            </div>
        </div>
        <br><br>
        <script>
        $('a[href^="#"]').click(function () {
    $('html, body').animate({
        scrollTop: $('[name="' + $.attr(this, 'href').substr(1) + '"]').offset().top
    }, 6500);

    return false;
});
        </script>