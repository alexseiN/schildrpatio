<?php
	foreach ($thisItems as $item) {
		$category = get_langer('loccats',$admin_lang,$item->id);
		$morefiles = morefiles('locproducts',$item->id);
		$file = $morefiles[0];
		$sizeavail = explode(",",$item->size);
		$colorsavail = explode(",",$item->colors);
		$total_variant = 0;
		if($sizeavail[0] != ''){
			$total_variant++;
		}
		if($colorsavail[0] != ''){
			$total_variant++;
		}

		//pp($item,false);
		$url = $_product_view.'/'.$item->id;
		$body = readmorestring($item->body,$url,60);
		
?>

<div class="col-md-4">
	<div class="card-xl-stretch me-md-6">
		<a class="d-block border border-dashed" data-fslightbox="lightbox-hot-sales" href="<?=$url?>">
			<div class="carousel slide" data-bs-ride="carousel" id="carousel-<?=$item->id?>">
				<div class="carousel-inner">
					<?php  $counter = 1; foreach($morefiles as $file) { ?>
						<div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-200px carousel-item <?=($counter == 1)?"active":""?>" style="background-image:url('assets/uploads/locproducts/<?=$file->filename?>')"></div>
					<?php $counter++;} ?>
				</div>
			</div>
		</a>
		<div class="mt-5">
			<a href="<?=$_product_view.'/'.$item->id?>" class="fs-5 fw-bolder text-dark text-hover-primary lh-base"><?=$item->title?></a>
			<div class="fw-bold fs-6 text-gray-600 text-muted mt-3">
				<?=$body?>
			</div>
			<div class="fs-6 fw-bolder mt-3 d-flex flex-stack">
				<span class="badge border border-dashed fs-2 fw-bolder text-dark p-2">
				<span class="fs-6 fw-bold text-gray-400">$</span><?=($item->nprice>0)?$item->nprice:0?></span>
				<?php /*if($item->nprice > 0) { ?>
				<!--<a href="javascript:" title="Add to Cart" data-total-varient="<?=$total_variant?>" data-loading-text="Loading..." class="select-options btn btn-sm btn-primary" onclick="cart.add(this);" data-original-title="Add to Cart" value="Add to Cart" data-product-price="<?=$item->nprice?>" data-product-id="<?=$item->id?>" >
					<i class="fa fa-shopping-cart"></i> Add to cart
				</a>-->
				<?php } */ ?>
				<a href="<?=$url?>" class="btn btn-sm btn-primary">
					<i class="fa fa-eye"></i> View
				</a>
			</div>
		</div>
	</div>
</div>
<?php } ?>
