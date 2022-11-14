<?php
    $result_data = isset($id)?$thisItems[0]:$thisItems;
    $counter = 0;
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
                                        "label"          => "Price",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'nprice',
                                            'id'    => '',
                                            'value' => trim($result_data->nprice),
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group--><!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <?php                                                                           
                                    $data = [
                                        "label"          => "Unit/Boy",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'unitboy',
                                            'id'    => '',
                                            'value' => trim($result_data->unitboy),
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <div class="mb-10 fv-row">
                                <?php                                                                           
                                    $data = [
                                        "label"          => "1 mt/kg",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'mtkg',
                                            'id'    => '',
                                            'value' => trim($result_data->mtkg),
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
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'code',
                                            'id'    => '',
                                            'value' => trim($result_data->code),
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">                              
                                <?php
                                    foreach($all_categories as $all_category){
                                        $a_options[$all_category->id] = $all_category->title;
                                    }                                
                                    $avalue = explode(",",$result_data->category);                                    
                                    $data = [
                                        "label"          => "Category",
                                        "label_required" => "",
                                        "type"           => "selectmultiple",
                                        "type_data"      => [
                                            'name'  => 'category[]',
                                            'options'  => $a_options,
                                            'value' => $avalue,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                    
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">                              
                                <?php
                                    foreach($all_colors as $all_color){
                                        $c_options[$all_color->id] = $all_color->title;
                                    }                                
                                    $acvalue = explode(",",$result_data->colors);                                    
                                    $data = [
                                        "label"          => "Color",
                                        "label_required" => "",
                                        "type"           => "selectmultiple",
                                        "type_data"      => [
                                            'name'  => 'colors[]',
                                            'options'  => $c_options,
                                            'value' => $acvalue,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            
                            
                            
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::General options-->
                    <!--begin:::Tabs-->
                    <div>
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
                                <div class="card card-flush rounded-0 py-4">
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
                                                    "label"          => "About",
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
                                                    "label"          => "Keywords",
                                                    "label_required" => "",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'id'    => 'keywords_'.$counter_1_check,
                                                        'value' => $language_data->keywords,
                                                        'class' => 'form-control tags keywords_'.$counter_1_check,
                                                    ]
                                                ];
                                                echo html_form_tags($data);
                                                $data_hidden = [
                                                        'type'  => 'hidden',
                                                        'name'  => 'keywords_'.$key_lang,
                                                        'id'    => 'hidden_keywords_'.$counter_1_check,
                                                        'value' => $language_data->keywords,
                                                ];
                                                echo form_input($data_hidden);
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
                                                        'name'  => 'short_description_'.$key_lang,
                                                        'id'    => '',
                                                        'value' => trim($language_data->short_description),
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