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
                                    $data = [
                                        "label"          => "Video Link",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'video',
                                            'id'    => '',
                                            'value' => $result_data->video,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-wrap mb-10 gap-5">
                                <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                                    <?php                               
                                        $data = [
                                            "label"          => "Background Color",
                                            "label_required" => "",
                                            "type"           => "input",
                                            "type_data"      => [
                                                'type'  => 'color',
                                                'name'  => '',
                                                'id'    => 'bgcolor',
                                                'value' => $result_data->bcolor,
                                                'style' => 'height: 55px;',
                                            ]
                                        ];
                                        echo html_form_tags($data);
                                    ?>
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <?php                               
                                        $data = [
                                            "label"          => "&nbsp;",
                                            "label_required" => "",
                                            "type"           => "input",
                                            "type_data"      => [
                                                'type'  => 'text',
                                                'name'  => 'bcolor',
                                                'id'    => 'bgcolortext',
                                                'value' => $result_data->bcolor,
                                                'style' => 'height: 55px;',
                                            ]
                                        ];
                                        echo html_form_tags($data);
                                    ?>
                                </div>
                            </div>
                            <div class="mb-10 fv-row">                              
                                <?php
                                    foreach($all_applications as $value) {
                                        $languagedataapplications = get_admin_conn_lang($_lang_applications,$value->id,$admin_lang);
                                        $a_options[$value->id] = $languagedataapplications->title;
                                    }
                                    $avalue = explode(",",$result_data->seapplication);
                                    
                                    $data = [
                                        "label"          => "Applications",
                                        "label_required" => "",
                                        "type"           => "selectmultiple",
                                        "type_data"      => [
                                            'name'  => 'seapplication[]',
                                            'options'  => $a_options,
                                            'value' => $avalue,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <div class="mb-10 fv-row">                              
                                <?php
                                    foreach($all_colorcats as $value) {
                                        $languagedatacolorcats = get_admin_conn_lang($_lang_applications,$value->id,$admin_lang);
                                        $c_options[$value->id] = $languagedatacolorcats->title;
                                    }
                                    $cvalue = explode(",",$result_data->secolorcats);
                                    $data = [
                                        "label"          => "Color category",
                                        "label_required" => "",
                                        "type"           => "selectmultiple",
                                        "type_data"      => [
                                            'name'  => 'secolorcats[]',
                                            'options'  => $c_options,
                                            'value' => $cvalue,
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
                                        <div class="mb-10 fv-row">
                                            <?php                                                                           
                                                $data = [
                                                    "label"          => "Secondary info",
                                                    "label_required" => "",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'name'  => 'secondary_'.$key_lang,
                                                        'id'    => '',
                                                        'value' => trim($language_data->secondary),
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
                                                    "label"          => "Tags",
                                                    "label_required" => "required",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'id'    => 'tags_'.$counter_1_check,
                                                        'value' => $language_data->tags,
                                                        'class' => 'form-control tags tags_'.$counter_1_check,
                                                    ]
                                                ];
                                                echo html_form_tags($data);
                                                $data_hidden = [
                                                        'type'  => 'hidden',
                                                        'name'  => 'tags_'.$key_lang,
                                                        'id'    => 'hidden_tags_'.$counter_1_check,
                                                        'value' => $language_data->tags,
                                                ];
                                                echo form_input($data_hidden);
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
                                                        'name'  => 'about_'.$key_lang,
                                                        'id'    => 'form_editor_'.$counter_1_check,
                                                        'value' => $language_data->about,
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
                                        <?php $extrafield = "more_".$counter_1_check;?>
                                        <div class="mb-10 fv-row" id="quillarea_<?=$extrafield?>">
                                            <?php                                                                           
                                                $data = [
                                                    "label"          => "More",
                                                    "label_required" => "",
                                                    "type"           => "textarea",
                                                    "type_data"      => [
                                                        'name'  => 'more_'.$key_lang,
                                                        'id'    => 'form_editor_'.$extrafield,
                                                        'value' => $language_data->more,
                                                        'class' => 'form-control form-control-solid form_editor form_editor_'.$extrafield,
                                                        'rows'  => '4',
                                                        'data-counter'  => $extrafield
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
    $('#bgcolor').on('input',
        function() {
            $('#bgcolortext').val($(this).val());
        }
    );
    $('#bgcolortext').on('input',
        function() {
            $('#bgcolor').val($(this).val());
        }
    ); 
</script>