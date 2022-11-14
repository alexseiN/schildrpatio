<div class="flex-lg-row-fluid <?=(!$is_view)?'ms-lg-7 ms-xl-10':''?>">
	<!--begin::Messenger-->
	<div class="card" id="chatbody">
		<!--begin::Card header-->
		<div class="card-header" id="kt_chat_messenger_header">
			<!--begin::Title-->
			<div class="card-title">
				<!--begin::User-->
				<div class="d-flex justify-content-center flex-column me-3">
					<span class="caption-subject fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1"><?=$cname?></span>
				</div>
				<!--end::User-->
			</div>
			<!--end::Title-->
			<!--begin::Card toolbar-->
			<div class="card-toolbar">
				<!--begin::Menu-->
				<div class="me-n3 actions position-relative">
					<input type="text" class="form-control input-circle form-control-solid pe-15 iconsubmittext" name="search" value="" placeholder="Search messages" id="searchwindow">
					<span class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 me-5 translate-middle-y" style="right:0;cursor:pointer;">
						<i class="fa fa-search submitsearch iconsubmit"></i>
					</span>
				</div>
				<!--end::Menu-->
			</div>
			<!--end::Card toolbar-->
		</div>
		<!--end::Card header-->
		<!--begin::Card body-->
		<?php if($is_view) { ?>
			<input type="hidden" id="loadedchat" value="<?=$receiver_id?>"/>
			<input type="hidden" id="loadedchattype" value="visitor"/>
		<?php } else { ?>
			<input type="hidden" id="loadedchat" value="Groupchat"/>
			<input type="hidden" id="loadedchattype" value="adminlocal"/>
		<?php } ?>
		<div class="card-body" id="chats">
			<!--begin::Messages-->
			<div class="slimScrollDiv scroll-y me-n5 pe-5 h-596px h-lg-auto" id="chatbox" style="max-height:596px;">
				<?php if(count($chat_data_array)>0){ $sentdata['chat_data_array'] = $chat_data_array;?>
					<?=view('admin/includes/common/chatbodyinner',$sentdata)?>
				<?php } ?>
			</div>
		</div>
		<!--end::Card body-->
		<?php if(!$is_view) { ?>
		<p id="typingshow" style="margin:0;    min-height: 20px;">&nbsp;</p>	
		<!--begin::Card footer-->
		<div class="card-footer p-0" id="kt_chat_messenger_footer">

			<div class="input-group">
				<input class="form-control py-7 form-control-flush" style="resize:none;" rows="1" data-kt-element="input" id="contentmsg" placeholder="Type a message here..." aria-label="chatsubmit"/>
				<button class="btn btn-primary input-group-text" id="submitmsg" type="button" data-kt-element="send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
				
			</div>

		</div>
		<!--end::Card footer-->
		<?php } ?>
	</div>
	<!--end::Messenger-->
</div>