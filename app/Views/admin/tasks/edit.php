<?php
    error_reporting(0);
    $result_data = isset($id)?$thisItems[0]:$thisItems;
    $counter = 0;
    $thisEmployee = get_langer('employees',false,$adminDetails->employee_id); 
    $thisbranch = get_langer('branches',$admin_lang,$thisEmployee->branch_id);
    foreach($employees as $employee) { $optiondata[$employee->id] = $employee->first_name.' '.$employee->last_name; }
    //$loggedinuser = $_thisData['loggedinuser'];
    
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
                                                          
                                    $options[$result_data->by] = $optiondata[$result_data->by];                                
                                    $data = [
                                        "label"          => "By",
                                        "label_required" => "",
                                        "type"           => "select",
                                        "type_data"      => [
                                            'name'  => 'by',
                                            'options'  => $options,
                                            'value' => $result_data->by,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">                              
                                <?php                                
                                    $options = [];                                
                                    $data = [
                                        "label"          => "Assigned",
                                        "label_required" => "",
                                        "type"           => "select",
                                        "type_data"      => [
                                            'name'  => 'assigned',
                                            'options'  => $optiondata,
                                            'value' => $result_data->assigned,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>                            
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">                              
                                <?php                                
                                    $options = [];                                
                                    $data = [
                                        "label"          => "Type",
                                        "label_required" => "",
                                        "type"           => "select",
                                        "type_data"      => [
                                            'name'  => 'type',
                                            'options'  => $typedata,
                                            'value' => $result_data->type,
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>                            
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">                              
                                <?php                                
                                    $options = [];                                
                                    $data = [
                                        "label"          => "Status",
                                        "label_required" => "",
                                        "type"           => "select",
                                        "type_data"      => [
                                            'name'  => 'status',
                                            'options'  => $statusdata,
                                            'value' => $result_data->status,
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
                                        "label"          => "Task Title",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'title',
                                            'id'    => '',
                                            'value' => trim($result_data->title),
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
                                        "label"          => "Deadline",
                                        "label_required" => "",
                                        "type"           => "input",
                                        "type_data"      => [
                                            'type'  => 'text',
                                            'name'  => 'deadline',
                                            'id'    => '',
                                            'value' => trim($result_data->deadline),
                                        ]
                                    ];
                                    echo html_form_tags($data);
                                ?>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row" id="quillarea_task_<?=$counter?>">
                                <?php                                                                           
                                    $data = [
                                        "label"          => "Task Explanation",
                                        "label_required" => "",
                                        "type"           => "textarea",
                                        "type_data"      => [
                                            'name'  => 'explanation',
                                            'id'    => 'form_editor_task_'.$counter,
                                            'value' => $result_data->explanation,
                                            'class' => 'form-control form-control-solid form_editor form_editor_task_'.$counter,
                                            'rows'  => '4',
                                            'data-counter'  => "task_".$counter
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

                    <?php if($adminDetails->employee_id == $result_data->by) { ?>
                        <?=view('admin/includes/common/button')?>
                    <?php } else { ?>
                        <div class="d-flex justify-content-end">
                            <a href="https://schildr.oawo.com/manage/tasks" id="kt_modal_new_target_cancel" name="" rel="" class="btn btn-light me-5">Cancel</a>
                        </div>
                   <?php } ?>
                   
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
    quillfunction();     
</script>