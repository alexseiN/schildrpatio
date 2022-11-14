<?php
    $result_data = isset($id)?$thisItems[0]:$thisItems;
    $counter = 0;
    $checkboxarray = array("top_left"=>"Top Left","top_right"=>"Top Right","middle_left"=>"Middle Left","middle_right"=>"Middle Right","footer_a"=>"Footer Left","footer_b"=>"Footer Right");
    error_reporting(0);
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
                        $img = ($result_data->image == '')?$noimage:base_url($uploadFolder.'/small/'.$result_data->image);
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
                                $options = [];                                  
                                $data = [
                                    "label"          => "Template",
                                    "label_required" => "",
                                    "type"           => "select",
                                    "type_data"      => [
                                        'name'  => 'template',
                                        'options'  => $templates_page,
                                        'value' => $result_data->template,
                                    ]
                                ];
                                echo html_form_tags($data);
                            ?>
                            </div>
                            <!--end::Input group-->
                            <?php foreach($checkboxarray as $key=>$value) { ?>
                            <!--begin::Input group-->
                                <div class="mb-10 fv-row form-check form-check-custom form-check-solid mb-2">
                                    <?php
                                        $data = [
                                            "label"          => $value,
                                            "label_required" => "",
                                            "labelclass"     => "form-check-label mx-2",
                                            "type"           => "checkbox",
                                            "type_data"      => [
                                                'name'       => $key,
                                                'class'      => 'form-check-input',
                                                'style'      => 'margin:10px',
                                                'value'      => 1,
                                                'checked'    => ($result_data->{$key})?true:false,
                                            ]
                                        ];
                                        echo html_form_tags($data);
                                    ?>
                                </div>
                            <!--end::Input group-->
                            <?php } ?>
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::General options-->
                    <div>
                    <!--begin:::Tabs-->
                    <?=view('admin/includes/common/langstab')?>
                    
                    <!--end:::Tabs-->
                    <div class="tab-content">
                        <?php
                            $counter_1_check = 1;
                            foreach($ThisModule->languages as $key_lang=>$val_lang) {
                            $language_data = get_admin_conn_lang($_lang_table_names,$id,$key_lang);
                            //pp($language_data,false);
                        ?>
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade <?=($counter_1_check == 1)?'active show':''?>" id="tab_<?=$counter_1_check?>" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <!--begin::General options-->
                                <div class="card card-flush  rounded-0 py-4">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-5">
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <?php                                                                           
                                                $data = [
                                                    "label"          => "Title",
                                                    "label_required" => "",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'name'  => 'title_'.$key_lang,
                                                        'id'    => '',
                                                        'value' => trim($language_data->title),
                                                        'onkeyup' => 'return slugme(this)',
                                                        'data-key' => $key_lang
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
                                                    "label"          => "Slug",
                                                    "label_required" => "",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'name'  => 'slug_'.$key_lang,
                                                        'id'    => 'inputSlug_'.$key_lang,
                                                        'value' => $language_data->slug,
                                                    ]
                                                ];
                                                echo html_form_tags($data);                                                
                                            ?>
                                        </div>
                                        <!--end::Input group-->                                      
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row" id="quillarea_<?=$counter_1_check?>">
                                            <?php                                                                           
                                                $data = [
                                                    "label"          => "Description",
                                                    "label_required" => "",
                                                    "type"           => "textarea",
                                                    "type_data"      => [
                                                        'name'  => 'body_'.$key_lang,
                                                        'id'    => 'form_editor_'.$counter_1_check,
                                                        'value' => $language_data->body,
                                                        'class' => 'form-control form-control-solid form_editor form_editor_'.$counter_1_check,
                                                        'rows'  => '4',
                                                        'data-counter'  => $counter_1_check
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
                                                    "label"          => "Meta keyword",
                                                    "label_required" => "",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'name'  => 'meta_keyword_'.$key_lang,
                                                        'id'    => '',
                                                        'value' => trim($language_data->meta_keyword),
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
                                                    "label"          => "Meta Description",
                                                    "label_required" => "",
                                                    "type"           => "textarea",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'name'  => 'meta_desc_'.$key_lang,
                                                        'id'    => '',
                                                        'value' => trim($language_data->meta_desc),
                                                    ]
                                                ];
                                                echo html_form_tags($data);
                                            ?>
                                        </div>
                                        <!--end::Input group-->                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $counter_1_check++;} ?>
                    </div>    
                    </div>
                    <?=view('admin/includes/common/button')?>
                </div>
                <!--end::Main column-->                
            <?=form_close()?>
            <?=view('admin/includes/common/media')?>
            <!--end::Form-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>

<script>
    tagfunction();
    quillfunction();
    function slugme(selfvar){
         var text = $(selfvar).val();
         var key = $(selfvar).attr('data-key');
         $.ajax({
            type:"POST",
            url:"<?=$_cancel.'/slugifier'?>",
            data:{text:text},
            success:function(data){
                $('#inputSlug_'+key).val(data);
            }
        });
    }
</script>