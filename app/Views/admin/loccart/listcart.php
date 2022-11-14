<?php if(count($cartitems)>0) { ?>
	<div class="table-responsive">
		<table class="table table-rounded table-striped border gy-7 gs-7">
			<thead>
				<tr class="fw-bolder fs-6 border-bottom text-gray-800">
					<td class="text-center">Image</td>
					<td class="text-left">Product Name</td>
					<td class="text-left">Quantity</td>
					<td class="text-end">Unit Price</td>
					<td class="text-end">Total</td>
				</tr>
			</thead>
			<tbody id="cartitems">
				<?php
					$totalamounttoshow = 0;
					foreach($cartitems as $key=>$cartitem) {
						$cartkeyexplode = explode("_",$key);

						$product_id = $cartkeyexplode[1];
						$size_id = $cartkeyexplode[4];
						$color_id = $cartkeyexplode[7];
						
						
						$totalamount = round(($cartitem['quantity'])*($cartitem['price']),2);
						$decimaltotal = $cartitem['quantity']*$cartitem['price'];
						$availquantityresult = getDatam2('locproducts',array("id"=>$product_id),$admin_lang,false,'id',false);
						$quntity_choose = $availquantityresult[0]->count;
						$totalamounttoshow += $totalamount;
						
				?>
				<tr id="cartrow_<?=$key?>">
					<td class="text-center">
						<img width="70px" src="assets/uploads/locproducts/<?=$cartitem['image']?>" alt="<?=$cartitem['name']?>" title="<?=$cartitem['name']?>" class="img-thumbnail">
					</td>
					<td class="text-left">
						<a href="<?=$_product_view.'/'.$product_id?>" class="fs-7 fw-bolder text-dark text-hover-primary lh-base"><?=$cartitem['name']?></a>
						<input type="hidden" name="product_name[]" value="<?=$cartitem['name']?>">
						<input type="hidden" name="size_id[]" value="<?=$size_id?>">
						<input type="hidden" name="color_id[]" value="<?=$color_id?>">
						<input type="hidden" name="product_id[]" value="<?=$product_id?>">		
					</td>
					<td class="text-left" width="200px">
						<div class="input-group btn-block quantity">
							<input type="text" name="quantity[]" id="updatequantity" value="<?=$cartitem['quantity']?>" size="1" class="form-control  me-2 updatequantity_<?=$key?>" style="border-radius: 5px; max-height: 35px; text-align: center;">
							<span class="input-group-btn">
							<a href="javascript:" data-toggle="tooltip" data-product-id="<?=$product_id?>" data-size-id="<?=$size_id?>"  data-color-id="<?=$color_id?>" data-id="<?=$key?>" data-unit-amount="<?=$cartitem['price']?>" data-avail-count="<?=$quntity_choose?>" title="Update Quantity" class="btn btn-icon btn-primary btn-sm me-1" onclick="cart.update(this,'<?=$key?>')" data-original-title="Update"><i class="fa fa-clone"></i></a>
							<a href="javascript:" data-toggle="tooltip" title="Remove product" class="btn btn-icon btn-danger btn-sm" onclick="cart.remove('cartpage','<?=$key?>')" data-original-title="Remove"><i class="fa fa-trash"></i></a>
							</span>
						</div>
					</td>

					<td class="text-end unit_amount_<?=$key?>"><?=front_format_currency_helper($cartitem['price'])?></td>
					<td class="text-end total_amount_<?=$key?>" ><?=front_format_currency_helper($totalamount)?></td>
				</tr>
				<?php
						$totalamount = front_format_currency_helper($totalamounttoshow);
						$tax = 0;
						$totalwithtax = front_format_currency_helper(($totalamounttoshow-$tax));
					}
				?>
				<tr class="border-top">
					<th align="right" class="fw-bolder fs-5 text-gray-800 text-end" colspan="4">Sub-Total</th>
					<td class="text-end" id="totalamount"><?=$totalamount?></td>
				</tr>
				<tr>
					<th align="right" class="fw-bolder fs-5 text-gray-800 text-end" colspan="4">VAT</th>
					<td class="text-end" id="taxtotal"><?=front_format_currency_helper($tax)?></td>
				</tr>
				<tr>
					<th colspan="4" class="fw-bolder fs-5 text-end text-gray-800 text-end" align="right">Total</th>
					<td class="text-end" id="totalwithtax"><?=$totalwithtax?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php } else { ?>
		<p>No data found.</p>
	<?php } ?>
<?=view('main/common/addtocart')?>
