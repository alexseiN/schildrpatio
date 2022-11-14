<?php
    $result_data = isset($id)?$thisItems[0]:$thisItems;
    $counter = 0;
    
?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Form-->
            <?=view('admin/includes/common/errors')?>
            <?=form_open_multipart('', 'class="form d-flex flex-column flex-lg-row editform" id="editform" name="editform"')?>
                <!--begin::Aside column-->
                <div class="d-flex flex-column gap-7 gap-lg-10 w-300px w-lg-300px mb-7 me-lg-10">
                    <?php
                        $img = !isset($result_data->image)?$noimage:base_url($uploadFolder.'/small/'.$result_data->image);
                        $imagedata = [
                            "label" => 'Main Image',
                            "noimage" => $noimage,
                            "image" => $img,
                            "name" => 'image',
                            "value" => $result_data->image,
                            "description" => 'Allowed file types: png, jpg, jpeg.'
                        ];
                        echo view('admin/includes/common/image',$imagedata);
                        //pp($imagedata);
                    ?>
                </div>
                <!--end::Aside column-->
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>General</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <?php                               
                                    $data = [
                                        "label"          => "Language",
                                        "label_required" => "required",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'language',
                                            'id'    => '',
                                            'value' => $result_data->language,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <?php                               
                                    $data = [
                                        "label"          => "Code",
                                        "label_required" => "required",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'code',
                                            'id'    => '',
                                            'value' => $result_data->code,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            
                            <hr>
                            
                            <div class="d-flex">
                            	<button type="submit" id="kt_submit" class="btn btn-danger" onclick="update_lang(<?=$result_data->id?>)">Update</button>
                            </div>
                            
                            <hr>
                            
                            
                            <div class="d-flex flex-wrap gap-5">
                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                                    <div class="form-check form-check-custom form-check-solid mb-2">
                                        <?php                               
                                            $data = [
                                                "label"          => "Default",
                                                "label_required" => "",
                                                "labelclass"     => "form-check-label mx-2",
                                                "type"           => "checkbox",
                                                "type_data"      => [
                                                    'name'       => 'default',
                                                    'class'      => 'form-check-input',
                                                    'value'      => 1,
                                                    'checked'    => ($result_data->default)?true:false,
                                                    'style'      => 'margin:10px'
                                                ]
                                            ];
                                            echo html_form_tags($data);
                                        ?>
                                    </div>                                    
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <div class="form-check form-check-custom form-check-solid mb-2">
                                        <?php                               
                                            $data = [
                                                "label"          => "Enabled",
                                                "label_required" => "",
                                                "labelclass"     => "form-check-label mx-2",
                                                "type"           => "checkbox",
                                                "type_data"      => [
                                                    'name'       => 'enabled',
                                                    'class'      => 'form-check-input',
                                                    'value'      => 1,
                                                    'checked'    => ($result_data->enabled)?true:false,
                                                    'style'      => 'margin:10px'
                                                ]
                                            ];
                                            echo html_form_tags($data);
                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::General options-->
                    <?=view('admin/includes/common/button')?>
                </div>
                <!--end::Main column-->
            <?=form_close()?>
            <!--end::Form-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<script>
    
     
        
function update_lang(id){
    
        
	$.ajax({
		type: "POST",
		url: "<?=$_cancel?>/updateLang", /* The country id will be sent to this file */
		data: {id:id},
		
		success: function(data){
			
			  	//alert(data);
			
		}
	});
}
        
</script>