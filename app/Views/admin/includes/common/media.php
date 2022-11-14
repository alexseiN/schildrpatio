<div class="d-flex mt-10 flex-column flex-row-fluid">
	<!--begin::Media-->
	<div class="card card-flush py-4">
		<!--begin::Card header-->
		<div class="card-header">
			<div class="card-title">
				<h2>Files</h2>
			</div>
		</div>
		<!--end::Card header-->
		<?php if($id != ''){?>
		<!--begin::Card body-->
		<div class="card-body pt-0">
			<!--begin::Input group-->
			<div class="fv-row mb-2">
				<!--begin::Dropzone-->
				<div class="dropzone" id="myDropzone">
					<!--begin::Message-->
					<div class="dz-message needsclick">
						<!--begin::Icon-->
						<i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
						<!--end::Icon-->
						<!--begin::Info-->
						<div class="ms-4">
							<h3 class="fs-5 fw-bolder text-gray-900 mb-1">Drop files here or click to upload.</h3>
							<span class="fs-7 fw-bold text-gray-400">Upload up to 10 files</span>
						</div>
						<!--end::Info-->
					</div>
				</div>
				<!--end::Dropzone-->
			</div>
			<!--end::Input group-->
			<!--begin::Description-->
			<div class="text-muted fs-7">Set the media gallery.</div>
			<!--end::Description-->
		</div>
		<div class="card-body pt-0 files files-list ui-sortable" ui-sortable="sortableOptions" ng-model="leftArray"  id="previewimages">
		</div>
		<!--end::Card header-->
		<?php } else { ?>
			<div class="card-body pt-0">
				<!--begin::Description-->
				<div class="text-muted fs-8">Please <?=$title?> first to add files.</div>
				<!--end::Description-->
			</div>
		<?php } ?>
	</div>
	<!--end::Media-->
</div>
<?=view('admin/includes/common/mediamodal')?>
<?php if($id != ''){?>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>  
    function saveFilesOrder(event, ui){
	var filesOrder = filesOrderToArray($(this));
	$.get("<?=$_cancel.'/fileOrder' ?>", {'order': filesOrder,connfile_id: '<?=$id?>'},function(data) {}, "json");
    }
    function filesOrderToArray(container) {
	var data = {};
	i = 0;
	container.find('div.moredivimages').each(function(i) {
	    var filename = $(this).attr('data-id');
	    data[i + 1] = filename;
	});
	return data;
    }
    
    var addtionalparam = '<?=$id?>';
    var myDropzone = new Dropzone("#myDropzone", {
        url: "<?=$_cancel.'/uploadmedia'?>",
        uploadMultiple: true,
        maxFiles: 10,
        maxFilesize: 1,
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        paramName: "file",
        init: function() {
            dzClosure = this;
            this.on("sending", function(file, xhr, formData){
                formData.append("id",addtionalparam);
            });			
        }
    });
    myDropzone.on("removedfile", function(file){
        //console.log(file);
    });
    myDropzone.on("queuecomplete", function(file){
		runmediafunction();
		myDropzone.removeAllFiles( true );		
    });
    function runmediafunction(){
	$.getJSON("<?=$_cancel.'/chekmorefiles/'.$id?>", function(data) {
		if(data.status == 'success'){
			$('#previewimages').html(data.html);
			$(".files-list").sortable({
			    update: saveFilesOrder
			});
		}
	});
    }
    runmediafunction();

    $(document).on("click",".editmediaform", function(){
	var ID = $(this).attr('data-id');
	$.ajax({
	    type: "POST",
	    url: "<?=$_cancel.'/getmediadata'?>",
	    data: {
		ID: ID,mainid:addtionalparam
	    },
	    success: function(data) {
		const res = JSON.parse(data);
		if(res.status == 'success'){
		    $("#editmediaformmodal .modal-body").html(res.html);
		    $("#editmediaformmodal").modal('show');
		}
		else {
		    alertmodal("error","Something not right, please try again.")
		}
	    }
	});
    });

    $(document).on("click",".deletemediaform", function(){
	var ID = $(this).attr('data-id');
	Swal.fire({
	  title: 'Are you sure?',
	  text: "You won't be able to revert this!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
		if (result.isConfirmed) {
			delete_image(ID);
		}
	});
    });
    function delete_image(id) {
	$.ajax({
	    type: "POST",
	    url: "<?=$_cancel.'/deleteImage'?>",
	    data: {
		id: id,
	    },
	    success: function(data) {
		$('#more_image_'+ id).hide();
	    }
	});
    }
</script>
<?php } ?>