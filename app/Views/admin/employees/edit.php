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
                                foreach($all_branches as $all_branch){
                                    $options[$all_branch->id] = $all_branch->name;                                    
                                }                                
                                $data = [
                                    "label"          => "Branches",
                                    "label_required" => "",
                                    "type"           => "select",
                                    "type_data"      => [
                                        'name'  => 'branch_id',
                                        'options'  => $options,
                                        'value' => $result_data->branch_id,
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
                                        "label"          => "First name",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'first_name',
                                            'id'    => '',
                                            'value' => $result_data->first_name,
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
                                        "label"          => "Last name",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'last_name',
                                            'id'    => '',
                                            'value' => $result_data->last_name,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                    
                                ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->            
                            <div class="mb-10 fv-row">                                            
                            <?php                            
                                foreach($all_positions as $all_position){
                                    $p_options[$all_position->id] = $all_position->title;                                    
                                } 
                                $pvalues = explode(",",$result_data->position);
                                $data = [
                                    "label"          => "Position",
                                    "label_required" => "",
                                    "type"           => "selectmultiple",
                                    "type_data"      => [
                                        'name'  => 'position[]',
                                        'options'  => $p_options,
                                        'value' => $pvalues,
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
                                        "label"          => "Email",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'email',
                                            'id'    => '',
                                            'value' => $result_data->email,
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
                                        "label"          => "Phone",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'mobile',
                                            'id'    => '',
                                            'value' => $result_data->mobile,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="form-check form-check-custom form-check-solid mb-2">
                                <?php                               
                                    $data = [
                                            "label"          => "Representative",
                                            "label_required" => "",
                                            "labelclass"     => "form-check-label mx-2",
                                            "type"           => "checkbox",
                                            "type_data"      => [
                                                'name'       => 'rep',
                                                'class'      => 'form-check-input',
                                                'style'      => 'margin:10px',
                                                'value'      => 1,
                                                'checked'    => $result_data->rep ? true : false,
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

<script type="text/javascript">    
    //tagfunction();
    //quillfunction();
</script>