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
                                        "label"          => "Code",
                                        "label_required" => "",
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
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                            <?php                                                                           
                                $data = [
                                    "label"          => "Domains",
                                    "label_required" => "required",
                                    "type"           => "input",
                                    "type_data"      => [
                                        'type'  => 'text',
                                        'id'    => 'tags_'.$counter,
                                        'value' => $result_data->domains,
                                        'class' => 'form-control tags tags_'.$counter,
                                    ]
                                ];
                                echo html_form_tags($data);
                                $data_hidden = [
                                        'type'  => 'hidden',
                                        'name'  => 'domains',
                                        'id'    => 'hidden_tags_'.$counter,
                                        'value' => $result_data->domains,
                                ];
                                echo form_input($data_hidden);

                                
                            ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <?php
                                    foreach($alllangs as $lvalues){
                                        $options[$lvalues->id] = $lvalues->language;
                                    }
                                    //pp($result_data,false);
                                    $langvalue = explode(",",$result_data->selang);
                                    $data = [
                                        "label"          => "Active Languages",
                                        "label_required" => "required",
                                        "type"           => "selectmultiple",
                                        "type_data"      => [
                                            'name'  => 'selang[]',
                                            'options'  => $options,
                                            'value' => $langvalue,
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
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <?php
                            
                            $counter_1 = 1;
                            foreach($ThisModule->languages as $key_lang=>$val_lang) {
                            $language_data = get_admin_conn_lang($_lang_table_names,$id,$key_lang);
                            //pp($language_data);
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
                                                    "label"          => "Message",
                                                    "label_required" => "",
                                                    "type"           => "input",
                                                    "type_data"      => [
                                                        'type'  => 'text',
                                                        'name'  => 'message_'.$key_lang,
                                                        'id'    => '',
                                                        'value' => $language_data->message,
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
</script>