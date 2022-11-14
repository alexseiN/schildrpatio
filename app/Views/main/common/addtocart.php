                             
<input type="hidden" id="addtocarturl" value="<?=$addtocart?>">
<input type="hidden" id="removefromcarturl" value="<?=$removecart?>">
<input type="hidden" id="listcart" value="<?=$listcart?>">
<script>


  
$(document).on('click','.decrease_',function(){
    decreaseValue(this);
});
$(document).on('click','.increase_',function(){
    increaseValue(this);
});
function increaseValue(_this) {
    var value = parseInt($(_this).siblings('input.quantity').val(), 10);
    value = isNaN(value) ? 0 : value;
    value++;
    $(_this).siblings('input.quantity').val(value);
}

function decreaseValue(_this) {
    var value = parseInt($(_this).siblings('input.quantity').val(), 10);
    value = isNaN(value) ? 0 : value;
    value < 2 ? value = 2 : '';
    value--;
    $(_this).siblings('input.quantity').val(value);
}
        

$(document).on('click','.cartitems',function(){
    location.href='<?=$_cartlink?>';
});
$(document).on('click','#confirm_order',function(){
    location.href='<?=$_confirmorder?>';
});


var mainurl = $("#addtocarturl").val();
var reloadtrue = 'no';
$(document).on('click','.choose_option',function(){
    $('span.label_variants').removeClass('active');
    var amount = $(this).attr('data-amount');
    var optionname = $(this).attr('data-option-name');
    var availquantity = $(this).attr('data-avail-quntity');
    var id = $(this).val();
    var product_id = $(this).attr('data-product');
    $('.price-new').html(amount);
    $('#'+optionname+'_product_id').val(id);
    $('#varient_avail_quntity').val(availquantity);
    $('#main_product_id').val(product_id);
});

// Cart add remove functions
var cart = {
    'add': function(selfvar) {
        addtocart(selfvar);
    },
    'remove': function(page,id) {
        removefromcart(page,id);
    },
    'list': function() {
        listcart();
    },
    'update': function(selfvar,id) {
        updatecart(selfvar,id);
    }
}

$(window).load(function() {
    cart.list();
});
function addProductNotice(msg){
    alert(msg);
}
function addtocart(selfvar) {
    var product_id = $(selfvar).attr('data-product-id');
    var avail_quntity = parseInt($("#varient_avail_quntity").val().trim());		
    var total_varient = parseInt($(selfvar).attr('data-total-varient'));
    var sizevariant = 0;var colorvariant = 0;
    sizevariant = parseInt($("#size_product_id").val().trim());
    colorvariant = parseInt($("#color_product_id").val().trim());

    var productprice = $(selfvar).attr('data-product-price');
    if(productprice == ''){
        addProductNotice('You can not add this Item as price is not valid.');
        return false;
    }
    //alert(checkvariant);return false;
    if(total_varient > 0){
        if((sizevariant <= 0 || colorvariant <= 0) && total_varient == 2){
            addProductNotice('Please select option');
            return false;
        }
        else if((sizevariant <= 0 && colorvariant <= 0) && total_varient == 1){
            addProductNotice('Please select option');
            return false;
        }
    }

    if(avail_quntity <= 0){
        addProductNotice('This product is out of stock');
        return false;
    }
    
    var quantity =  parseInt($("#quantity_"+product_id).val().trim());
    if(quantity>avail_quntity){
        addProductNotice('Please select less quantity');
        return false;
    }
    
    var mainproduct = $("#main_product_id").val();
    runcartajax(mainurl,sizevariant,colorvariant,quantity,mainproduct,'add');		
}

function runcartajax(mainurl,sizevariant,colorvariant,quantity,mainproduct,type){
    $.post(mainurl, {
        sizevariant: sizevariant,
        colorvariant: colorvariant,
        quantity: quantity,
        mainproduct:mainproduct,
        type:type,
    }, (function(res) {
        const obj_response = JSON.parse(res);
        addProductNotice(obj_response.e_message);
        if(type == 'update'){
            reloadtrue = 'yes';
        }
        cart.list();			
    })).fail((function(t) {
        addProductNotice('Something not right');
        location.reload();
    }));		
}

function updatecart(selfvar,id){
    var avail_quntity = parseInt($(selfvar).attr('data-avail-count'));
    var mainproduct = parseInt($(selfvar).attr('data-product-id'));
    var sizevariant  = parseInt($(selfvar).attr('data-size-id'));
    var colorvariant = parseInt($(selfvar).attr('data-color-id'));
    
    var unitamount = $(selfvar).attr('data-unit-amount');
    let newtotal_amount = parseFloat(unitamount)*parseFloat(unitamount);
    let total = newtotal_amount.toFixed(2);
    
    var quantity =  parseInt($(".updatequantity_"+id).val().trim());
    
    if(quantity>avail_quntity){
        addProductNotice('Please select less quantity');
        return false;
    }
    runcartajax(mainurl,sizevariant,colorvariant,quantity,mainproduct,'update');
}

function removefromcart(page,id){
    var mainurl = $("#removefromcarturl").val();
    $("#cartrow_"+id).hide();
    $.post(mainurl, {
        productkey:id
    }, (function(response) {
		const resdel = JSON.parse(response);
        addProductNotice(resdel.e_message);
        reloadtrue = 'yes';
        cart.list();
        $("#cartrow_"+id).remove();
    })).fail((function(t) {
        $("#cartrow_"+id).show();
        addProductNotice('Something not right');
    }));
}

function listcart(){
    var mainurl = $("#listcart").val();
    $.post(mainurl, (function(response) {
       
        const res = JSON.parse(response);

        $('span.cart-total-full span.items_cart').html(res.totalitems+" ");
        $('span.cart-total-full span.items_cart2').html(" - "+res.totalamount);
        $("#totalwithtax").html(res.totalwithtax);
        $("#totaltax").html(res.tax);
        $("#totalamount").html(res.totalamount);
        $.each(res.cartarray_itemamount, function (key, data) {
            $(".total_amount_"+key).html(data);
        });
        $('.cartitems').html('<span><i class="fa fa-shopping-cart"></i> Cart ('+res.totalitems+')</span>');
    }));
}

</script>





<style>
.cartitems{cursor:pointer;}
#variants{    display: block;
    width: 100%;
    overflow: hidden;}
#variants .checkbox, #variants .radio{display: inline-block;margin:5px !important;}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
.picZoomer {
  position: relative;
  /*margin-left: 40px;
    padding: 15px;*/
}
.picZoomer-pic-wp {
  position: relative;
  overflow: hidden;
  text-align: center;
}
.picZoomer-pic-wp:hover .picZoomer-cursor {
  display: block;
}
.picZoomer-zoom-pic {
  position: absolute;
  top: 0;
  left: 0;
}
.picZoomer-pic {
  /*width: 100%;
	height: 100%;*/
}
.picZoomer-zoom-wp {
  display: none;
  position: absolute;
  z-index: 999;
  overflow: hidden;
  border: 1px solid #eee;
  height: 460px;
  margin-top: -19px;
}
.picZoomer-cursor {
  display: none;
  cursor: crosshair;
  width: 100px;
  height: 100px;
  position: absolute;
  top: 0;
  left: 0;
  border-radius: 50%;
  border: 1px solid #eee;
  background-color: rgba(0, 0, 0, 0.1);
}
.picZoomCursor-ico {
  width: 23px;
  height: 23px;
  position: absolute;
  top: 40px;
  left: 40px;
}

.my_img {
  vertical-align: middle;
  position: absolute;
  top: 0;
  bottom: 0;
  margin: auto;
  height: 100%;
}
.piclist li {
  display: inline-block;
  width: 90px;
  height: 114px;
}

.piclist li img {
  width: 97%;
  height: auto;
}

/* custom style */
.picZoomer-pic-wp,
.picZoomer-zoom-wp {
  border: 1px solid #eee;
}


section {
  padding: 0px 0px 10px 0;
}
.row-sm .col-md-6 {
  padding-left: 5px;
  padding-right: 5px;
}

/*===pic-Zoom===*/
._boxzoom .zoom-thumb {
  width: 90px;
  display: inline-block;
  vertical-align: top;
  margin-top: 0px;
}
._boxzoom .zoom-thumb ul.piclist {
  padding-left: 0px;
  top: 0px;
}
._boxzoom ._product-images {
  width: 80%;
  display: inline-block;
}
._boxzoom ._product-images .picZoomer {
  width: 100%;
}
._boxzoom ._product-images .picZoomer .picZoomer-pic-wp img {
  left: 0px;
}
._boxzoom ._product-images .picZoomer img.my_img {
  width: 100%;
}
.piclist li img {
  height: 100px;
  object-fit: cover;
}

/*======products-details=====*/
._product-detail-content {
  background: #fff;
  padding: 15px;
  border: 1px solid lightgray;
}
._product-detail-content p._p-name {
  color: black;
  font-size: 20px;
  border-bottom: 1px solid lightgray;
  padding-bottom: 12px;
}
.p-list span {
  margin-right: 15px;
}
.p-list span.price {
  font-size: 25px;
  color: #318234;
}
._p-qty > span {
  color: black;
  margin-right: 15px;
  font-weight: 500;
}
._p-qty .value-button {
  display: inline-flex;
  border: 0px solid #ddd;
  margin: 0px;
  width: 30px;
  height: 35px;
  justify-content: center;
  align-items: center;
  background: #2b3643;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  color: #fff;
  cursor:pointer;
}

._p-qty .value-button {
  border: 0px solid #fe0000;
  height: 35px;
  font-size: 20px;
  font-weight: bold;
}
._p-qty input.quantity {
  text-align: center;
  border: none;
  border-top: 1px solid #2b3643;
  border-bottom: 1px solid #2b3643;
  margin: 0px;
  width: 50px;
  height: 35px;
  font-size: 14px;
  box-sizing: border-box;
}
._p-add-cart {
  margin-left: 0px;
  margin-bottom: 15px;
}
.p-list {
  margin-bottom: 10px;
}
._p-features > span {
  display: block;
  font-size: 16px;
  color: #000;
  font-weight: 500;
}
._p-add-cart .buy-btn {
  background-color: #fd7f34;
  color: #fff;
}
._p-add-cart .btn {
  text-transform: capitalize;
  padding: 6px 20px;
  /* width: 200px; */
  border-radius: 52px;
}
._p-add-cart .btn {
  margin: 0px 8px;
}

/*=========Recent-post==========*/
.title_bx h3.title {
  font-size: 22px;
  text-transform: capitalize;
  position: relative;
  color: #fd7f34;
  font-weight: 700;
  line-height: 1.2em;
}
.title_bx h3.title:before {
  content: "";
  height: 2px;
  width: 20%;
  position: absolute;
  left: 0px;
  z-index: 1;
  top: 40px;
  background-color: #fd7f34;
}
.title_bx h3.title:after {
  content: "";
  height: 2px;
  width: 100%;
  position: absolute;
  left: 0px;
  top: 40px;
  background-color: #ffc107;
}
.common_wd .owl-nav .owl-prev,
.common_wd .owl-nav .owl-next {
  background-color: #fd7f34 !important;
  display: block;
  height: 30px;
  width: 30px;
  text-align: center;
  border-radius: 0px !important;
}
.owl-nav .owl-next {
  right: -10px;
}
.owl-nav .owl-prev,
.owl-nav .owl-next {
  top: 50%;
  position: absolute;
}
.common_wd .owl-nav .owl-prev i,
.common_wd .owl-nav .owl-next i {
  color: #fff;
  font-size: 14px !important;
  position: relative;
  top: -1px;
}
.common_wd .owl-nav {
  position: absolute;

  right: 4px;
  width: 65px;
}
.owl-nav .owl-prev i,
.owl-nav .owl-next i {
  left: 0px;
}
._p-qty .decrease_ {
  position: relative;
  right: -5px;
  top: 1px;
}

._p-qty .increase_ {
  position: relative;
  top: 1px;
  left: -5px;
}
/*========box========*/
.sq_box {
  padding-bottom: 5px;
  background-color: #fff;
  text-align: center;
  margin-bottom: 20px;
  border-radius: 4px;
}
.item .sq_box span.wishlist {
  right: 5px !important;
}
.sq_box span.wishlist {
  position: absolute;
  top: 10px;
  right: 20px;
}
.sq_box span {
  font-size: 14px;
  font-weight: 600;
  margin: 0px 10px;
}
.sq_box span.wishlist i {
  color: #adb5bd;
  font-size: 20px;
}
.sq_box h4 {
  font-size: 18px;
  text-align: center;
  font-weight: 500;
  color: #343a40;
  margin-top: 10px;
  margin-bottom: 10px !important;
}
.sq_box .price-box {
  margin-bottom: 15px !important;
}
.sq_box .btn {
  border-radius: 50px;
  padding: 5px 13px;
  font-size: 15px;
  color: #fff;
  background-color: #fd7f34;
  font-weight: 600;
}
.sq_box .price-box span.price {
  text-decoration: line-through;
  color: #6c757d;
}
.sq_box span {
  font-size: 14px;
  font-weight: 600;
  margin: 0px 10px;
}
.sq_box .price-box span.offer-price {
  color: #28a745;
}
.sq_box img {
  object-fit: cover;
  height: 300px !important;
  margin-top: 20px;
}
.sq_box span.wishlist i:hover {
  color: #fd7f34;
}

</style>

