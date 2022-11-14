<?php 	$morefiles = morefiles('project', $pro->id);  ?>

<div class="product-item slider-for-prd aniimated-thumbnials" data-id=<?= $pro->id ?>>


						<a href="assets/uploads/projects/full/<?= $pro->image ?>" data-exthumbimage="assets/uploads/projects/full/<?= $pro->image ?>" class="d-block">
							<div class="product-item-single">
								<div class="prdct-img" style="background-image: url('assets/uploads/projects/full/<?= $pro->image ?>');background-size: cover;
                                        background-position: center">

								</div>
							
								<div class="prdct-info">
									<p class="Louver-Aluminum-Stru text-uppercase"><?= $pro->title ?></p>
									<div class="Retractable-Motorize"><?= $pro->body ?></div>

								</div>
							</div>
						</a>



						<?php foreach ($morefiles as $morefile) { ?>

							<a href="assets/uploads/projects/<?= $morefile->filename ?>" data-exthumbimage="assets/uploads/projects/<?= $morefile->filename ?>" class="d-none">
								<div class="product-item-single">
									<div class="prdct-img" style="background-image: url('assets/uploads/projects/<?= $morefile->filename ?>');background-size: cover;
                                            background-position: center">
									</div>
									<div class="prdct-info">
										<p class="Louver-Aluminum-Stru text-uppercase"><?= $pro->title ?></p>
										<div class="Retractable-Motorize"><?= $pro->body ?></div>
									</div>
								</div>
							</a>

						<?php } ?>

					</div>