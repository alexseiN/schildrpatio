<div class="card card-flush py-4 pb-0">
	<div class="card-body pb-0 pt-0">
		<div class="mb-10 fv-row">
			<?php
				$options = [
					'video'  => 'Video',
					'pdf'  => 'PDF',
					'external'  => 'External'
				];
				$data = [
					"label"          => "File Type",
					"label_required" => "",
					"type"           => "select",
					"type_data"      => [
						'name'  => 'filetype_'.$id,
						'options'  => $options,
						'value' => $files->filetype,
					]
				];
				echo html_form_tags($data);
			?>
		</div>
		<div class="mb-10 fv-row" style="border: 1px dashed #009ef7;padding: 1.5rem 1.75rem;">
			<!--begin::Dropzone-->
			<div class="dropzone dropzone-queue mb-2" id="kt_modal_upload_dropzone_<?=$id?>">
				<!--begin::Controls-->
				<div class="dropzone-panel mb-4">
					<a class="dropzone-select btn btn-sm btn-primary me-2"><i class="fas fa-file-upload"></i> Upload file</a>
					<a class="dropzone-upload btn btn-sm btn-light-primary me-2">Upload All</a>
					<a class="dropzone-remove-all btn btn-sm btn-light-primary">Remove</a>
				</div>
				<!--end::Controls-->
				<!--begin::Items-->
				<div class="dropzone-items wm-200px">
					<div class="dropzone-item p-5">
						<!--begin::File-->
						<div class="dropzone-file">
							<div class="dropzone-filename text-dark" title="some_image_file_name.jpg">
								<span data-dz-name="">some_image_file_name.jpg</span>
								<strong>(
								<span data-dz-size="">340kb</span>)</strong>
							</div>
							<div class="dropzone-error mt-0" data-dz-errormessage=""></div>
						</div>
						<!--end::File-->
						<!--begin::Progress-->
						<div class="dropzone-progress">
							<div class="progress bg-light-primary">
								<div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress=""></div>
							</div>
						</div>
						<!--end::Progress-->
						<!--begin::Toolbar-->
						<div class="dropzone-toolbar">
							<span class="dropzone-start">
								<i class="bi bi-play-fill fs-3"></i>
							</span>
							<span class="dropzone-cancel" data-dz-remove="" style="display: none;">
								<i class="bi bi-x fs-3"></i>
							</span>
							<span class="dropzone-delete" data-dz-remove="">
								<i class="bi bi-x fs-1"></i>
							</span>
						</div>
						<!--end::Toolbar-->
					</div>
				</div>
				<!--end::Items-->
			</div>
			<!--end::Dropzone-->
			<?php                               
				$data = [
					"label"          => "",
					"label_required" => "",
					"type"           => "input",
					"type_data"      => [
						'type'  => 'hidden',
						'name'  => 'filename',
						'id' 	=> 'filename_'.$id,
						'value' => $files->filename,
					]
				];
				echo html_form_tags($data);
			?>
		</div>
		<div class="mb-10 fv-row">
			<?php                               
			$data = [
				"label"          => "Link",
				"label_required" => "",
				"type"           => "input",
				"type_data"      => [
					'type'  => 'text',
					'name'  => 'link',
					'id' 	=> 'link_'.$id,
					'value' => $files->link,
				]
			];
			echo html_form_tags($data);
			?>
		</div>
		<div class="mb-10 fv-row">
			<?php                               
			$data = [
				"label"          => "Description",
				"label_required" => "",
				"type"           => "input",
				"type_data"      => [
					'type'  => 'text',
					'name'  => 'description',
					'id' 	=> 'description_'.$id,
					'value' => $files->description,
				]
			];
			echo html_form_tags($data);
			?>
		</div>
	</div>
	<!--begin:::Tabs-->
</div>
<div class="card card-flush py-4 pt-0"  style="box-shadow: none;">
	<div class="card-body  pb-0 pt-5">
		<ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2">
			<?php $counter_check = 1;foreach($alllangs as $key_lang=>$val_lang) { ?>
			<!--begin:::Tab item-->
			<li class="nav-item">
				<a class="nav-link text-active-primary pb-4 <?=($counter_check == 1)?'active':''?>" data-bs-toggle="tab" href="#tabmodal_<?=$counter_check?>">
					<img src="<?php echo base_url('assets/uploads/language/full').'/'.$val_lang->image; ?>" title="<?=$val_lang->language?>" height="15" width="20" >
				</a>
			</li>
			<!--end:::Tab item-->
			<?php $counter_check++;} ?>
		</ul>
		<!--end:::Tabs-->
		<div class="tab-content pt-5">
			<?php
				$counter_1_check = 1;
				foreach($alllangs as $val_lang) {
					$language_data = get_admin_conn_lang($files_lang,$id,$val_lang->id);
					$title = isset($language_data->title)?$language_data->title:'';
					$body = isset($language_data->body)?$language_data->body:'';
			?>
			<!--begin::Tab pane-->
			<div class="tab-pane fade <?=($counter_1_check == 1)?'active show':''?>" id="tabmodal_<?=$counter_1_check?>" role="tab-panel">
				<div class="d-flex flex-column gap-7 gap-lg-10">
					<!--begin::General options-->
					<div class="card card-flush py-4" style="box-shadow: none;">
						<!--begin::Card body-->
						<div class="card-body px-0 pt-5 pb-0">
							<!--begin::Input group-->
							<div class="mb-10 fv-row">
								<?php                                                                           
									$data = [
										"label"          => "Title",
										"label_required" => "",
										"type"           => "input",
										"type_data"      => [
											'type'  => 'text',
											'name'  => 'modal_title_'.$val_lang->id,
											'id'    => 'modal_title_'.$val_lang->id,
											'value' => trim($title),
										]
									];
									echo html_form_tags($data);
								?>
							</div>
							<!--begin::Input group-->
							<div class="mb-10 fv-row" id="quillarea_modal_<?=$counter_1_check?>">
								<?php                                                                           
									$data = [
										"label"          => "Description",
										"label_required" => "",
										"type"           => "textarea",
										"type_data"      => [
											'name'  => 'modal_body_'.$val_lang->id,
											'id'    => 'form_editor_modal_'.$counter_1_check,
											'value' => $body,
											'class' => 'form-control form-control-solid form_editor form_editor_modal_'.$counter_1_check,
											'rows'  => '4',
											'data-counter'  => "modal_".$counter_1_check
										]
									];
									echo html_form_tags($data);
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $counter_1_check++;} ?>
		</div>						
	</div>
</div>
<div class="d-flex justify-content-end">
	<a href="javascript:" data-bs-dismiss="modal" class="btn btn-light me-5">Cancel</a>
	<button type="button" id="kt_modal_submit" onclick="return link_image('<?=$id?>')" class="btn btn-primary">Save Changes</button>
</div>
<?=form_open_multipart('', 'id="mediaeditformsubmit" name="mediaeditformsubmit"')?>
<?=form_close()?>

<script>

	function link_image(id) {

		var description = $('#description_' + id).val();
		var filetype = $("select[name='filetype_"+id+"']").val();
		var pdfname = $('#filename_' + id).val();
		var form = $('#mediaeditformsubmit')[0];
		var datapost = new FormData(form);
		datapost.append("filetype", filetype);
		datapost.append("description", description);
		datapost.append("id", id);
		datapost.append("mainid", '<?=$mainid?>');
		datapost.append("pdfname", pdfname);
		<?php foreach($alllangs as $val_lang) { ?>
		datapost.append("title_<?=$val_lang->id?>",$("input[name='modal_title_<?=$val_lang->id?>']").val());
		datapost.append("body_<?=$val_lang->id?>", $("textarea[name='modal_body_<?=$val_lang->id?>']").val());
		<?php } ?>

		$.ajax({
            type: "POST",
            url: "<?=$_cancel.'/linkmedia'?>",
            data: datapost,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (res) {
				const respo = JSON.parse(res);
				if(respo.status == 'success') {
					$("#editmediaformmodal").modal('hide');
					alertmodal("success","Successfully done.")
				}
				else {
					alertmodal("error","Something not right, please try again.")
				} 
            },
            error: function (e) {
				console.log("ERROR : ", e);
            }
        });
	}
	
	var addtionalparam = '<?=$id?>';
	var maine = "#kt_modal_upload_dropzone_"+addtionalparam;
	var maint = document.querySelector(maine);
	var maino = maint.querySelector(".dropzone-item");
    maino.id = "";
    var mainn = maino.parentNode.innerHTML;
    maino.parentNode.removeChild(maino);
    
    
    var r = new Dropzone("#kt_modal_upload_dropzone_"+addtionalparam, {
        url: "<?=$_cancel.'/mediafiles'?>",
        uploadMultiple: false,
		previewTemplate: mainn,
		maxFilesize: 1,
		autoProcessQueue: true,
		autoQueue: true,
		previewsContainer: maine + " .dropzone-items",
		clickable: maine + " .dropzone-select",
		paramName: "file",
		init: function() {
			dzClosure = this;
			this.hiddenFileInput.removeAttribute('multiple');
			this.on("sending", function(file, xhr, formData){
				formData.append("id",addtionalparam);
			});
			<?php if($files->pdfname != ''){ $filename = $uploadFolder.'/'.$files->pdfname;$size = filesize($filename); ?>
				var mockFile = {name: '<?=$files->pdfname?>',size: <?=$size?>};
				dzClosure.emit("addedfile", mockFile);	    
				const main_o = maint.querySelectorAll(".dropzone-item");
				setTimeout((function() {
				$(".dropzone-item").addClass('dz-processing dz-image-preview dz-success dz-complete');
						maint.querySelector(".dropzone-remove-all").style.display = "inline-block";
						main_o.forEach((e => {
							e.querySelector(".progress-bar").style.opacity = "0", e.querySelector(".progress").style.opacity = "0", 	e.querySelector(".dropzone-start").style.opacity = "0"
						}))
				}), 300);
			<?php } ?>
			
		}
    });
    r.on("addedfile", (function(o) {
		if (r.files.length > 1) {
			r.removeFile(r.files[0]);
		}
		o.previewElement.querySelector(maine + " .dropzone-start").onclick = function() {
			const main_e = o.previewElement.querySelector(".progress-bar");
			main_e.style.opacity = "1";
			var t = 1,
				n = setInterval((function() {
					t >= 100 ? (r.emit("success", o), r.emit("complete", o), clearInterval(n)) : (t++, main_e.style.width = t + "%")
				}), 20)
		}, maint.querySelectorAll(".dropzone-item").forEach((e => {
			e.style.display = ""
		})), maint.querySelector(".dropzone-remove-all").style.display = "inline-block";   
    })), r.on("complete", (function(e) {
	    const main__o = maint.querySelectorAll(".dz-complete");
	    setTimeout((function() {
		    main__o.forEach((e => {
			    e.querySelector(".progress-bar").style.opacity = "0", e.querySelector(".progress").style.opacity = "0", e.querySelector(".dropzone-start").style.opacity = "0"
		    }))
	    }), 300)
    })),maint.querySelector(".dropzone-remove-all").addEventListener("click", (function() {
	    Swal.fire({
		    text: "Are you sure you would like to remove all files?",
		    icon: "warning",
		    showCancelButton: !0,
		    buttonsStyling: !1,
		    confirmButtonText: "Yes, remove it!",
		    cancelButtonText: "No, return",
		    customClass: {
			    confirmButton: "btn btn-primary",
			    cancelButton: "btn btn-active-light"
		    }
	    }).then((function(e) {
		    e.value ? (maint.querySelector(".dropzone-upload").style.display = "none", maint.querySelector(".dropzone-remove-all").style.display = "none", r.removeAllFiles(true),$("#kt_modal_upload_dropzone_"+addtionalparam+" .dropzone-items").find('div.dropzone-item').remove()) :"";
	    }))
    })), r.on("queuecomplete", (function(e,response) {
	    maint.querySelectorAll(".dropzone-upload").forEach((e => {
		    e.style.display = "none"
		    
	    }));		
    })), r.on("success", (function(file,response) {
		const obj = JSON.parse(response);
		if($("#kt_modal_upload_dropzone_"+addtionalparam+" .dropzone-items").children().length > 1 ){
			$("#kt_modal_upload_dropzone_"+addtionalparam+" .dropzone-items").find('div.dropzone-item').first().remove();
		}
		$("#files_name").val(obj.target_file);
		$('#link_'+addtionalparam).val("<?=$uploadFolder?>/"+obj.target_file);		
		
		
    })), r.on("removedfile", (function(e) {
		r.files.length < 1 && (maint.querySelector(".dropzone-upload").style.display = "none", maint.querySelector(".dropzone-remove-all").style.display = "none")

		$("#files_name").val('');
		$('#link_'+addtionalparam).val('');
    }));
</script>