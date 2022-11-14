<?php
    $result_data = $thisItems[0];    
?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl row">
            <!--begin::Form-->
            <?=view('admin/includes/common/errors')?>
            <?=form_open_multipart('', 'class="form d-flex flex-column flex-lg-row editform" id="editform" name="editform"')?>
                <!--begin::Aside column-->
                <div class="col-lg-2 d-flex flex-column gap-7 gap-lg-10 mb-7 me-lg-10">
                    <?php
                        foreach($images_array as $key=>$images){
                            $img = !isset($result_data->{$key})?$noimage:base_url($uploadFolder.'/'.$result_data->{$key});
                            $imagedata = [
                                "label" => $images,
                                "noimage" => $noimage,
                                "image" => $img,
                                "name" => $key,
                                "value" => $result_data->{$key},
                                "description" => 'Allowed file types: png, jpg, jpeg.'
                            ];
                            echo view('admin/includes/common/image',$imagedata);
                        }
                    ?>
                </div>
                <!--end::Aside column-->
                <!--begin::Main column-->
                <div class="col-lg-10 d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

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
                                        "label"          => "Key Name",
                                        "label_required" => "required",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'keyname',
                                            'id'    => '',
                                            'value' => $result_data->keyname,
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
                                        "label"          => "Discount Percent",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'discount',
                                            'id'    => '',
                                            'value' => $result_data->discount,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <div class="d-flex flex-wrap gap-5">
                            <div class="fv-row w-100 flex-md-root fv-plugins-icon-container">
                                <?php
                                    $options = [
                                        '1'  => 'Online',
                                        '0'  => 'Offline'
                                    ];
                                    $data = [
                                        "label"          => "Website active",
                                        "label_required" => "required",
                                        "type"           => "select",
                                        "type_data"      => [
                                            'name'  => 'website_active',
                                            'options'  => $options,
                                            'value' => $result_data->website_active,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <div class="fv-row w-100 flex-md-root">
                                <?php
                                    $data = [
                                        "label"          => "Main Email",
                                        "label_required" => "required",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'email',
                                            'name'  => 'site_email',
                                            'id'    => '',
                                            'value' => $result_data->site_email,
                                        ]
                                    ];
                                    echo html_form_tags($data);;
                                ?>
                            </div>
                            </div>
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::General options-->

                    <!--begin:::Tabs-->
                    <div>
                    
                    <?=view('admin/includes/common/langstab')?>
                    
                    <!--end:::Tabs-->
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <?php
                            $counter_1 = 1;
                            foreach($ThisModule->languages as $key_lang=>$val_lang) {
                            $language_data = get_admin_conn_lang($_lang_table_names,1,$key_lang);
                            //pp($language_data,false);
                        ?>
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade <?=($counter_1 == 1)?'active show':''?>" id="tab_<?=$counter_1?>" role="tab-panel">
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
                                                    "label_required" => "required",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'name'  => 'title_'.$key_lang,
                                                        'id'    => '',
                                                        'value' => $language_data->title,
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
                                                    "label_required" => "required",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'id'    => 'tags_'.$counter_1,
                                                        'value' => $language_data->meta_keyword,
                                                        'class' => 'form-control tags tags_'.$counter_1,
                                                    ]
                                                ];
                                                echo html_form_tags($data);
                                                $data_hidden = [
                                                        'type'  => 'hidden',
                                                        'name'  => 'meta_keyword_'.$key_lang,
                                                        'id'    => 'hidden_tags_'.$counter_1,
                                                        'value' => $language_data->meta_keyword,
                                                ];
                                                echo form_input($data_hidden);
                                            ?>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <?php                                                                           
                                                $data = [
                                                    "label"          => "Meta description",
                                                    "label_required" => "required",
                                                    "type"           => "textarea",
                                                    "type_data"      => [
                                                        'name'  => 'meta_desc_'.$key_lang,
                                                        'id'    => '',
                                                        'value' => $language_data->meta_desc,
                                                        'rows'  => '4'
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
                                                    "label"          => "Site name",
                                                    "label_required" => "required",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'name'  => 'site_name_'.$key_lang,
                                                        'id'    => '',
                                                        'value' => $language_data->site_name,
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
                                                    "label"          => "Owner",
                                                    "label_required" => "required",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'name'  => 'owner_'.$key_lang,
                                                        'id'    => '',
                                                        'value' => $language_data->owner,
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
                                                    "label"          => "Author",
                                                    "label_required" => "required",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'name'  => 'author_'.$key_lang,
                                                        'id'    => '',
                                                        'value' => $language_data->author,
                                                    ]
                                                ];
                                                echo html_form_tags($data);
                                            ?>
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row" id="quillarea_<?=$counter_1?>">
                                            <?php                                                                           
                                                $data = [
                                                    "label"          => "Offline Data",
                                                    "label_required" => "",
                                                    "type"           => "textarea",
                                                    "type_data"      => [
                                                        'name'  => 'offline_data_'.$key_lang,
                                                        'id'    => 'form_editor_'.$counter_1,
                                                        'value' => $language_data->offline_data,
                                                        'class' => 'form-control form-control-solid form_editor form_editor_'.$counter_1,
                                                        'rows'  => '4',
                                                        'data-counter'  => $counter_1
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
                            </div>
                        </div>
                        <!--end::Tab pane-->
                        <?php $counter_1++;} ?>
                    </div>
                    </div>
                    <!--end::Tab content-->
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
    tagfunction();
    quillfunction();
</script>