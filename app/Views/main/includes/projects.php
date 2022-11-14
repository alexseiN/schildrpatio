<div class="container-fluid main_center">
	<!--div class="title">
                <div class="inner_main_center mt-0 mb-0">
                    <div class=" oddd_item d-flex flex-row">
                        <div class=" main_center d-flex flex-column aligin-items-start">
                            <div class="Path-3-Copy-36"></div>
                            <div class="Enjoy-div">
                                <p class="Enjoy-the-serenity-Copy">Enjoy the serenity, energy, and beauty of nature 365 days a year no matter what climate you live in.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div-->
	<div class="title">
		<div class="page_title_prd">
            <a href="<?=$curlangcode?>/projects">
			<div class=" text-uppercase">
				<h2 class="text-uppercase"><?= static_area($curlangid, 'our_projects'); ?></h2> 
			</div>
            </a>
		</div>
	</div>
	<!--Product-->
	<div class="project">
		<div class="products ">

			<div class="contain-group prod-container ">

				<?php 
				foreach ($projects as $pro) {
					$morefiles = morefiles('project', $pro->id); 

					$this->data['pro'] = $pro;
					
					echo view('/main/common/pritem',$this->data);


				} ?>

			</div>
		</div>
	</div>
</div>
<a href="<?=$curlangcode?>/projects">
	<div class="contener" style="margin-top: 0px;margin-right: auto;margin-left: auto;">
		<div class="txt_button text-uppercase"><?=static_area($curlangid,'allprojects');?></div>
		<div class="circle">&nbsp;</div>
	</div>
</a>
<div class="container-fluid main_center">
	<div class="title">
		<div class="inquire">

			<div class="inquire-hr" style="bottom: 0"></div>
		</div>
	</div>
</div>