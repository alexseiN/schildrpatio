<?php
	foreach($chat_data_array as $chat){ if(trim($chat['body']) != '') {  ?>

<div class="d-flex <?=$chat['addclass']?> mb-10 chatsline" data-id="<?=$chat['id']?>" data-user="<?=$chat['data-user']?>" >

	<div class="d-flex flex-column <?=($chat['addclass'] == 'justify-content-start')?'align-items-start':'align-items-end'?>">

		<div class="d-flex align-items-center mb-2">

			<div class="symbol symbol-35px symbol-circle">
				<?=$chat['image']?>
			</div>

			<div class="ms-3">
				<span class="fs-6 fw-bolder text-gray-900 text-hover-primary me-1"><?=$chat['showusername']?></span>
				<span class="text-muted fs-7 mb-1 datetime timeago" data-livestamp="<?=$chat['time']?>">&nbsp;</span>
			</div>

		</div>

		<div class="p-3 fs-7 rounded <?=($chat['addclass'] == 'justify-content-start')?'bg-light-info text-start':'bg-light-primary text-start'?> text-dark fw-bold mw-lg-400px " data-kt-element="message-text"><?=$chat['body']?></div>

	</div>

</div>

<?php }  } ?>