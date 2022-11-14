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
                            <?php if($adminDetails->role != 'Branch Admin') { ?>
                            <!--begin::Input group-->            
                            <div class="mb-10 fv-row">                                            
                            <?php                                
                                foreach($employees as $employee){
                                    $eoptions[$employee->id] = $employee->first_name.' '.$employee->last_name;
                                }                                 
                                $data = [
                                    "label"          => "Employees",
                                    "label_required" => "",
                                    "type"           => "select",
                                    "type_data"      => [
                                        'name'  => 'employee',
                                        'options'  => $eoptions,
                                        'value' => $result_data->employee,
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
                                        "label"          => "Project name",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'project',
                                            'id'    => '',
                                            'value' => $result_data->project,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <?php } else { ?>
                                <input type="hidden" id="employee" name="employee" value="<?=$adminDetails->employee_id?>">
                                <input type="hidden" id="project" name="project" value="">
                            <?php } ?>
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <?php                               
                                    $data = [
                                        "label"          => "Client",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'buyer',
                                            'id'    => '',
                                            'value' => $result_data->buyer,
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
                                        "label"          => "Client's phone",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'phone',
                                            'id'    => '',
                                            'value' => $result_data->phone,
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
                                        "label"          => "Client's email",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'email',
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
                                        "label"          => "Address or zipcode",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'address',
                                            'id'    => '',
                                            'value' => $result_data->address,
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
    
</script>